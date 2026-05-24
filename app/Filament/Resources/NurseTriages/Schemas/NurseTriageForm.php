<?php

namespace App\Filament\Resources\NurseTriages\Schemas;

use App\Support\Filament\StaffSelect;
use Filament\Schemas\Components\Section;
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
                        StaffSelect::nurse(),
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
