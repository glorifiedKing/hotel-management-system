<?php

namespace App\Filament\Resources\PurchaseOrders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class PurchaseOrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_number')
                    ->required(),
                Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->required(),
                DatePicker::make('order_date')
                    ->required(),
                DatePicker::make('expected_delivery_date'),
                DatePicker::make('actual_delivery_date'),
                Select::make('status')
                    ->options([
            'draft' => 'Draft',
            'pending' => 'Pending',
            'approved' => 'Approved',
            'received' => 'Received',
            'cancelled' => 'Cancelled',
        ])
                    ->default('draft')
                    ->required(),
                TextInput::make('subtotal')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('tax_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('created_by')
                    ->required()
                    ->numeric(),
                TextInput::make('approved_by')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
