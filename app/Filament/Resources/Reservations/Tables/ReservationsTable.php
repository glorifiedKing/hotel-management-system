<?php

namespace App\Filament\Resources\Reservations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ReservationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('reservation_number')
                    ->searchable(),
                TextColumn::make('guest.id')
                    ->searchable(),
                TextColumn::make('check_in_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('check_out_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('number_of_guests')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('number_of_rooms')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge(),
                TextColumn::make('total_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('deposit_amount')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('booking_source')
                    ->badge(),
                TextColumn::make('checked_in_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('checked_out_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
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
