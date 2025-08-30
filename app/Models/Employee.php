<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    /**
     * Get the criteria options for the employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function criteriaOption()
    {
        return $this->hasMany(EmployeeCriteriaOption::class);
    }

    /**
     * Get the criteria values for the employee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function criteriaValue()
    {
        return $this->hasMany(EmployeeCriteriaValue::class);
    }
}
