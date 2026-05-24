<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\SoftDeletes;

trait SoftDeletesRecord
{
    use SoftDeletes;
}
