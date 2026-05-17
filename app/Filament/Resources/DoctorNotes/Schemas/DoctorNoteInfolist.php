<?php

namespace App\Filament\Resources\DoctorNotes\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DoctorNoteInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Doctor Note')
                    ->schema([
                        TextEntry::make('visit.visit_number')->label('Visit'),
                        TextEntry::make('assessment'),
                        TextEntry::make('diagnosis'),
                        TextEntry::make('plan'),
                    ])
                    ->columns(2),
            ]);
    }
}
