<?php

namespace App\Filament\Resources\Nurses\Pages;

use App\Filament\Support\FullPageModal;
use App\Filament\Resources\Nurses\NurseResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewNurse extends ViewRecord
{
    protected static string $resource = NurseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::edit(),
            DeleteAction::make(),
        ];
    }
}
