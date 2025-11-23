<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('invoice_number')
                    ->required(),
                Select::make('reservation_id')
                    ->relationship('reservation', 'id')
                    ->required(),
                Select::make('guest_id')
                    ->relationship('guest', 'id')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('tax_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('paid_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('balance_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'issued' => 'Issued',
            'partially_paid' => 'Partially paid',
            'paid' => 'Paid',
            'overdue' => 'Overdue',
            'cancelled' => 'Cancelled',
        ])
                    ->default('draft')
                    ->required(),
                DatePicker::make('issue_date')
                    ->required(),
                DatePicker::make('due_date'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
