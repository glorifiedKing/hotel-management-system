<?php

namespace App\Filament\Resources\Shifts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class ShiftForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->relationship('employee', 'id')
                    ->required(),
                DatePicker::make('shift_date')
                    ->required(),
                TimePicker::make('start_time')
                    ->required(),
                TimePicker::make('end_time')
                    ->required(),
                TimePicker::make('actual_start_time'),
                TimePicker::make('actual_end_time'),
                Select::make('shift_type')
                    ->options([
            'morning' => 'Morning',
            'afternoon' => 'Afternoon',
            'night' => 'Night',
            'full_day' => 'Full day',
        ])
                    ->default('full_day')
                    ->required(),
                Select::make('status')
                    ->options([
            'scheduled' => 'Scheduled',
            'in_progress' => 'In progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'no_show' => 'No show',
        ])
                    ->default('scheduled')
                    ->required(),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
