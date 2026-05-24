<?php

namespace App\Filament\Schemas;

use App\Models\Billing;
use App\Models\Patient;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PatientPaymentForm
{
    public static function configure(Schema $schema, Patient $patient): Schema
    {
        return $schema
            ->components([
                Section::make('Receive payment')
                    ->description('Record a payment against this patient\'s invoice. Payments cannot be edited after they are saved.')
                    ->schema([
                        Select::make('billing_id')
                            ->label('Invoice')
                            ->options(function () use ($patient): array {
                                return $patient->billings()
                                    ->with('visit')
                                    ->where('balance', '>', 0)
                                    ->orderByDesc('id')
                                    ->get()
                                    ->mapWithKeys(fn (Billing $billing): array => [
                                        $billing->id => sprintf(
                                            '#%d — %s — Balance KES %s',
                                            $billing->id,
                                            $billing->visit?->visit_number ?? 'No visit',
                                            number_format((float) $billing->balance, 2),
                                        ),
                                    ])
                                    ->all();
                            })
                            ->searchable()
                            ->required()
                            ->live()
                            ->helperText('Only invoices with an outstanding balance are listed.'),
                        TextInput::make('amount')
                            ->label('Amount received')
                            ->numeric()
                            ->prefix('KES')
                            ->required()
                            ->minValue(0.01)
                            ->default(function (callable $get) use ($patient): ?float {
                                $billingId = $get('billing_id');

                                if (blank($billingId)) {
                                    return null;
                                }

                                return (float) $patient->billings()->find($billingId)?->balance;
                            })
                            ->maxValue(function (callable $get) use ($patient): ?float {
                                $billingId = $get('billing_id');

                                if (blank($billingId)) {
                                    return null;
                                }

                                return (float) $patient->billings()->find($billingId)?->balance;
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

    public static function billingBelongsToPatient(int $billingId, Patient $patient): bool
    {
        return Billing::query()
            ->whereKey($billingId)
            ->where('patient_id', $patient->id)
            ->exists();
    }
}
