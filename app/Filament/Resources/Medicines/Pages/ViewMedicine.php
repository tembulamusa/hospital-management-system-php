<?php

namespace App\Filament\Resources\Medicines\Pages;

use App\Filament\Support\FullPageModal;
use App\Filament\Resources\Medicines\MedicineResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMedicine extends ViewRecord
{
    protected static string $resource = MedicineResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::edit(),
        ];
    }
}
