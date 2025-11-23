<?php

namespace App\Filament\Resources\KitchenOrders\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class KitchenOrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('restaurant.name')
                    ->searchable(),
                TextColumn::make('kitchen.name')
                    ->searchable(),
                TextColumn::make('order_number')
                    ->searchable(),
                TextColumn::make('restaurantTable.id')
                    ->searchable(),
                TextColumn::make('posOrder.id')
                    ->searchable(),
                TextColumn::make('guest.id')
                    ->searchable(),
                TextColumn::make('order_type')
                    ->badge(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('number_of_guests')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('order_time')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('confirmed_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('prepared_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('served_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('waiter.name')
                    ->searchable(),
                TextColumn::make('chef.name')
                    ->searchable(),
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
