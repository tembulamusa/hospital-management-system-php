<?php

namespace App\Filament\Resources\Doctors\Pages;

use App\Filament\Support\FullPageModal;
use App\Filament\Resources\Doctors\DoctorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDoctor extends ViewRecord
{
    protected static string $resource = DoctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::edit(),
            DeleteAction::make(),
        ];
    }
}
