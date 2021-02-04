<?php

namespace App\Models\AttendanceRegister;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class AttendanceRegister extends Model implements AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attendanceRegister';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['day1', 'day1Register', 'day2', 'day2Register', 'day3', 'day3Register', 'day4', 'day4Register',
        'day5', 'day5Register', 'day6', 'day6Register', 'day7', 'day7Register', 'last_captureDate', 'employee_id'];

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

    public function AttendanceRegister()
    {
        return $this->hasMany('App\Models\Employee\Employee');
    }

}
