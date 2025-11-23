<?php

namespace App\Filament\Resources\HousekeepingTasks\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class HousekeepingTaskForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('room_id')
                    ->relationship('room', 'id')
                    ->required(),
                TextInput::make('assigned_to')
                    ->numeric()
                    ->default(null),
                Select::make('task_type')
                    ->options([
            'cleaning' => 'Cleaning',
            'deep_cleaning' => 'Deep cleaning',
            'turndown' => 'Turndown',
            'inspection' => 'Inspection',
            'maintenance' => 'Maintenance',
        ])
                    ->default('cleaning')
                    ->required(),
                Select::make('priority')
                    ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'])
                    ->default('medium')
                    ->required(),
                Select::make('status')
                    ->options([
            'pending' => 'Pending',
            'in_progress' => 'In progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ])
                    ->default('pending')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                DateTimePicker::make('scheduled_at'),
                DateTimePicker::make('started_at'),
                DateTimePicker::make('completed_at'),
                Textarea::make('notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
