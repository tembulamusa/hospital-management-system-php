<?php

namespace App\Filament\Resources\DoctorNotes\Pages;

use App\Filament\Resources\DoctorNotes\DoctorNoteResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDoctorNote extends EditRecord
{
    protected static string $resource = DoctorNoteResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
