<?php

namespace App\Filament\Resources\Billings\Schemas;

use App\Filament\Support\PaymentStatus;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BillingForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Invoice')
                    ->schema([
                        Select::make('patient_id')
                            ->label('Patient')
                            ->relationship('patient', 'patient_number')
                            ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->patient_number} — {$record->first_name} {$record->last_name}")
                            ->searchable(['patient_number', 'first_name', 'last_name'])
                            ->preload()
                            ->required(),
                        Select::make('visit_id')
                            ->label('Visit')
                            ->relationship('visit', 'visit_number')
                            ->searchable()
                            ->preload(),
                        TextInput::make('total_amount')
                            ->label('Total amount')
                            ->numeric()
                            ->prefix('KES')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) => static::syncDerivedAmounts($set, $get)),
                        TextInput::make('paid_amount')
                            ->label('Paid amount')
                            ->numeric()
                            ->prefix('KES')
                            ->default(0)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set, callable $get) => static::syncDerivedAmounts($set, $get)),
                        TextInput::make('balance')
                            ->label('Balance due')
                            ->numeric()
                            ->prefix('KES')
                            ->default(0)
                            ->disabled()
                            ->dehydrated(),
                        Select::make('status')
                            ->label('Payment status')
                            ->options(PaymentStatus::billingLabels())
                            ->required()
                            ->default('unpaid')
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->columns(2),
            ]);
    }

    protected static function syncDerivedAmounts(callable $set, callable $get): void
    {
        $total = (float) ($get('total_amount') ?? 0);
        $paid = (float) ($get('paid_amount') ?? 0);
        $balance = max(0, round($total - $paid, 2));

        $set('balance', $balance);

        $status = match (true) {
            $total <= 0 => PaymentStatus::PAID,
            $paid <= 0 => PaymentStatus::UNPAID,
            $balance <= 0 => PaymentStatus::PAID,
            $paid < $total => PaymentStatus::PARTIAL,
            default => PaymentStatus::PAID,
        };

        $set('status', $status);
    }
}
