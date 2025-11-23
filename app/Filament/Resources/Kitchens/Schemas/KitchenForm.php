<?php

namespace App\Filament\Resources\Kitchens\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class KitchenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Select::make('type')
                    ->options([
            'main' => 'Main',
            'bar' => 'Bar',
            'pastry' => 'Pastry',
            'cold' => 'Cold',
            'hot' => 'Hot',
            'other' => 'Other',
        ])
                    ->default('main')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('location')
                    ->default(null),
                TextInput::make('floor')
                    ->numeric()
                    ->default(null),
                TextInput::make('restaurant_id')
                    ->numeric()
                    ->default(null),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('max_concurrent_orders')
                    ->required()
                    ->numeric()
                    ->default(10),
                Textarea::make('specialties')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
