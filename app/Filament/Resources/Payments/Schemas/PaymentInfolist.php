<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Filament\Support\PaymentStatus;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Payment')
                    ->schema([
                        TextEntry::make('billing.patient.patient_number')
                            ->label('Patient'),
                        TextEntry::make('billing.patient.first_name')
                            ->label('First name'),
                        TextEntry::make('billing.patient.last_name')
                            ->label('Last name'),
                        TextEntry::make('billing.visit.visit_number')
                            ->label('Visit'),
                        TextEntry::make('billing.status')
                            ->label('Invoice status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => PaymentStatus::label($state))
                            ->color(fn (string $state): string => PaymentStatus::color($state)),
                        TextEntry::make('paid_at')
                            ->label('Paid at')
                            ->dateTime(),
                        TextEntry::make('amount')
                            ->label('Amount')
                            ->money('KES'),
                        TextEntry::make('payment_method')
                            ->label('Method')
                            ->badge(),
                        TextEntry::make('reference')
                            ->label('Reference'),
                        TextEntry::make('notes')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}
