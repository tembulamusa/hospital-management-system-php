<?php

namespace App\Models;

use App\Models\Concerns\SoftDeletesRecord;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'patient_id',
    'recorded_by_id',
    'recorded_at',
    'presenting_complaint',
    'history_of_presenting_illness',
    'past_medical_history',
    'past_surgical_history',
    'allergies',
    'current_medications',
    'family_history',
    'social_history',
    'review_of_systems',
    'notes',
])]
class MedicalHistory extends Model
{
    use SoftDeletesRecord;

    protected static function booted(): void
    {
        static::creating(function (self $history): void {
            if (blank($history->recorded_by_id) && auth()->check()) {
                $history->recorded_by_id = auth()->id();
            }

            if (blank($history->recorded_at)) {
                $history->recorded_at = now();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'recorded_at' => 'datetime',
        ];
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by_id');
    }
}
