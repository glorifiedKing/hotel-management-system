<?php

namespace App\Filament\Resources\Services\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('category')
                    ->options([
            'food' => 'Food',
            'beverage' => 'Beverage',
            'spa' => 'Spa',
            'laundry' => 'Laundry',
            'room_service' => 'Room service',
            'other' => 'Other',
        ])
                    ->default('other')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                Toggle::make('is_available')
                    ->required(),
                Toggle::make('is_taxable')
                    ->required(),
            ]);
    }
}
