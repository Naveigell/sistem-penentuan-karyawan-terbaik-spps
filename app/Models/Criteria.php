<?php

namespace App\Models;

use App\Enums\CriteriaValueType;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    protected $fillable = ['name', 'type', 'value_typ', 'weight', 'deleted_at'];

    protected $casts = [
        'type'       =>  CriteriaValueType::class,
        'value_type' =>  CriteriaValueType::class,
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
