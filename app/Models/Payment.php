<?php

namespace App\Models;

use App\Models\Concerns\SoftDeletesRecord;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'billing_id',
    'amount',
    'payment_method',
    'reference',
    'paid_at',
    'notes',
])]
class Payment extends Model
{
    use SoftDeletesRecord;

    protected static function booted(): void
    {
        static::creating(function (self $payment): void {
            if (blank($payment->paid_at)) {
                $payment->paid_at = now();
            }
        });

        static::saved(function (self $payment): void {
            $payment->billing?->recalculateTotals();
        });

        static::deleted(function (self $payment): void {
            $payment->billing?->recalculateTotals();
        });
    }

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    public function billing(): BelongsTo
    {
        return $this->belongsTo(Billing::class);
    }
}
