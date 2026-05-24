<?php

namespace App\Filament\Resources\Doctors\Pages;

use App\Filament\Resources\Doctors\DoctorResource;
use App\Filament\Resources\Pages\ListRecords;
use App\Filament\Support\FullPageModal;
use App\Models\User;
use Filament\Actions\CreateAction;

class ListDoctors extends ListRecords
{
    protected static string $resource = DoctorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::configureCreate(CreateAction::make())
                ->after(function (User $record): void {
                    $record->syncRoles(['Doctor']);
                }),
        ];
    }
}
