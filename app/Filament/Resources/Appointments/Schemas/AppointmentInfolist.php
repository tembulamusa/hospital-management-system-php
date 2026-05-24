<?php

namespace App\Filament\Resources\Appointments\Schemas;

use App\Filament\Schemas\PaymentInformationSchema;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
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
                        TextEntry::make('patient.first_name')->label('First name'),
                        TextEntry::make('patient.last_name')->label('Last name'),
                        TextEntry::make('doctor.name')->label('Doctor'),
                        TextEntry::make('appointment_time'),
                        TextEntry::make('status'),
                        TextEntry::make('notes'),
                    ])
                    ->columns(2),
                ...PaymentInformationSchema::relatedPatientPaymentSection('patient'),
            ]);
    }
}
