<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\RestaurantTable;
use App\Models\Service;
use App\Models\KitchenOrder;
use App\Models\KitchenOrderItem;
use App\Models\Guest;
use App\Models\Restaurant;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use BackedEnum;

class RestaurantPOS extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-building-storefront';

    protected static ?string $navigationLabel = 'Restaurant POS';

    protected static ?string $title = 'Restaurant Point of Sale';

    protected static ?int $navigationSort = 1;

    protected string $view = 'filament.pages.restaurant-p-o-s';

    public $selectedRestaurant = null;
    public $selectedTable = null;
    public $selectedLocation = 'restaurant';
    public $cart = [];
    public $numberOfGuests = 1;
    public $specialInstructions = '';
    public $searchQuery = '';
    public $selectedCategory = 'all';

    public function mount(): void
    {
        $this->cart = [];

        // Auto-select first active restaurant if available
        $firstRestaurant = Restaurant::where('is_active', true)
            ->whereIn('type', ['restaurant', 'cafe'])
            ->first();
        if ($firstRestaurant) {
            $this->selectedRestaurant = $firstRestaurant->id;
        }
    }

    public function getRestaurants()
    {
        return Restaurant::where('is_active', true)
            ->whereIn('type', ['restaurant', 'cafe'])
            ->get();
    }

    public function selectRestaurant($restaurantId)
    {
        $this->selectedRestaurant = $restaurantId;
        $this->selectedTable = null;
        $this->cart = [];
    }

    public function getTables()
    {
        if (!$this->selectedRestaurant) {
            return collect([]);
        }

        return RestaurantTable::where('restaurant_id', $this->selectedRestaurant)
            ->where('is_active', true)
            ->orderBy('table_number')
            ->get();
    }

    public function getMenuItems()
    {
        if (!$this->selectedRestaurant) {
            return collect([]);
        }

        $query = Service::where('restaurant_id', $this->selectedRestaurant)
            ->where('is_available', true)
            ->whereIn('category', ['food', 'beverage']);

        if ($this->selectedCategory !== 'all') {
            $query->where('category', $this->selectedCategory);
        }

        if ($this->searchQuery) {
            $query->where('name', 'like', '%' . $this->searchQuery . '%');
        }

        return $query->orderBy('name')->get();
    }

    public function selectTable($tableId)
    {
        $this->selectedTable = $tableId;
        $table = RestaurantTable::find($tableId);

        // Check if table has active order
        $activeOrder = $table->currentOrder;
        if ($activeOrder) {
            // Load existing order items into cart
            $this->loadExistingOrder($activeOrder);
        }
    }

    public function loadExistingOrder($order)
    {
        $this->cart = [];
        foreach ($order->items as $item) {
            $this->cart[] = [
                'service_id' => $item->service_id,
                'name' => $item->service->name,
                'price' => $item->service->price,
                'quantity' => $item->quantity,
                'special_instructions' => $item->special_instructions,
            ];
        }
    }

    public function addToCart($serviceId)
    {
        $service = Service::find($serviceId);

        $existingIndex = collect($this->cart)->search(function ($item) use ($serviceId) {
            return $item['service_id'] == $serviceId;
        });

        if ($existingIndex !== false) {
            $this->cart[$existingIndex]['quantity']++;
        } else {
            $this->cart[] = [
                'service_id' => $service->id,
                'name' => $service->name,
                'price' => $service->price,
                'quantity' => 1,
                'special_instructions' => '',
            ];
        }

        Notification::make()
            ->success()
            ->title('Item added to cart')
            ->body($service->name . ' added successfully')
            ->send();
    }

    public function updateQuantity($index, $quantity)
    {
        if ($quantity <= 0) {
            unset($this->cart[$index]);
            $this->cart = array_values($this->cart);
        } else {
            $this->cart[$index]['quantity'] = $quantity;
        }
    }

    public function removeFromCart($index)
    {
        unset($this->cart[$index]);
        $this->cart = array_values($this->cart);
    }

    public function getCartTotal()
    {
        return collect($this->cart)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });
    }

    public function placeOrder()
    {
        if (!$this->selectedRestaurant) {
            Notification::make()
                ->danger()
                ->title('No restaurant selected')
                ->body('Please select a restaurant first')
                ->send();
            return;
        }

        if (!$this->selectedTable) {
            Notification::make()
                ->danger()
                ->title('No table selected')
                ->body('Please select a table first')
                ->send();
            return;
        }

        if (empty($this->cart)) {
            Notification::make()
                ->danger()
                ->title('Cart is empty')
                ->body('Please add items to cart first')
                ->send();
            return;
        }

        $table = RestaurantTable::find($this->selectedTable);
        $restaurant = Restaurant::find($this->selectedRestaurant);

        // Create kitchen order
        $kitchenOrder = KitchenOrder::create([
            'restaurant_id' => $this->selectedRestaurant,
            'kitchen_id' => $restaurant->kitchen_id,
            'restaurant_table_id' => $this->selectedTable,
            'order_type' => 'dine_in',
            'status' => 'pending',
            'number_of_guests' => $this->numberOfGuests,
            'special_instructions' => $this->specialInstructions,
            'order_time' => now(),
            'waiter_id' => Auth::id(),
        ]);

        // Add items to kitchen order
        foreach ($this->cart as $item) {
            KitchenOrderItem::create([
                'kitchen_order_id' => $kitchenOrder->id,
                'service_id' => $item['service_id'],
                'quantity' => $item['quantity'],
                'status' => 'pending',
                'special_instructions' => $item['special_instructions'],
            ]);
        }

        // Update table status
        $table->update(['status' => 'occupied']);

        Notification::make()
            ->success()
            ->title('Order placed successfully')
            ->body('Order #' . $kitchenOrder->order_number . ' sent to kitchen')
            ->send();

        // Clear cart
        $this->cart = [];
        $this->specialInstructions = '';
    }

    public function setLocation($location)
    {
        $this->selectedLocation = $location;
        $this->selectedTable = null;
    }
}
