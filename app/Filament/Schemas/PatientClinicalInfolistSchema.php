<?php

namespace App\Filament\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

class PatientClinicalInfolistSchema
{
    /**
     * @return array<int, Section>
     */
    public static function sections(): array
    {
        return [
            Section::make('Medical history')
                ->description('Background captured before or during consultation. Use the Medical history tab below to add entries.')
                ->schema([
                    RepeatableEntry::make('medicalHistories')
                        ->label('')
                        ->schema([
                            TextEntry::make('recorded_at')
                                ->label('Recorded at')
                                ->dateTime(),
                            TextEntry::make('recordedBy.name')
                                ->label('Recorded by')
                                ->placeholder('—'),
                            TextEntry::make('presenting_complaint')
                                ->label('Presenting complaint')
                                ->columnSpanFull(),
                            TextEntry::make('history_of_presenting_illness')
                                ->label('History of presenting illness')
                                ->columnSpanFull(),
                            TextEntry::make('past_medical_history')
                                ->label('Past medical history')
                                ->columnSpanFull(),
                            TextEntry::make('past_surgical_history')
                                ->label('Past surgical history')
                                ->columnSpanFull()
                                ->visible(fn ($state): bool => filled($state)),
                            TextEntry::make('allergies')
                                ->columnSpanFull()
                                ->visible(fn ($state): bool => filled($state)),
                            TextEntry::make('current_medications')
                                ->label('Current medications')
                                ->columnSpanFull()
                                ->visible(fn ($state): bool => filled($state)),
                            TextEntry::make('family_history')
                                ->label('Family history')
                                ->columnSpanFull()
                                ->visible(fn ($state): bool => filled($state)),
                            TextEntry::make('social_history')
                                ->label('Social history')
                                ->columnSpanFull()
                                ->visible(fn ($state): bool => filled($state)),
                            TextEntry::make('review_of_systems')
                                ->label('Review of systems')
                                ->columnSpanFull()
                                ->visible(fn ($state): bool => filled($state)),
                            TextEntry::make('notes')
                                ->columnSpanFull()
                                ->visible(fn ($state): bool => filled($state)),
                        ])
                        ->columns(2)
                        ->columnSpanFull()
                        ->placeholder('No medical history recorded yet. Add an entry using the Medical history tab.'),
                ]),
            Section::make('Diagnoses')
                ->schema([
                    RepeatableEntry::make('doctorNotes')
                        ->label('')
                        ->schema([
                            TextEntry::make('created_at')
                                ->label('Recorded at')
                                ->dateTime(),
                            TextEntry::make('visit.visit_number')
                                ->label('Visit'),
                            TextEntry::make('diagnosis')
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->columnSpanFull()
                        ->placeholder('No diagnoses recorded yet.'),
                ]),
            Section::make('Triage records')
                ->schema([
                    RepeatableEntry::make('nurseTriages')
                        ->label('')
                        ->schema([
                            TextEntry::make('created_at')
                                ->label('Triage date')
                                ->dateTime(),
                            TextEntry::make('visit.visit_number')
                                ->label('Visit'),
                            TextEntry::make('nurse.name')
                                ->label('Nurse')
                                ->placeholder('—'),
                            TextEntry::make('temperature')
                                ->suffix(' °C'),
                            TextEntry::make('blood_pressure_systolic')
                                ->label('BP systolic'),
                            TextEntry::make('blood_pressure_diastolic')
                                ->label('BP diastolic'),
                            TextEntry::make('pulse_rate')
                                ->label('Pulse'),
                            TextEntry::make('weight')
                                ->suffix(' kg'),
                            TextEntry::make('height')
                                ->suffix(' m'),
                        ])
                        ->columns(3)
                        ->columnSpanFull()
                        ->placeholder('No triage records yet.'),
                ]),
            Section::make("Doctor's notes")
                ->schema([
                    RepeatableEntry::make('doctorNotes')
                        ->label('')
                        ->schema([
                            TextEntry::make('created_at')
                                ->label('Recorded at')
                                ->dateTime(),
                            TextEntry::make('visit.visit_number')
                                ->label('Visit'),
                            TextEntry::make('assessment')
                                ->columnSpanFull(),
                            TextEntry::make('diagnosis')
                                ->label('Diagnosis')
                                ->columnSpanFull(),
                            TextEntry::make('plan')
                                ->label('Plan')
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->columnSpanFull()
                        ->placeholder('No doctor notes yet.'),
                ]),
            Section::make('Prescriptions')
                ->schema([
                    RepeatableEntry::make('prescriptions')
                        ->label('')
                        ->schema([
                            TextEntry::make('created_at')
                                ->label('Prescribed at')
                                ->dateTime(),
                            TextEntry::make('visit.visit_number')
                                ->label('Visit'),
                            TextEntry::make('doctor.name')
                                ->label('Doctor')
                                ->placeholder('—'),
                            RepeatableEntry::make('items')
                                ->label('Medicines')
                                ->schema([
                                    TextEntry::make('medicine.name')
                                        ->label('Medicine'),
                                    TextEntry::make('dosage'),
                                    TextEntry::make('frequency'),
                                    TextEntry::make('days')
                                        ->label('Days'),
                                ])
                                ->columns(4)
                                ->columnSpanFull(),
                        ])
                        ->columns(2)
                        ->columnSpanFull()
                        ->placeholder('No prescriptions yet.'),
                ]),
        ];
    }
}
