<?php

namespace App\Filament\Resources\Reservations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ReservationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('reservation_number')
                    ->required(),
                Select::make('guest_id')
                    ->relationship('guest', 'id')
                    ->required(),
                DatePicker::make('check_in_date')
                    ->required(),
                DatePicker::make('check_out_date')
                    ->required(),
                TextInput::make('number_of_guests')
                    ->required()
                    ->numeric(),
                TextInput::make('number_of_rooms')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'checked_in' => 'Checked in',
            'checked_out' => 'Checked out',
            'cancelled' => 'Cancelled',
            'no_show' => 'No show',
        ])
                    ->default('pending')
                    ->required(),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('deposit_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('booking_source')
                    ->options([
            'walk_in' => 'Walk in',
            'phone' => 'Phone',
            'email' => 'Email',
            'website' => 'Website',
            'third_party' => 'Third party',
        ])
                    ->default('walk_in')
                    ->required(),
                Textarea::make('special_requests')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('checked_in_at'),
                DateTimePicker::make('checked_out_at'),
                TextInput::make('created_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
