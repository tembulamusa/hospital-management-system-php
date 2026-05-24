<?php

namespace App\Filament\Schemas;

use App\Filament\Support\PaymentStatus;
use App\Models\Billing;
use App\Models\Patient;
use App\Models\Visit;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;

class PaymentInformationSchema
{
    /**
     * @return array<int, Section>
     */
    public static function patientSummarySection(): array
    {
        return static::relatedPatientPaymentSection('');
    }

    /**
     * Payment summary when viewing a related record (appointment, etc.).
     *
     * @return array<int, Section>
     */
    public static function relatedPatientPaymentSection(string $prefix = 'patient'): array
    {
        $field = fn (string $name): string => filled($prefix) ? "{$prefix}.{$name}" : $name;

        return [
            Section::make('Payment information')
                ->schema([
                    TextEntry::make($field('payment_status'))
                        ->label('Overall payment status')
                        ->badge()
                        ->formatStateUsing(fn (?string $state): string => PaymentStatus::label($state ?? PaymentStatus::NO_BILLING))
                        ->color(fn (?string $state): string => PaymentStatus::color($state ?? PaymentStatus::NO_BILLING)),
                    TextEntry::make($field('total_billed'))
                        ->label('Total billed')
                        ->money('KES'),
                    TextEntry::make($field('total_paid'))
                        ->label('Total paid')
                        ->money('KES'),
                    TextEntry::make($field('outstanding_balance'))
                        ->label('Outstanding balance')
                        ->money('KES')
                        ->color(fn ($state, $record) => ($record->patient?->outstanding_balance ?? $record->outstanding_balance ?? 0) > 0 ? 'danger' : 'success'),
                    RepeatableEntry::make($field('billings'))
                        ->label('Invoices')
                        ->schema(static::billingLineSchema())
                        ->columns(5)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ];
    }

    /**
     * @return array<int, Section>
     */
    public static function visitBillingSection(): array
    {
        return [
            Section::make('Payment information')
                ->schema([
                    TextEntry::make('patient.payment_status')
                        ->label('Patient overall status')
                        ->badge()
                        ->formatStateUsing(fn (?string $state): string => PaymentStatus::label($state ?? PaymentStatus::NO_BILLING))
                        ->color(fn (?string $state): string => PaymentStatus::color($state ?? PaymentStatus::NO_BILLING)),
                    TextEntry::make('patient.outstanding_balance')
                        ->label('Patient balance due')
                        ->money('KES')
                        ->color(fn (Visit $record): string => $record->patient?->outstanding_balance > 0 ? 'danger' : 'success'),
                    TextEntry::make('billing.status')
                        ->label('This visit invoice')
                        ->badge()
                        ->placeholder('No invoice yet')
                        ->formatStateUsing(fn (?string $state): string => filled($state) ? PaymentStatus::label($state) : 'No invoice')
                        ->color(fn (?string $state): string => PaymentStatus::color($state ?? PaymentStatus::NO_BILLING)),
                    TextEntry::make('billing.total_amount')
                        ->label('Visit total')
                        ->money('KES')
                        ->placeholder('—'),
                    TextEntry::make('billing.paid_amount')
                        ->label('Visit paid')
                        ->money('KES')
                        ->placeholder('—'),
                    TextEntry::make('billing.balance')
                        ->label('Visit balance')
                        ->money('KES')
                        ->placeholder('—')
                        ->color(fn (Visit $record): string => ($record->billing?->balance ?? 0) > 0 ? 'danger' : 'success'),
                    RepeatableEntry::make('billing.payments')
                        ->label('Payments for this visit')
                        ->schema(static::paymentLineSchema())
                        ->columns(4)
                        ->columnSpanFull()
                        ->visible(fn (Visit $record): bool => $record->billing?->payments?->isNotEmpty() ?? false),
                ])
                ->columns(2),
        ];
    }

    /**
     * @return array<int, TextEntry>
     */
    protected static function billingLineSchema(): array
    {
        return [
            TextEntry::make('visit.visit_number')->label('Visit'),
            TextEntry::make('total_amount')->label('Total')->money('KES'),
            TextEntry::make('paid_amount')->label('Paid')->money('KES'),
            TextEntry::make('balance')->label('Balance')->money('KES'),
            TextEntry::make('status')
                ->label('Status')
                ->badge()
                ->formatStateUsing(fn (string $state): string => PaymentStatus::label($state))
                ->color(fn (string $state): string => PaymentStatus::color($state)),
        ];
    }

    /**
     * @return array<int, TextEntry>
     */
    public static function paymentLineSchema(): array
    {
        return [
            TextEntry::make('paid_at')->label('Paid at')->dateTime(),
            TextEntry::make('amount')->label('Amount')->money('KES'),
            TextEntry::make('payment_method')->label('Method')->badge(),
            TextEntry::make('reference')->label('Reference'),
        ];
    }
}
