<?php

namespace App\Filament\Resources\RestaurantTables\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RestaurantTableForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('restaurant_id')
                    ->relationship('restaurant', 'name')
                    ->default(null),
                TextInput::make('table_number')
                    ->required(),
                TextInput::make('location')
                    ->default(null),
                TextInput::make('capacity')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
            'available' => 'Available',
            'occupied' => 'Occupied',
            'reserved' => 'Reserved',
            'cleaning' => 'Cleaning',
        ])
                    ->default('available')
                    ->required(),
                TextInput::make('section')
                    ->default(null),
                TextInput::make('floor')
                    ->required()
                    ->numeric()
                    ->default(1),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
