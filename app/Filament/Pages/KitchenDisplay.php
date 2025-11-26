<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\KitchenOrder;
use App\Models\KitchenOrderItem;
use App\Models\Kitchen;
use Filament\Notifications\Notification;
use BackedEnum;
use UnitEnum;

class KitchenDisplay extends Page
{
    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-fire';

    protected static string | UnitEnum | null $navigationGroup = 'Point of Sale';

    protected static ?string $navigationLabel = 'Kitchen Display';

    protected static ?string $title = 'Kitchen Display System';

    protected static ?int $navigationSort = 3;

    protected string $view;

    // Auto-refresh every 10 seconds
    protected static ?string $pollingInterval = '10s';

    public $selectedKitchen = null;

    public function mount(): void
    {
        $this->view = 'filament.pages.kitchen-display';

        // Auto-select first active kitchen if available
        $firstKitchen = Kitchen::where('is_active', true)->first();
        if ($firstKitchen) {
            $this->selectedKitchen = $firstKitchen->id;
        }
    }

    public function getKitchens()
    {
        return Kitchen::where('is_active', true)->get();
    }

    public function selectKitchen($kitchenId)
    {
        $this->selectedKitchen = $kitchenId;
    }

    public function getOrders()
    {
        if (!$this->selectedKitchen) {
            return collect([]);
        }

        return KitchenOrder::with(['restaurantTable', 'items.service', 'waiter'])
            ->where('kitchen_id', $this->selectedKitchen)
            ->whereIn('status', ['pending', 'confirmed', 'preparing'])
            ->orderBy('order_time', 'asc')
            ->get();
    }

    public function getReadyOrders()
    {
        if (!$this->selectedKitchen) {
            return collect([]);
        }

        return KitchenOrder::with(['restaurantTable', 'items.service'])
            ->where('kitchen_id', $this->selectedKitchen)
            ->where('status', 'ready')
            ->orderBy('prepared_at', 'desc')
            ->limit(10)
            ->get();
    }

    public function confirmOrder($orderId)
    {
        $order = KitchenOrder::find($orderId);
        $order->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        Notification::make()
            ->success()
            ->title('Order Confirmed')
            ->body('Order #' . $order->order_number)
            ->send();
    }

    public function startPreparingOrder($orderId)
    {
        $order = KitchenOrder::find($orderId);
        $order->update([
            'status' => 'preparing',
        ]);

        // Mark all items as preparing
        $order->items()->update([
            'status' => 'preparing',
            'started_at' => now(),
        ]);

        Notification::make()
            ->success()
            ->title('Preparation Started')
            ->body('Order #' . $order->order_number)
            ->send();
    }

    public function markOrderReady($orderId)
    {
        $order = KitchenOrder::find($orderId);
        $order->update([
            'status' => 'ready',
            'prepared_at' => now(),
        ]);

        // Mark all items as ready
        $order->items()->update([
            'status' => 'ready',
            'completed_at' => now(),
        ]);

        Notification::make()
            ->success()
            ->title('Order Ready')
            ->body('Order #' . $order->order_number . ' is ready for serving')
            ->send();
    }

    public function markItemReady($itemId)
    {
        $item = KitchenOrderItem::find($itemId);
        $item->update([
            'status' => 'ready',
            'completed_at' => now(),
        ]);

        // Check if all items are ready
        $order = $item->kitchenOrder;
        $allReady = $order->items()->where('status', '!=', 'ready')->count() === 0;

        if ($allReady) {
            $this->markOrderReady($order->id);
        }
    }

    public function getOrderElapsedTime($order)
    {
        $orderTime = \Carbon\Carbon::parse($order->order_time);
        $now = now();
        $minutes = $orderTime->diffInMinutes($now);

        return $minutes;
    }
}
