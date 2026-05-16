<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'visit_id',
    'temperature',
    'blood_pressure_systolic',
    'blood_pressure_diastolic',
    'pulse_rate',
    'weight',
    'height',
])]
class NurseTriage extends Model
{
    protected function casts(): array
    {
        return [
            'temperature' => 'decimal:2',
            'weight' => 'decimal:2',
            'height' => 'decimal:2',
        ];
    }

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
