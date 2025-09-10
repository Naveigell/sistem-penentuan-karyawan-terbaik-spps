<?php

namespace App\Models;

use App\Enums\CriteriaValueType;
use App\Utils\DecisionSupportSystem\Enums\CriteriaType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Criteria extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'type', 'value_type', 'weight', 'deleted_at'];

    protected $casts = [
        'type'       =>  CriteriaType::class,
        'value_type' =>  CriteriaValueType::class,
    ];

    /**
     * Return the alphabet for this Criteria.
     *
     * If the Criteria's type is cost, return 'C', otherwise return 'B'.
     *
     * @return string
     */
    public function alphabet()
    {
        return $this->type->isCost() ? 'C' : 'B';
    }

    /**
     * The options that belong to the Criteria
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function options()
    {
        return $this->hasMany(CriteriaOption::class, 'criteria_id');
    }

    /**
     * Get the range for the Criteria
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function range()
    {
        return $this->hasOne(CriteriaRange::class, 'criteria_id');
    }
}
