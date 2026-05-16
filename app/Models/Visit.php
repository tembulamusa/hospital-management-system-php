<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

#[Fillable([
    'patient_id',
    'doctor_id',
    'visit_number',
    'status',
    'chief_complaint',
])]
class Visit extends Model
{
    protected static function booted(): void
    {
        static::creating(function (self $visit): void {
            if (blank($visit->visit_number)) {
                $visit->visit_number = 'VST-' . strtoupper(Str::random(8));
            }
        });
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function triage(): HasOne
    {
        return $this->hasOne(NurseTriage::class);
    }

    public function doctorNote(): HasOne
    {
        return $this->hasOne(DoctorNote::class);
    }

    public function prescription(): HasOne
    {
        return $this->hasOne(Prescription::class);
    }

    public function labRequests(): HasMany
    {
        return $this->hasMany(LabRequest::class);
    }

    public function billing(): HasOne
    {
        return $this->hasOne(Billing::class);
    }
}
