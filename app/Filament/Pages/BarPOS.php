<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\RestaurantTable;
use App\Models\Restaurant;
use App\Models\Service;
use App\Models\KitchenOrder;
use App\Models\KitchenOrderItem;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use BackedEnum;

class BarPOS extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-beaker';

    protected static ?string $navigationLabel = 'Bar POS';

    protected static ?string $title = 'Bar Point of Sale';

    protected static ?int $navigationSort = 2;

    protected string $view = 'filament.pages.bar-p-o-s';

    public $selectedBar = null;
    public $selectedTable = null;
    public $cart = [];
    public $numberOfGuests = 1;
    public $specialInstructions = '';
    public $searchQuery = '';
    public $selectedCategory = 'all';

    public function mount(): void
    {
        $this->cart = [];
        $this->view = 'filament.pages.bar-p-o-s';

        // Auto-select first active bar if available
        $firstBar = Restaurant::where('is_active', true)
            ->whereIn('type', ['bar', 'lounge'])
            ->first();
        if ($firstBar) {
            $this->selectedBar = $firstBar->id;
        }
    }

    public function getBars()
    {
        return Restaurant::where('is_active', true)
            ->whereIn('type', ['bar', 'lounge'])
            ->get();
    }

    public function selectBar($barId)
    {
        $this->selectedBar = $barId;
        $this->selectedTable = null;
        $this->cart = [];
    }

    public function getTables()
    {
        if (!$this->selectedBar) {
            return collect([]);
        }

        return RestaurantTable::where('restaurant_id', $this->selectedBar)
            ->where('is_active', true)
            ->orderBy('table_number')
            ->get();
    }

    public function getMenuItems()
    {
        if (!$this->selectedBar) {
            return collect([]);
        }

        $query = Service::where('restaurant_id', $this->selectedBar)
            ->where('is_available', true)
            ->where('category', 'beverage');

        if ($this->searchQuery) {
            $query->where('name', 'like', '%' . $this->searchQuery . '%');
        }

        return $query->orderBy('name')->get();
    }

    public function selectTable($tableId)
    {
        $this->selectedTable = $tableId;
        $table = RestaurantTable::find($tableId);

        $activeOrder = $table->currentOrder;
        if ($activeOrder) {
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
            ->title('Drink added to order')
            ->body($service->name)
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
        if (!$this->selectedBar) {
            Notification::make()
                ->danger()
                ->title('No bar selected')
                ->body('Please select a bar first')
                ->send();
            return;
        }

        if (!$this->selectedTable) {
            Notification::make()
                ->danger()
                ->title('No table selected')
                ->send();
            return;
        }

        if (empty($this->cart)) {
            Notification::make()
                ->danger()
                ->title('Cart is empty')
                ->send();
            return;
        }

        $table = RestaurantTable::find($this->selectedTable);
        $bar = Restaurant::find($this->selectedBar);

        $kitchenOrder = KitchenOrder::create([
            'restaurant_id' => $this->selectedBar,
            'kitchen_id' => $bar->kitchen_id,
            'restaurant_table_id' => $this->selectedTable,
            'order_type' => 'dine_in',
            'status' => 'pending',
            'number_of_guests' => $this->numberOfGuests,
            'special_instructions' => $this->specialInstructions,
            'order_time' => now(),
            'waiter_id' => Auth::id(),
        ]);

        foreach ($this->cart as $item) {
            KitchenOrderItem::create([
                'kitchen_order_id' => $kitchenOrder->id,
                'service_id' => $item['service_id'],
                'quantity' => $item['quantity'],
                'status' => 'pending',
                'special_instructions' => $item['special_instructions'],
            ]);
        }

        $table->update(['status' => 'occupied']);

        Notification::make()
            ->success()
            ->title('Order placed')
            ->body('Order #' . $kitchenOrder->order_number)
            ->send();

        $this->cart = [];
        $this->specialInstructions = '';
    }
}
