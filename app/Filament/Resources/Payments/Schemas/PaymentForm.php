<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('payment_number')
                    ->required(),
                Select::make('invoice_id')
                    ->relationship('invoice', 'id')
                    ->required(),
                Select::make('reservation_id')
                    ->relationship('reservation', 'id')
                    ->required(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Select::make('payment_method')
                    ->options([
            'cash' => 'Cash',
            'credit_card' => 'Credit card',
            'debit_card' => 'Debit card',
            'bank_transfer' => 'Bank transfer',
            'online' => 'Online',
            'other' => 'Other',
        ])
                    ->default('cash')
                    ->required(),
                TextInput::make('transaction_id')
                    ->default(null),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'completed' => 'Completed',
            'failed' => 'Failed',
            'refunded' => 'Refunded',
        ])
                    ->default('completed')
                    ->required(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('payment_date')
                    ->required(),
                TextInput::make('processed_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
