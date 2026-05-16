<?php

namespace App\Filament\Resources\LabRequests\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LabRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lab Request')
                    ->schema([
                        TextEntry::make('visit.visit_number')->label('Visit'),
                        TextEntry::make('labTest.name')->label('Lab Test'),
                        TextEntry::make('status'),
                        TextEntry::make('result'),
                    ])
                    ->columns(2),
            ]);
    }
}
