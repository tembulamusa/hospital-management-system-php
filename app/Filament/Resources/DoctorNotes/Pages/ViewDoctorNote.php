<?php

namespace App\Filament\Resources\DoctorNotes\Pages;

use App\Filament\Support\FullPageModal;
use App\Filament\Resources\DoctorNotes\DoctorNoteResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDoctorNote extends ViewRecord
{
    protected static string $resource = DoctorNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::edit(),
        ];
    }
}
