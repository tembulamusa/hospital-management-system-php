<?php

namespace App\Filament\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MedicalHistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Medical history')
                    ->description('Capture background and symptoms before or during diagnosis.')
                    ->schema([
                        DateTimePicker::make('recorded_at')
                            ->label('Recorded at')
                            ->default(now())
                            ->required(),
                        Textarea::make('presenting_complaint')
                            ->label('Presenting complaint')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('history_of_presenting_illness')
                            ->label('History of presenting illness')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('past_medical_history')
                            ->label('Past medical history')
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('past_surgical_history')
                            ->label('Past surgical history')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('allergies')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('current_medications')
                            ->label('Current medications')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('family_history')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('social_history')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('review_of_systems')
                            ->label('Review of systems')
                            ->rows(2)
                            ->columnSpanFull(),
                        Textarea::make('notes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
