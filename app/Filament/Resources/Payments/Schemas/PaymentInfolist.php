<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class PaymentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Payment')
                    ->schema([
                        TextEntry::make('billing.status')->label('Billing'),
                        TextEntry::make('amount'),
                        TextEntry::make('payment_method'),
                        TextEntry::make('reference'),
                    ])
                    ->columns(2),
            ]);
    }
}
