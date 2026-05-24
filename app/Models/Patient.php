<?php

namespace App\Models;

use App\Filament\Support\PaymentStatus;
use App\Models\Concerns\SoftDeletesRecord;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

#[Fillable([
    'patient_number',
    'first_name',
    'last_name',
    'date_of_birth',
    'gender',
    'phone',
    'email',
    'address',
    'blood_group',
    'insurance_provider',
    'insurance_number',
    'photo',
])]
class Patient extends Model
{
    use SoftDeletesRecord;

    protected static function booted(): void
    {
        static::creating(function (self $patient): void {
            if (blank($patient->patient_number)) {
                $patient->patient_number = 'PT-' . strtoupper(Str::random(8));
            }
        });
    }

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
        ];
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    public function billings(): HasMany
    {
        return $this->hasMany(Billing::class);
    }

    public function medicalHistories(): HasMany
    {
        return $this->hasMany(MedicalHistory::class)->latest('recorded_at');
    }

    public function nurseTriages(): HasManyThrough
    {
        return $this->hasManyThrough(NurseTriage::class, Visit::class)->latest('nurse_triages.created_at');
    }

    public function doctorNotes(): HasManyThrough
    {
        return $this->hasManyThrough(DoctorNote::class, Visit::class)->latest('doctor_notes.created_at');
    }

    public function prescriptions(): HasManyThrough
    {
        return $this->hasManyThrough(Prescription::class, Visit::class)->latest('prescriptions.created_at');
    }

    public function getPaymentStatusAttribute(): string
    {
        $billings = $this->relationLoaded('billings')
            ? $this->billings
            : $this->billings()->get();

        if ($billings->isEmpty()) {
            return PaymentStatus::NO_BILLING;
        }

        if ($billings->contains('status', 'unpaid')) {
            return PaymentStatus::UNPAID;
        }

        if ($billings->contains('status', 'partial')) {
            return PaymentStatus::PARTIAL;
        }

        if ($billings->every(fn (Billing $billing): bool => $billing->status === 'paid')) {
            return PaymentStatus::PAID;
        }

        if ($billings->every(fn (Billing $billing): bool => $billing->status === 'void')) {
            return PaymentStatus::VOID;
        }

        return PaymentStatus::PARTIAL;
    }

    public function getTotalBilledAttribute(): float
    {
        $billings = $this->relationLoaded('billings')
            ? $this->billings
            : $this->billings()->get();

        return (float) $billings->sum('total_amount');
    }

    public function getTotalPaidAttribute(): float
    {
        $billings = $this->relationLoaded('billings')
            ? $this->billings
            : $this->billings()->get();

        return (float) $billings->sum('paid_amount');
    }

    public function getOutstandingBalanceAttribute(): float
    {
        $billings = $this->relationLoaded('billings')
            ? $this->billings
            : $this->billings()->get();

        return (float) $billings->sum('balance');
    }

    public function scopeWherePaymentStatus(Builder $query, string $status): Builder
    {
        return match ($status) {
            PaymentStatus::NO_BILLING => $query->whereDoesntHave('billings'),
            PaymentStatus::PAID => $query->whereHas('billings')
                ->whereDoesntHave('billings', fn (Builder $billingQuery) => $billingQuery->whereIn('status', ['unpaid', 'partial'])),
            PaymentStatus::UNPAID => $query->whereHas('billings', fn (Builder $billingQuery) => $billingQuery->where('status', 'unpaid')),
            PaymentStatus::PARTIAL => $query->whereHas('billings', fn (Builder $billingQuery) => $billingQuery->where('status', 'partial')),
            default => $query,
        };
    }
}
