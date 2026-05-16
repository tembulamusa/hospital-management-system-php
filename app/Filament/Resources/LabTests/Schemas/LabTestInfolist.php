<?php

namespace App\Filament\Resources\LabTests\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class LabTestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Lab Test')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('price'),
                    ])
                    ->columns(2),
            ]);
    }
}
