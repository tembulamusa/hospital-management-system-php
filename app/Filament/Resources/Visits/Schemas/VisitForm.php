<?php

namespace App\Filament\Resources\Visits\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                            ->relationship('patient', 'patient_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('doctor_id')
                            ->relationship('doctor', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->options([
                                'waiting' => 'waiting',
                                'consultation' => 'consultation',
                                'lab' => 'lab',
                                'pharmacy' => 'pharmacy',
                                'completed' => 'completed',
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
