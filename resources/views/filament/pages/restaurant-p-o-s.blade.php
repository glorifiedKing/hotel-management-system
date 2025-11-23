<x-filament-panels::page>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Side - Tables & Menu -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Restaurant Selector -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 shadow">
                <h3 class="text-sm font-semibold mb-3">Select Restaurant</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($this->getRestaurants() as $restaurant)
                        <button wire:click="selectRestaurant({{ $restaurant->id }})" 
                            class="px-4 py-2 rounded-lg transition-all {{ $selectedRestaurant === $restaurant->id ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300' }}">
                            {{ $restaurant->name }}
                            @if($restaurant->type)
                                <span class="text-xs opacity-75">({{ ucfirst($restaurant->type) }})</span>
                            @endif
                        </button>
                    @endforeach
                </div>
                @if(!$selectedRestaurant)
                    <div class="mt-2 text-sm text-yellow-600 dark:text-yellow-400">
                        ⚠️ Please select a restaurant to continue
                    </div>
                @endif
            </div>

            <!-- Location Tabs -->
            <div class="flex gap-2 mb-4">
                <button wire:click="setLocation('restaurant')" 
                    class="px-4 py-2 rounded-lg {{ $selectedLocation === 'restaurant' ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                    Restaurant
                </button>
                <button wire:click="setLocation('bar')" 
                    class="px-4 py-2 rounded-lg {{ $selectedLocation === 'bar' ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                    Bar
                </button>
                <button wire:click="setLocation('outdoor')" 
                    class="px-4 py-2 rounded-lg {{ $selectedLocation === 'outdoor' ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                    Outdoor
                </button>
            </div>

            <!-- Tables Grid -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow">
                <h3 class="text-lg font-semibold mb-4">Tables</h3>
                @if($selectedRestaurant)
                    <div class="grid grid-cols-4 gap-4">
                        @forelse($this->getTables() as $table)
                            <button wire:click="selectTable({{ $table->id }})"
                                class="p-4 rounded-lg border-2 transition-all {{ $selectedTable === $table->id ? 'border-primary-600 bg-primary-50 dark:bg-primary-900' : 'border-gray-300 dark:border-gray-600' }} 
                                {{ $table->status === 'available' ? 'hover:border-primary-400' : '' }}
                                {{ $table->status === 'occupied' ? 'bg-red-50 dark:bg-red-900' : '' }}
                                {{ $table->status === 'reserved' ? 'bg-yellow-50 dark:bg-yellow-900' : '' }}">
                                <div class="text-center">
                                    <div class="text-2xl font-bold">{{ $table->table_number }}</div>
                                    <div class="text-xs mt-1">{{ $table->capacity }} seats</div>
                                    <div class="text-xs mt-1 capitalize">
                                        <span class="px-2 py-1 rounded-full text-white text-xs
                                            {{ $table->status === 'available' ? 'bg-green-500' : '' }}
                                            {{ $table->status === 'occupied' ? 'bg-red-500' : '' }}
                                            {{ $table->status === 'reserved' ? 'bg-yellow-500' : '' }}">
                                            {{ $table->status }}
                                        </span>
                                    </div>
                                </div>
                            </button>
                        @empty
                            <div class="col-span-4 text-center py-8 text-gray-500">
                                No tables available for this restaurant
                            </div>
                        @endforelse
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        Select a restaurant to view tables
                    </div>
                @endif
            </div>

            <!-- Menu Items -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Menu</h3>
                    <div class="flex gap-2">
                        <button wire:click="$set('selectedCategory', 'all')"
                            class="px-3 py-1 rounded {{ $selectedCategory === 'all' ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                            All
                        </button>
                        <button wire:click="$set('selectedCategory', 'food')"
                            class="px-3 py-1 rounded {{ $selectedCategory === 'food' ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                            Food
                        </button>
                        <button wire:click="$set('selectedCategory', 'beverage')"
                            class="px-3 py-1 rounded {{ $selectedCategory === 'beverage' ? 'bg-primary-600 text-white' : 'bg-gray-200 dark:bg-gray-700' }}">
                            Beverage
                        </button>
                    </div>
                </div>

                @if($selectedRestaurant)
                    <input type="text" wire:model.live="searchQuery" placeholder="Search menu items..."
                        class="w-full mb-4 px-4 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 max-h-96 overflow-y-auto">
                        @forelse($this->getMenuItems() as $item)
                            <button wire:click="addToCart({{ $item->id }})"
                                class="p-4 border rounded-lg hover:border-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900 transition-all text-left">
                                <div class="font-semibold">{{ $item->name }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $item->description }}</div>
                                <div class="text-lg font-bold text-primary-600 mt-2">${{ number_format($item->price, 2) }}</div>
                                @if($item->preparation_time)
                                    <div class="text-xs text-gray-500 mt-1">🕐 {{ $item->preparation_time }} min</div>
                                @endif
                            </button>
                        @empty
                            <div class="col-span-3 text-center py-8 text-gray-500">
                                No menu items available
                            </div>
                        @endforelse
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        Select a restaurant to view menu
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Side - Cart & Order -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-6 shadow sticky top-6">
                <h3 class="text-lg font-semibold mb-4">Current Order</h3>
                
                @if($selectedRestaurant)
                    <div class="mb-4 p-3 bg-primary-50 dark:bg-primary-900 rounded-lg">
                        <div class="font-semibold">
                            {{ \App\Models\Restaurant::find($selectedRestaurant)->name }}
                        </div>
                        @if($selectedTable)
                            <div class="text-sm mt-1">
                                Table: {{ \App\Models\RestaurantTable::find($selectedTable)->table_number }}
                            </div>
                        @endif
                    </div>
                @else
                    <div class="mb-4 p-3 bg-yellow-50 dark:bg-yellow-900 rounded-lg text-sm">
                        Please select a restaurant and table
                    </div>
                @endif

                <!-- Guest Count -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Number of Guests</label>
                    <input type="number" wire:model="numberOfGuests" min="1" 
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600">
                </div>

                <!-- Cart Items -->
                <div class="space-y-3 mb-4 max-h-60 overflow-y-auto">
                    @forelse($cart as $index => $item)
                        <div class="p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <div class="font-semibold text-sm flex-1">{{ $item['name'] }}</div>
                                <button wire:click="removeFromCart({{ $index }})" class="text-red-500 hover:text-red-700">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <button wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] - 1 }})"
                                        class="px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded">-</button>
                                    <span class="font-semibold">{{ $item['quantity'] }}</span>
                                    <button wire:click="updateQuantity({{ $index }}, {{ $item['quantity'] + 1 }})"
                                        class="px-2 py-1 bg-gray-200 dark:bg-gray-600 rounded">+</button>
                                </div>
                                <div class="font-semibold">${{ number_format($item['price'] * $item['quantity'], 2) }}</div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-8">
                            Cart is empty
                        </div>
                    @endforelse
                </div>

                <!-- Special Instructions -->
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Special Instructions</label>
                    <textarea wire:model="specialInstructions" rows="2" 
                        class="w-full px-3 py-2 border rounded-lg dark:bg-gray-700 dark:border-gray-600"
                        placeholder="Any special requests..."></textarea>
                </div>

                <!-- Total -->
                <div class="border-t pt-4 mb-4">
                    <div class="flex justify-between text-xl font-bold">
                        <span>Total:</span>
                        <span>${{ number_format($this->getCartTotal(), 2) }}</span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="space-y-2">
                    <button wire:click="placeOrder" 
                        class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition-colors"
                        @if(empty($cart) || !$selectedTable || !$selectedRestaurant) disabled @endif>
                        Place Order
                    </button>
                    <button wire:click="$set('cart', [])" 
                        class="w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 font-semibold py-2 rounded-lg transition-colors">
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
