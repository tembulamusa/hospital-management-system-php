<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;

    public function mount(): void
    {
        parent::mount();

        $billingId = request()->integer('billing_id');

        if ($billingId > 0) {
            $this->form->fill([
                'billing_id' => $billingId,
            ]);
        }
    }
}
