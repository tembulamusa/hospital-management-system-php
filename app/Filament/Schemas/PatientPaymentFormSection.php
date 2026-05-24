<?php

namespace App\Filament\Schemas;

use App\Filament\Support\PaymentStatus;
use App\Models\Patient;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;

class PatientPaymentFormSection
{
    /**
     * @return array<int, Section>
     */
    public static function make(): array
    {
        return [
            Section::make('Payment information')
                ->description('Manage invoices and payments from Billing & payments or the patient view tab.')
                ->schema([
                    TextInput::make('payment_status_display')
                        ->label('Payment status')
                        ->disabled()
                        ->dehydrated(false)
                        ->default(fn (?Patient $record): string => $record
                            ? PaymentStatus::label($record->payment_status)
                            : PaymentStatus::label(PaymentStatus::NO_BILLING)),
                    TextInput::make('total_billed_display')
                        ->label('Total billed')
                        ->disabled()
                        ->dehydrated(false)
                        ->prefix('KES')
                        ->default(fn (?Patient $record): string => $record
                            ? number_format($record->total_billed, 2)
                            : '0.00'),
                    TextInput::make('total_paid_display')
                        ->label('Total paid')
                        ->disabled()
                        ->dehydrated(false)
                        ->prefix('KES')
                        ->default(fn (?Patient $record): string => $record
                            ? number_format($record->total_paid, 2)
                            : '0.00'),
                    TextInput::make('outstanding_balance_display')
                        ->label('Outstanding balance')
                        ->disabled()
                        ->dehydrated(false)
                        ->prefix('KES')
                        ->default(fn (?Patient $record): string => $record
                            ? number_format($record->outstanding_balance, 2)
                            : '0.00'),
                ])
                ->columns(2)
                ->visible(fn (string $operation): bool => $operation !== 'create'),
        ];
    }

    public static function patientSelectPaymentHelper(): \Closure
    {
        return function (callable $get): ?string {
            $patientId = $get('patient_id');

            if (blank($patientId)) {
                return null;
            }

            $patient = Patient::query()->with('billings')->find($patientId);

            if (! $patient) {
                return null;
            }

            return sprintf(
                'Payment: %s — Balance due: KES %s',
                PaymentStatus::label($patient->payment_status),
                number_format($patient->outstanding_balance, 2),
            );
        };
    }
}
