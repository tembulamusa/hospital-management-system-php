<?php

namespace App\Filament\Resources\Billings\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BillingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Billing')
                    ->schema([
                        TextEntry::make('patient.patient_number')->label('Patient'),
                        TextEntry::make('visit.visit_number')->label('Visit'),
                        TextEntry::make('total_amount'),
                        TextEntry::make('paid_amount'),
                        TextEntry::make('balance'),
                        TextEntry::make('status'),
                    ])
                    ->columns(2),
            ]);
    }
}
