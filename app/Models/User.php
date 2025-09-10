<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\QueryBuilder\UserQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'email_verified_at',
        'userable_id',
        'userable_type',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Set the user's password.
     *
     * @param string $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the criteria that this user has.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Criteria>
     */
    public function criteriaOptions()
    {
        return $this->belongsToMany(Criteria::class, EmployeeCriteriaOption::pluralTableFullName(), 'employee_id', 'criteria_id')
            ->using(EmployeeCriteriaOption::class)
            ->withPivot('criteria_option_id');
    }

    /**
     * Get the criteria values for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Criteria>
     */
    public function criteriaValues()
    {
        return $this->belongsToMany(Criteria::class, EmployeeCriteriaValue::pluralTableFullName(), 'employee_id', 'criteria_id')
            ->using(EmployeeCriteriaValue::class)
            ->withPivot('value');
    }

    /**
     * Get the userable model (Employee or Admin) that this User belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo<Employee|Admin>
     */
    public function userable()
    {
        return $this->morphTo();
    }

    /**
     * Get a new query builder instance for the User model.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder|UserQueryBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new UserQueryBuilder($query);
    }
}
