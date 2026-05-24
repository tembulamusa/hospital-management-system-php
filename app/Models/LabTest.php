<?php

namespace App\Models;

use App\Models\Concerns\SoftDeletesRecord;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'price'])]
class LabTest extends Model
{
    use SoftDeletesRecord;

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function requests(): HasMany
    {
        return $this->hasMany(LabRequest::class);
    }
}
