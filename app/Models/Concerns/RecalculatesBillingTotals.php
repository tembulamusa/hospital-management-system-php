<?php

namespace App\Models\Concerns;

trait RecalculatesBillingTotals
{
    public function recalculateTotals(): void
    {
        if (! $this->exists) {
            return;
        }

        $paidAmount = (float) $this->payments()->sum('amount');
        $totalAmount = (float) $this->total_amount;
        $balance = max(0, round($totalAmount - $paidAmount, 2));

        $status = match (true) {
            $totalAmount <= 0 => 'paid',
            $paidAmount <= 0 => 'unpaid',
            $balance <= 0 => 'paid',
            $paidAmount < $totalAmount => 'partial',
            default => 'paid',
        };

        $this->forceFill([
            'paid_amount' => $paidAmount,
            'balance' => $balance,
            'status' => $status,
        ])->saveQuietly();
    }
}
