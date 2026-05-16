<?php

namespace App\Filament\Resources\Billings\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class BillingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Billing')
                    ->schema([
                        Select::make('patient_id')
                            ->relationship('patient', 'patient_number')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('visit_id')
                            ->relationship('visit', 'visit_number')
                            ->searchable()
                            ->preload(),
                        TextInput::make('total_amount')
                            ->numeric()
                            ->required(),
                        TextInput::make('paid_amount')
                            ->numeric()
                            ->default(0),
                        TextInput::make('balance')
                            ->numeric()
                            ->default(0),
                        Select::make('status')
                            ->options([
                                'unpaid' => 'unpaid',
                                'partial' => 'partial',
                                'paid' => 'paid',
                                'void' => 'void',
                            ])
                            ->required()
                            ->default('unpaid'),
                    ])
                    ->columns(2),
            ]);
    }
}
