<?php

namespace App\Filament\Resources\Restaurants\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RestaurantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options([
            'restaurant' => 'Restaurant',
            'bar' => 'Bar',
            'cafe' => 'Cafe',
            'lounge' => 'Lounge',
            'other' => 'Other',
        ])
                    ->default('restaurant')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('location')
                    ->default(null),
                TextInput::make('floor')
                    ->numeric()
                    ->default(null),
                TimePicker::make('opening_time'),
                TimePicker::make('closing_time'),
                TextInput::make('seating_capacity')
                    ->numeric()
                    ->default(null),
                Select::make('kitchen_id')
                    ->relationship('kitchen', 'name')
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
                Toggle::make('accepts_reservations')
                    ->required(),
                Textarea::make('operating_days')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
