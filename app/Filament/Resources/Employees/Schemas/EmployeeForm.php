<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('employee_number')
                    ->required(),
                TextInput::make('first_name')
                    ->required(),
                TextInput::make('last_name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                Select::make('department')
                    ->options([
            'front_desk' => 'Front desk',
            'housekeeping' => 'Housekeeping',
            'maintenance' => 'Maintenance',
            'food_beverage' => 'Food beverage',
            'management' => 'Management',
            'other' => 'Other',
        ])
                    ->default('other')
                    ->required(),
                TextInput::make('position')
                    ->required(),
                TextInput::make('hourly_rate')
                    ->numeric()
                    ->default(null),
                DatePicker::make('hire_date')
                    ->required(),
                DatePicker::make('termination_date'),
                Select::make('employment_status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive', 'terminated' => 'Terminated'])
                    ->default('active')
                    ->required(),
                Textarea::make('address')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('emergency_contact')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
