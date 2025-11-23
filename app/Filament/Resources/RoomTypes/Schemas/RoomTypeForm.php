<?php

namespace App\Filament\Resources\RoomTypes\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RoomTypeForm
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
                TextInput::make('base_price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('max_occupancy')
                    ->required()
                    ->numeric(),
                TextInput::make('default_occupancy')
                    ->required()
                    ->numeric()
                    ->default(2),
                Textarea::make('features')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
