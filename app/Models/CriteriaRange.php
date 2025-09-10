<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriteriaRange extends Model
{
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
