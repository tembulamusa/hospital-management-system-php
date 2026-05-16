<?php

namespace App\Filament\Resources\NurseTriages\Pages;

use App\Filament\Resources\NurseTriages\NurseTriageResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNurseTriage extends ViewRecord
{
    protected static string $resource = NurseTriageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
