<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Support\FullPageModal;
use App\Filament\Resources\Payments\PaymentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPayment extends ViewRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            FullPageModal::edit(),
        ];
    }
}
