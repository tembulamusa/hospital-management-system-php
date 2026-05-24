<?php

namespace App\Filament\Resources\Patients\Pages;

use App\Filament\Resources\Patients\PatientResource;
use App\Filament\Resources\Patients\RelationManagers\PatientPaymentsRelationManager;
use App\Filament\Support\FullPageModal;
use App\Models\Patient;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;
use Filament\Support\Icons\Heroicon;

class ViewPatient extends ViewRecord
{
    protected static string $resource = PatientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('receivePayment')
                ->label('Receive payment')
                ->icon(Heroicon::OutlinedBanknotes)
                ->visible(fn (Patient $record): bool => $record->outstanding_balance > 0)
                ->url(fn (Patient $record): string => PatientResource::getUrl('view', [
                    'record' => $record,
                    'activeRelationManager' => (string) array_search(
                        PatientPaymentsRelationManager::class,
                        PatientResource::getRelations(),
                        true,
                    ),
                ])),
        ];
    }
}
