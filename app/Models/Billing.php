<?php

namespace App\Models;

use App\Models\Concerns\RecalculatesBillingTotals;
use App\Models\Concerns\SoftDeletesRecord;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'patient_id',
    'visit_id',
    'total_amount',
    'paid_amount',
    'balance',
    'status',
])]
class Billing extends Model
{
    use RecalculatesBillingTotals;
    use SoftDeletesRecord;

    protected static function booted(): void
    {
        static::saved(function (self $billing): void {
            if ($billing->payments()->exists()) {
                $billing->recalculateTotals();
            } else {
                $billing->syncTotalsFromFormFields();
            }
        });
    }

    public function syncTotalsFromFormFields(): void
    {
        $totalAmount = (float) $this->total_amount;
        $paidAmount = (float) $this->paid_amount;
        $balance = max(0, round($totalAmount - $paidAmount, 2));

        $status = match (true) {
            $totalAmount <= 0 && $paidAmount <= 0 => 'unpaid',
            $paidAmount <= 0 => 'unpaid',
            $balance <= 0 => 'paid',
            $paidAmount < $totalAmount => 'partial',
            default => 'paid',
        };

        if ($this->status === 'void') {
            $status = 'void';
        }

        $this->forceFill([
            'balance' => $balance,
            'status' => $status,
        ])->saveQuietly();
    }

    protected function casts(): array
    {
        return [
            'total_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
            'balance' => 'decimal:2',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
