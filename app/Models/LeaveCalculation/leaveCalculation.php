<?php

namespace App\Models\LeaveCalculation;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class LeaveCalculation extends Model implements AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'leaveCalculation';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['annualLeaveCnt', 'sickLeaveCnt', 'familyRespLeaveCnt', 'employee_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    //protected $hidden = ['remember_token'];
    public static function all($columns = ['*'])
    {//override function to order by name
        $columns = is_array($columns) ? $columns : func_get_args();

        $instance = new static;

        return $instance->newQuery()->orderBy('employee_id')->get($columns);
    }

}
