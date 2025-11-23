<?php

namespace App\Filament\Resources\Suppliers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SupplierForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('company_name')
                    ->default(null),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->default(null),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                Textarea::make('address')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('city')
                    ->default(null),
                TextInput::make('country')
                    ->default(null),
                TextInput::make('contact_person')
                    ->default(null),
                Select::make('supplier_type')
                    ->options([
            'food' => 'Food',
            'beverage' => 'Beverage',
            'supplies' => 'Supplies',
            'equipment' => 'Equipment',
            'other' => 'Other',
        ])
                    ->default('food')
                    ->required(),
                Textarea::make('payment_terms')
                    ->default(null)
                    ->columnSpanFull(),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
