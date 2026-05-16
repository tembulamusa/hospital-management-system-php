<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'visit_id',
    'assessment',
    'diagnosis',
    'plan',
])]
class DoctorNote extends Model
{
    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class);
    }
}
