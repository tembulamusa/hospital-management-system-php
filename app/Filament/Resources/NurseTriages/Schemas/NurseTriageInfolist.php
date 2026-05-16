<?php

namespace App\Filament\Resources\NurseTriages\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class NurseTriageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Triage')
                    ->schema([
                        TextEntry::make('visit.visit_number')->label('Visit'),
                        TextEntry::make('temperature'),
                        TextEntry::make('blood_pressure_systolic'),
                        TextEntry::make('blood_pressure_diastolic'),
                        TextEntry::make('pulse_rate'),
                        TextEntry::make('weight'),
                        TextEntry::make('height'),
                    ])
                    ->columns(2),
            ]);
    }
}
