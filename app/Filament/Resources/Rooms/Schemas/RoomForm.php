<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class RoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('room_number')
                    ->required(),
                Select::make('room_type_id')
                    ->relationship('roomType', 'name')
                    ->required(),
                TextInput::make('floor')
                    ->required(),
                Select::make('status')
                    ->options([
            'available' => 'Available',
            'occupied' => 'Occupied',
            'maintenance' => 'Maintenance',
            'reserved' => 'Reserved',
            'cleaning' => 'Cleaning',
        ])
                    ->default('available')
                    ->required(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_smoking')
                    ->required(),
                Toggle::make('is_accessible')
                    ->required(),
            ]);
    }
}
