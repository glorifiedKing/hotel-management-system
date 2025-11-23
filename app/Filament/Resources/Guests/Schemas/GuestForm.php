<?php

namespace App\Filament\Resources\Guests\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class GuestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('country')
                    ->default(null),
                TextInput::make('id_type')
                    ->default(null),
                TextInput::make('id_number')
                    ->default(null),
                DatePicker::make('date_of_birth'),
                Textarea::make('address')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('city')
                    ->default(null),
                TextInput::make('state')
                    ->default(null),
                TextInput::make('postal_code')
                    ->default(null),
                Select::make('guest_type')
                    ->options(['regular' => 'Regular', 'vip' => 'Vip', 'corporate' => 'Corporate'])
                    ->default('regular')
                    ->required(),
                TextInput::make('loyalty_points')
                    ->required()
                    ->numeric()
                    ->default(0),
                Textarea::make('preferences')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
