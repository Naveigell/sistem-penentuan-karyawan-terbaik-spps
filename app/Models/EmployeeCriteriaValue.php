<?php

namespace App\Models;

use App\Traits\Models\HasTableName;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EmployeeCriteriaValue extends Pivot
{
    use HasTableName;

    protected $fillable = [
        'employee_id', 'criteria_id', 'value', 'deleted_at',
    ];

    /**
     * The employee that this value belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * The criteria that this value belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function criteria()
    {
        return $this->belongsTo(Criteria::class);
    }
}
