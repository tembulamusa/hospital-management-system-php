<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Models\Billing;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Record payment')
                    ->schema([
                        Select::make('billing_id')
                            ->label('Invoice')
                            ->relationship('billing', 'id')
                            ->getOptionLabelFromRecordUsing(fn (Billing $record): string => sprintf(
                                '#%d — %s %s — %s (Balance: KES %s)',
                                $record->id,
                                $record->patient?->first_name,
                                $record->patient?->last_name,
                                strtoupper($record->status),
                                number_format((float) $record->balance, 2),
                            ))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(),
                        TextInput::make('amount')
                            ->label('Amount paid')
                            ->numeric()
                            ->prefix('KES')
                            ->required()
                            ->default(function (callable $get): ?float {
                                $billingId = $get('billing_id');

                                if (blank($billingId)) {
                                    return null;
                                }

                                return (float) Billing::query()->find($billingId)?->balance;
                            }),
                        Select::make('payment_method')
                            ->label('Payment method')
                            ->options([
                                'cash' => 'Cash',
                                'card' => 'Card',
                                'mobile_money' => 'Mobile money',
                                'bank_transfer' => 'Bank transfer',
                                'insurance' => 'Insurance',
                            ])
                            ->required()
                            ->default('cash'),
                        TextInput::make('reference')
                            ->label('Reference / receipt no.')
                            ->maxLength(255),
                        DateTimePicker::make('paid_at')
                            ->label('Paid at')
                            ->default(now())
                            ->required(),
                        Textarea::make('notes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
