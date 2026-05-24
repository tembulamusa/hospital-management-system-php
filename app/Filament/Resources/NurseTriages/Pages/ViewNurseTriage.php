<?php

namespace App\Filament\Resources\NurseTriages\Pages;

use App\Filament\Support\FullPageModal;
use App\Filament\Resources\NurseTriages\NurseTriageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNurseTriage extends ViewRecord
{
    protected static string $resource = NurseTriageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::edit(),
        ];
    }
}
