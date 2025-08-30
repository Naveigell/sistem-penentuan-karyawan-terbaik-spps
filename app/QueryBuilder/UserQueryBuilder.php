<?php

namespace App\QueryBuilder;

use App\Models\Admin;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Builder;

/**
 * @mixin \App\Models\User
 */
class UserQueryBuilder extends Builder
{
    /**
     * Scope a query to only include users that are employees.
     *
     * @return $this
     */
    public function whereEmployee()
    {
        return $this->whereHasMorph('userable', [Employee::class]);
    }

    /**
     * Scope a query to only include users that are admins.
     *
     * @return $this
     */
    public function whereAdmin()
    {
        return $this->whereHasMorph('userable', [Admin::class]);
    }
}
