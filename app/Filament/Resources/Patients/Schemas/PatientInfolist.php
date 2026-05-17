<?php

namespace App\Filament\Resources\Patients\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PatientInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Patient Profile')
                    ->schema([
                        TextEntry::make('patient_number')->label('Patient Number'),
                        TextEntry::make('first_name'),
                        TextEntry::make('last_name'),
                        TextEntry::make('date_of_birth'),
                        TextEntry::make('gender'),
                        TextEntry::make('phone'),
                        TextEntry::make('email'),
                        TextEntry::make('address'),
                        TextEntry::make('blood_group'),
                        TextEntry::make('insurance_provider'),
                        TextEntry::make('insurance_number'),
                        ImageEntry::make('photo'),
                    ])
                    ->columns(2),
            ]);
    }
}
