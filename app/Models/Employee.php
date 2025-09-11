<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'phone', 'address',
    ];

    /**
     * Resolve the values of an employee for given criteria
     *
     * @param Collection<Criteria> $criteria
     * @return array
     */
    public function resolveValues(Collection $criteria)
    {
        // just make sure the criteria is sorted by id
        $criteria = $criteria->sortBy('id')->values();

        $this->loadMissing('criteriaOptions.criteriaOption', 'criteriaValues');

        $values = [];

        /**
         * @var Criteria $criterion
         */
        foreach ($criteria as $criterion) {
            if ($criterion->value_type->isOption()) {
                $value = optional(optional($this->criteriaOptions->where('criteria_id', $criterion->id)->first())->criteriaOption)->value;
            } else {
                $value = optional($this->criteriaValues->where('criteria_id', $criterion->id)->first())->value;
            }

            $values[] = $value;
        }

        return $values;
    }

    /**
     * The user that this employee belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    /**
     * Get the criteria options for the employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function criteriaOptions()
    {
        return $this->hasMany(EmployeeCriteriaOption::class);
    }

    /**
     * Get the criteria values for the employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function criteriaValues()
    {
        return $this->hasMany(EmployeeCriteriaValue::class);
    }
}
