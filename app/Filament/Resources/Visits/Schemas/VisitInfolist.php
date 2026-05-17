<?php

namespace App\Filament\Resources\Visits\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class VisitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Visit')
                    ->schema([
                        TextEntry::make('visit_number'),
                        TextEntry::make('patient.patient_number')->label('Patient'),
                        TextEntry::make('doctor.name')->label('Doctor'),
                        TextEntry::make('status'),
                        TextEntry::make('chief_complaint'),
                    ])
                    ->columns(2),
            ]);
    }
}
