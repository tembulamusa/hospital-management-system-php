<?php

namespace App\Filament\Resources\Prescriptions\Pages;

use App\Filament\Support\FullPageModal;
use App\Filament\Resources\Prescriptions\PrescriptionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPrescription extends ViewRecord
{
    protected static string $resource = PrescriptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::edit(),
        ];
    }
}
