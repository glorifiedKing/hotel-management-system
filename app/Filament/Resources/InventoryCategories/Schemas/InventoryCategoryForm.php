<?php

namespace App\Filament\Resources\InventoryCategories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InventoryCategoryForm
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
                Select::make('type')
                    ->options([
            'food' => 'Food',
            'beverage' => 'Beverage',
            'supplies' => 'Supplies',
            'equipment' => 'Equipment',
        ])
                    ->default('food')
                    ->required(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
