<?php

namespace App\Models;

use App\Traits\Models\HasTableName;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeCriteriaOption extends Pivot
{
    use HasTableName, SoftDeletes;

    protected $table = 'employee_criteria_options';

    protected $fillable = [
        'employee_id',
        'criteria_id',
        'criteria_option_id',
        'deleted_at',
    ];

    /**
     * Get the employee that this pivot belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the criteria that this pivot belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }

    /**
     * Get the criteria option that this pivot belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criteriaOption()
    {
        return $this->belongsTo(CriteriaOption::class);
    }
}
