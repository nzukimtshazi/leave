<?php

namespace App\Models\HoursWorked;

use Illuminate\Database\Eloquent\Model;

class HoursWorked extends Model
{
    protected $casts = [
        'days' => 'array'
    ];

    protected $casts2 = [
        'hours' => 'array'
    ];
}
