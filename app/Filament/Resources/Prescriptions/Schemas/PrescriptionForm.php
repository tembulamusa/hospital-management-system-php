<?php

namespace App\Filament\Resources\Prescriptions\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class PrescriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Prescription')
                    ->schema([
                        Select::make('visit_id')
                            ->relationship('visit', 'visit_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('doctor_id')
                            ->relationship('doctor', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ])
                    ->columns(2),
            ]);
    }
}
