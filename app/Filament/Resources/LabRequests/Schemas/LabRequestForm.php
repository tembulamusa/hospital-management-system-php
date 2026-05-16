<?php

namespace App\Filament\Resources\LabRequests\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class LabRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lab Request')
                    ->schema([
                        Select::make('visit_id')
                            ->relationship('visit', 'visit_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('lab_test_id')
                            ->relationship('labTest', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('status')
                            ->options([
                                'pending' => 'pending',
                                'in_progress' => 'in_progress',
                                'completed' => 'completed',
                                'cancelled' => 'cancelled',
                            ])
                            ->required()
                            ->default('pending'),
                        Textarea::make('result')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
