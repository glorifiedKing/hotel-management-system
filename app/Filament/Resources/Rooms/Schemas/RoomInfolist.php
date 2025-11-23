<?php

namespace App\Filament\Resources\Rooms\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class RoomInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('room_number'),
                TextEntry::make('roomType.name')
                    ->label('Room type'),
                TextEntry::make('floor'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('notes')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_smoking')
                    ->boolean(),
                IconEntry::make('is_accessible')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
