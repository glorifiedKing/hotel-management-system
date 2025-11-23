<?php

namespace App\Filament\Resources\InventoryItems\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InventoryItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('sku')
                    ->label('SKU')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('unit_of_measurement')
                    ->required(),
                TextInput::make('current_stock')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('minimum_stock')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('maximum_stock')
                    ->numeric()
                    ->default(null),
                TextInput::make('reorder_point')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('cost_per_unit')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('storage_location')
                    ->default(null),
                DatePicker::make('expiry_date'),
                Toggle::make('is_perishable')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
