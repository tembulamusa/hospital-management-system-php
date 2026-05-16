<?php

namespace App\Filament\Resources\LabTests\Pages;

use App\Filament\Resources\LabTests\LabTestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLabTest extends ViewRecord
{
    protected static string $resource = LabTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
