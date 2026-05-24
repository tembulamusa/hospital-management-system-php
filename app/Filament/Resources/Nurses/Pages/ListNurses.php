<?php

namespace App\Filament\Resources\Nurses\Pages;

use App\Filament\Resources\Nurses\NurseResource;
use App\Filament\Resources\Pages\ListRecords;
use App\Filament\Support\FullPageModal;
use App\Models\User;
use Filament\Actions\CreateAction;

class ListNurses extends ListRecords
{
    protected static string $resource = NurseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::configureCreate(CreateAction::make())
                ->after(function (User $record): void {
                    $record->syncRoles(['Nurse']);
                }),
        ];
    }
}
