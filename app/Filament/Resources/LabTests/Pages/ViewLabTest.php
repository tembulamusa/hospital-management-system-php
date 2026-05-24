<?php

namespace App\Filament\Resources\LabTests\Pages;

use App\Filament\Support\FullPageModal;
use App\Filament\Resources\LabTests\LabTestResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLabTest extends ViewRecord
{
    protected static string $resource = LabTestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::edit(),
        ];
    }
}
