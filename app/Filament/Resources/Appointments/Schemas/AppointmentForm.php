<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AppointmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Appointment')
                    ->schema([
                        Select::make('patient_id')
                            ->relationship('patient', 'patient_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('doctor_id')
                            ->relationship('doctor', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        DateTimePicker::make('appointment_time')
                            ->required(),
                        Select::make('status')
                            ->options([
                                'pending' => 'pending',
                                'confirmed' => 'confirmed',
                                'completed' => 'completed',
                                'cancelled' => 'cancelled',
                            ])
                            ->required()
                            ->default('pending'),
                        Textarea::make('notes')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
