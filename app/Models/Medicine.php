<?php

namespace App\Models;

use App\Models\Concerns\SoftDeletesRecord;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'generic_name',
    'stock_quantity',
    'selling_price',
    'expiry_date',
])]
class Medicine extends Model
{
    use SoftDeletesRecord;

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
        ];
    }

    public function prescriptionItems(): HasMany
    {
        return $this->hasMany(PrescriptionItem::class, 'drug_id');
    }
}
