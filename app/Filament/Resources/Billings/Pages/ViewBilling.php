<?php

namespace App\Filament\Resources\Billings\Pages;

use App\Filament\Support\FullPageModal;
use App\Filament\Resources\Billings\BillingResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBilling extends ViewRecord
{
    protected static string $resource = BillingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::edit(),
        ];
    }
}
