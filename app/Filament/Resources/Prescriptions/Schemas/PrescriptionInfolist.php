<?php

namespace App\Filament\Resources\Prescriptions\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PrescriptionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Prescription')
                    ->schema([
                        TextEntry::make('visit.visit_number')->label('Visit'),
                        TextEntry::make('doctor.name')->label('Doctor'),
                    ])
                    ->columns(2),
            ]);
    }
}
