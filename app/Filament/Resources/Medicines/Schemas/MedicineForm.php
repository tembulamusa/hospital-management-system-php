<?php

namespace App\Filament\Resources\Medicines\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class MedicineForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Medicine')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('generic_name')
                            ->maxLength(255),
                        TextInput::make('stock_quantity')
                            ->numeric()
                            ->required()
                            ->default(0),
                        TextInput::make('selling_price')
                            ->numeric()
                            ->required(),
                        DatePicker::make('expiry_date'),
                    ])
                    ->columns(2),
            ]);
    }
}
