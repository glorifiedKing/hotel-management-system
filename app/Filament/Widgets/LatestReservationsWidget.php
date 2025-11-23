<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Reservation;

class LatestReservationsWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Reservation::query()
                    ->with(['guest', 'rooms'])
                    ->where('check_in_date', '>=', today())
                    ->orderBy('check_in_date', 'asc')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('reservation_number')
                    ->label('Reservation #')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('guest.full_name')
                    ->label('Guest')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('check_in_date')
                    ->label('Check In')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('check_out_date')
                    ->label('Check Out')
                    ->date()
                    ->sortable(),

                Tables\Columns\TextColumn::make('number_of_rooms')
                    ->label('Rooms')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('number_of_guests')
                    ->label('Guests')
                    ->alignCenter(),

                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'confirmed',
                        'primary' => 'checked_in',
                        'secondary' => 'checked_out',
                        'danger' => 'cancelled',
                    ]),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('usd')
                    ->sortable(),
            ])
            ->heading('Upcoming Reservations');
    }
}
