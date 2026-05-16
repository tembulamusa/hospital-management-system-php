<?php

namespace App\Filament\Resources\NurseTriages\Pages;

use App\Filament\Resources\NurseTriages\NurseTriageResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditNurseTriage extends EditRecord
{
    protected static string $resource = NurseTriageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
