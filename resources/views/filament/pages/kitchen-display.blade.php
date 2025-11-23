<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Kitchen Selector -->
        <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
            <h3 class="text-sm font-semibold mb-3">Select Kitchen</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($this->getKitchens() as $kitchen)
                    <button wire:click="selectKitchen({{ $kitchen->id }})" 
                        class="px-4 py-2 rounded-lg transition-all {{ $selectedKitchen === $kitchen->id ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300' }}">
                        {{ $kitchen->name }}
                        @if($kitchen->type)
                            <span class="text-xs opacity-75">({{ ucfirst($kitchen->type) }})</span>
                        @endif
                    </button>
                @endforeach
            </div>
            @if(!$selectedKitchen)
                <div class="mt-2 text-sm text-yellow-600 dark:text-yellow-400">
                    ⚠️ Please select a kitchen to view orders
                </div>
            @endif
        </div>

        @if($selectedKitchen)
            <!-- Active Orders -->
            <div wire:poll.10s>
                <h2 class="text-2xl font-bold mb-4">Active Orders</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($this->getOrders() as $order)
                        @php
                            $elapsedTime = $this->getOrderElapsedTime($order);
                            $isUrgent = $elapsedTime > 15;
                            $isWarning = $elapsedTime > 10;
                        @endphp
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 border-l-4 
                            {{ $order->status === 'pending' ? 'border-yellow-500' : '' }}
                            {{ $order->status === 'confirmed' ? 'border-blue-500' : '' }}
                            {{ $order->status === 'preparing' ? 'border-orange-500' : '' }}
                            {{ $isUrgent ? 'bg-red-50 dark:bg-red-900' : '' }}">
                            
                            <!-- Order Header -->
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <div class="text-2xl font-bold text-primary-600">
                                        #{{ $order->order_number }}
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-400">
                                        @if($order->restaurant)
                                            {{ $order->restaurant->name }} -
                                        @endif
                                        Table {{ $order->restaurantTable->table_number }}
                                        <span class="ml-2">👥 {{ $order->number_of_guests }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-lg font-semibold 
                                        {{ $isUrgent ? 'text-red-600' : ($isWarning ? 'text-orange-600' : 'text-gray-600') }}">
                                        {{ $elapsedTime }} min
                                    </div>
                                    <div class="text-xs">
                                        <span class="px-2 py-1 rounded-full text-white
                                            {{ $order->status === 'pending' ? 'bg-yellow-500' : '' }}
                                            {{ $order->status === 'confirmed' ? 'bg-blue-500' : '' }}
                                            {{ $order->status === 'preparing' ? 'bg-orange-500' : '' }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Order Time -->
                            <div class="text-xs text-gray-500 mb-3">
                                Ordered: {{ $order->order_time->format('H:i') }}
                                @if($order->waiter)
                                    | By: {{ $order->waiter->name }}
                                @endif
                            </div>

                            <!-- Order Items -->
                            <div class="space-y-2 mb-4 max-h-48 overflow-y-auto">
                                @foreach($order->items as $item)
                                    <div class="p-2 rounded 
                                        {{ $item->status === 'pending' ? 'bg-yellow-50 dark:bg-yellow-900' : '' }}
                                        {{ $item->status === 'preparing' ? 'bg-orange-50 dark:bg-orange-900' : '' }}
                                        {{ $item->status === 'ready' ? 'bg-green-50 dark:bg-green-900' : '' }}">
                                        <div class="flex justify-between items-center">
                                            <div class="flex-1">
                                                <span class="font-semibold">{{ $item->quantity }}x</span>
                                                <span class="ml-2">{{ $item->service->name }}</span>
                                                @if($item->service->preparation_time)
                                                    <span class="text-xs text-gray-500 ml-2">
                                                        ({{ $item->service->preparation_time }} min)
                                                    </span>
                                                @endif
                                            </div>
                                            @if($item->status !== 'ready')
                                                <button wire:click="markItemReady({{ $item->id }})"
                                                    class="text-xs px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded">
                                                    ✓ Ready
                                                </button>
                                            @else
                                                <span class="text-green-600 font-bold">✓</span>
                                            @endif
                                        </div>
                                        @if($item->special_instructions)
                                            <div class="text-xs text-red-600 mt-1 font-semibold">
                                                ⚠️ {{ $item->special_instructions }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                            @if($order->special_instructions)
                                <div class="mt-3 p-2 bg-yellow-50 dark:bg-yellow-900 rounded text-sm">
                                    <strong>Instructions:</strong> {{ $order->special_instructions }}
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="mt-4 space-y-2">
                                @if($order->status === 'pending')
                                    <button wire:click="confirmOrder({{ $order->id }})" 
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                        Confirm Order
                                    </button>
                                @endif
                                
                                @if($order->status === 'confirmed')
                                    <button wire:click="startPreparingOrder({{ $order->id }})" 
                                        class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg transition-colors">
                                        Start Preparing
                                    </button>
                                @endif
                                
                                @if($order->status === 'preparing')
                                    <button wire:click="markOrderReady({{ $order->id }})" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                        Mark as Ready
                                    </button>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-12 text-gray-500">
                            No active orders for this kitchen
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Ready Orders -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold mb-4 text-green-600">Ready for Serving</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @foreach($this->getReadyOrders() as $order)
                        <div class="bg-green-50 dark:bg-green-900 rounded-lg p-4 border-2 border-green-500">
                            <div class="text-xl font-bold">#{{ $order->order_number }}</div>
                            <div class="text-sm">
                                @if($order->restaurant)
                                    {{ $order->restaurant->name }} -
                                @endif
                                Table {{ $order->restaurantTable->table_number }}
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400 mt-2">
                                Ready: {{ $order->prepared_at->format('H:i') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                Please select a kitchen to view orders
            </div>
        @endif
    </div>
</x-filament-panels::page>
