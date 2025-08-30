<?php

namespace App\Models;

use App\Enums\CriteriaType;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = ['name', 'type', 'weight', 'deleted_at'];

    protected $casts = [
        'type' =>  CriteriaType::class,
    ];

    /**
     * The options that belong to the Criteria
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(CriteriaOption::class, 'criteria_id');
    }
}
