<?php

namespace App\Filament\Resources\Visits\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Filament\Resources\Visits\VisitResource;
use App\Filament\Support\FullPageModal;
use App\Models\Visit;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewVisit extends ViewRecord
{
    protected static string $resource = VisitResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('recordPayment')
                ->label('Record payment')
                ->icon(Heroicon::OutlinedBanknotes)
                ->visible(fn (Visit $record): bool => $record->billing !== null && (float) $record->billing->balance > 0)
                ->url(fn (Visit $record): string => PaymentResource::getUrl('create', [
                    'billing_id' => $record->billing->id,
                ])),
            FullPageModal::edit(),
        ];
    }
}
