<?php

namespace App\Filament\Resources\InventoryItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InventoryItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category.name')
                    ->searchable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),
                TextColumn::make('unit_of_measurement')
                    ->searchable(),
                TextColumn::make('current_stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('minimum_stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('maximum_stock')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('reorder_point')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('cost_per_unit')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('storage_location')
                    ->searchable(),
                TextColumn::make('expiry_date')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_perishable')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
