<?php

namespace App\Filament\Resources\Prescriptions\Schemas;

use App\Support\Filament\StaffSelect;
use Filament\Forms\Components\Repeater;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                        StaffSelect::doctor(),
                    ])
                    ->columns(2),
                Section::make('Medicines')
                    ->schema([
                        Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Select::make('drug_id')
                                    ->label('Medicine')
                                    ->relationship('medicine', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                TextInput::make('dosage')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('frequency')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('days')
                                    ->numeric()
                                    ->required()
                                    ->minValue(1),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel('Add medicine')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
