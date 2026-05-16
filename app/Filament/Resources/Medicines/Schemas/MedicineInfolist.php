<?php

namespace App\Filament\Resources\Medicines\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MedicineInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Medicine')
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('generic_name'),
                        TextEntry::make('stock_quantity'),
                        TextEntry::make('selling_price'),
                        TextEntry::make('expiry_date'),
                    ])
                    ->columns(2),
            ]);
    }
}
