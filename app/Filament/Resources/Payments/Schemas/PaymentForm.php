<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Models\Billing;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Payment')
                    ->schema([
                        Select::make('billing_id')
                            ->relationship('billing', 'status')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->getOptionLabelFromRecordUsing(fn (Billing $record): string => sprintf(
                                '#%d - %s',
                                $record->id,
                                $record->status
                            )),
                        TextInput::make('amount')
                            ->numeric()
                            ->required(),
                        Select::make('payment_method')
                            ->options([
                                'cash' => 'cash',
                                'card' => 'card',
                                'mobile_money' => 'mobile_money',
                                'bank_transfer' => 'bank_transfer',
                            ])
                            ->required(),
                        TextInput::make('reference')
                            ->maxLength(255),
                    ])
                    ->columns(2),
            ]);
    }
}
