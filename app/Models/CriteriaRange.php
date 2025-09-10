<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CriteriaRange extends Model
{
    use SoftDeletes;

    /**
     * Get the criteria that owns the CriteriaRange
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
