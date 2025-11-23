<?php

namespace App\Filament\Resources\MaintenanceRequests\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class MaintenanceRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('room_id')
                    ->relationship('room', 'id')
                    ->required(),
                TextInput::make('reported_by')
                    ->required()
                    ->numeric(),
                TextInput::make('assigned_to')
                    ->numeric()
                    ->default(null),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
                Select::make('category')
                    ->options([
            'plumbing' => 'Plumbing',
            'electrical' => 'Electrical',
            'hvac' => 'Hvac',
            'furniture' => 'Furniture',
            'appliance' => 'Appliance',
            'other' => 'Other',
        ])
                    ->default('other')
                    ->required(),
                Select::make('priority')
                    ->options(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent'])
                    ->default('medium')
                    ->required(),
                Select::make('status')
                    ->options([
            'open' => 'Open',
            'in_progress' => 'In progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ])
                    ->default('open')
                    ->required(),
                DateTimePicker::make('reported_at')
                    ->required(),
                DateTimePicker::make('scheduled_at'),
                DateTimePicker::make('completed_at'),
                Textarea::make('resolution_notes')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
