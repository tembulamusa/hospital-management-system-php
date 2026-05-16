<?php

namespace App\Filament\Resources\Appointments\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AppointmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Appointment')
                    ->schema([
                        TextEntry::make('patient.patient_number')->label('Patient'),
                        TextEntry::make('doctor.name')->label('Doctor'),
                        TextEntry::make('appointment_time'),
                        TextEntry::make('status'),
                        TextEntry::make('notes'),
                    ])
                    ->columns(2),
            ]);
    }
}
