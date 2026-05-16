<?php

namespace App\Filament\Resources\DoctorNotes\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DoctorNoteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Doctor Note')
                    ->schema([
                        Select::make('visit_id')
                            ->relationship('visit', 'visit_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Textarea::make('assessment')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('diagnosis')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('plan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
