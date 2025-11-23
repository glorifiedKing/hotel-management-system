<?php

namespace App\Filament\Resources\PosOrders\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PosOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')
                    ->required(),
                Select::make('reservation_id')
                    ->relationship('reservation', 'id')
                    ->default(null),
                Select::make('guest_id')
                    ->relationship('guest', 'id')
                    ->default(null),
                Select::make('order_type')
                    ->options([
            'room_service' => 'Room service',
            'restaurant' => 'Restaurant',
            'bar' => 'Bar',
            'spa' => 'Spa',
            'other' => 'Other',
        ])
                    ->default('restaurant')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('tax_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'preparing' => 'Preparing',
            'ready' => 'Ready',
            'delivered' => 'Delivered',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                Toggle::make('charge_to_room')
                    ->required(),
                TextInput::make('served_by')
                    ->numeric()
                    ->default(null),
                DateTimePicker::make('order_time')
                    ->required(),
                DateTimePicker::make('delivered_at'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
