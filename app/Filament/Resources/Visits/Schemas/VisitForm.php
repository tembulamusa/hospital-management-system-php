<?php

namespace App\Filament\Resources\Visits\Schemas;

use App\Filament\Schemas\PatientPaymentFormSection;
use App\Support\Filament\StaffSelect;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VisitForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Visit')
                    ->schema([
                        TextInput::make('visit_number')
                            ->label('Visit Number')
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Auto-generated on save'),
                        Select::make('patient_id')
                            ->label('Patient')
                            ->relationship('patient', 'patient_number')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->patient_number} — {$record->first_name} {$record->last_name}")
                            ->searchable(['patient_number', 'first_name', 'last_name'])
                            ->preload()
                            ->required()
                            ->live()
                            ->helperText(PatientPaymentFormSection::patientSelectPaymentHelper()),
                        StaffSelect::doctor(),
                        Select::make('status')
                            ->options([
                                'waiting' => 'Waiting',
                                'consultation' => 'Consultation',
                                'lab' => 'Lab',
                                'pharmacy' => 'Pharmacy',
                                'completed' => 'Completed',
                            ])
                            ->required()
                            ->default('waiting'),
                        Textarea::make('chief_complaint')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
