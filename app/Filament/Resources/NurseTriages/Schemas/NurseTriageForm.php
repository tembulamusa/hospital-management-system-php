<?php

namespace App\Filament\Resources\NurseTriages\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class NurseTriageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Triage')
                    ->schema([
                        Select::make('visit_id')
                            ->relationship('visit', 'visit_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('temperature')
                            ->numeric(),
                        TextInput::make('blood_pressure_systolic')
                            ->numeric(),
                        TextInput::make('blood_pressure_diastolic')
                            ->numeric(),
                        TextInput::make('pulse_rate')
                            ->numeric(),
                        TextInput::make('weight')
                            ->numeric(),
                        TextInput::make('height')
                            ->numeric(),
                    ])
                    ->columns(2),
            ]);
    }
}
