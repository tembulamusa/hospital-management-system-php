<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
}
