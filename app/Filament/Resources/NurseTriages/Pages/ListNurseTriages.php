<?php

namespace App\Filament\Resources\NurseTriages\Pages;

use App\Filament\Resources\NurseTriages\NurseTriageResource;
use Filament\Actions\CreateAction;
use App\Filament\Resources\Pages\ListRecords;

class ListNurseTriages extends ListRecords
{
    protected static string $resource = NurseTriageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
