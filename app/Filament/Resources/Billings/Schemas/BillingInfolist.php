<?php

namespace App\Filament\Resources\Billings\Schemas;

use App\Filament\Schemas\PaymentInformationSchema;
use App\Filament\Support\PaymentStatus;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BillingInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Invoice')
                    ->schema([
                        TextEntry::make('patient.patient_number')->label('Patient no.'),
                        TextEntry::make('patient.first_name')->label('First name'),
                        TextEntry::make('patient.last_name')->label('Last name'),
                        TextEntry::make('patient.payment_status')
                            ->label('Patient overall status')
                            ->badge()
                            ->formatStateUsing(fn (?string $state): string => PaymentStatus::label($state ?? PaymentStatus::NO_BILLING))
                            ->color(fn (?string $state): string => PaymentStatus::color($state ?? PaymentStatus::NO_BILLING)),
                        TextEntry::make('visit.visit_number')->label('Visit'),
                        TextEntry::make('total_amount')->label('Total')->money('KES'),
                        TextEntry::make('paid_amount')->label('Paid')->money('KES'),
                        TextEntry::make('balance')->label('Balance due')->money('KES'),
                        TextEntry::make('status')
                            ->label('Invoice payment status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => PaymentStatus::label($state))
                            ->color(fn (string $state): string => PaymentStatus::color($state)),
                    ])
                    ->columns(2),
                Section::make('Payment history')
                    ->schema([
                        RepeatableEntry::make('payments')
                            ->label('')
                            ->schema(PaymentInformationSchema::paymentLineSchema())
                            ->columns(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
