<?php

namespace App\Filament\Resources\KitchenOrders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class KitchenOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('restaurant_id')
                    ->relationship('restaurant', 'name')
                    ->default(null),
                Select::make('kitchen_id')
                    ->relationship('kitchen', 'name')
                    ->default(null),
                TextInput::make('order_number')
                    ->required(),
                Select::make('restaurant_table_id')
                    ->relationship('restaurantTable', 'id')
                    ->default(null),
                Select::make('pos_order_id')
                    ->relationship('posOrder', 'id')
                    ->default(null),
                Select::make('guest_id')
                    ->relationship('guest', 'id')
                    ->default(null),
                Select::make('order_type')
                    ->options([
            'dine_in' => 'Dine in',
            'takeaway' => 'Takeaway',
            'room_service' => 'Room service',
            'delivery' => 'Delivery',
        ])
                    ->default('dine_in')
                    ->required(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'preparing' => 'Preparing',
            'ready' => 'Ready',
            'served' => 'Served',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('number_of_guests')
                    ->required()
                    ->numeric()
                    ->default(1),
                Textarea::make('special_instructions')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('order_time')
                    ->required(),
                DateTimePicker::make('confirmed_at'),
                DateTimePicker::make('prepared_at'),
                DateTimePicker::make('served_at'),
                Select::make('waiter_id')
                    ->relationship('waiter', 'name')
                    ->default(null),
                Select::make('chef_id')
                    ->relationship('chef', 'name')
                    ->default(null),
            ]);
    }
}
