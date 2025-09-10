<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

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
