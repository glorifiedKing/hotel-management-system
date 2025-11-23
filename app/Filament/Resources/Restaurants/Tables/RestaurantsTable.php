<?php

namespace App\Filament\Resources\Restaurants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RestaurantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('type')
                    ->badge(),
                TextColumn::make('location')
                    ->searchable(),
                TextColumn::make('floor')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('opening_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('closing_time')
                    ->time()
                    ->sortable(),
                TextColumn::make('seating_capacity')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('kitchen.name')
                    ->searchable(),
                IconColumn::make('is_active')
                    ->boolean(),
                IconColumn::make('accepts_reservations')
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
