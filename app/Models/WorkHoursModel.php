<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHoursModel extends Model
{
    use HasFactory;
    protected $table = 'work_hours';
    protected $fillable = [
        'employee_id',
        'referrer_id',
        'connecteam_user_id',
        'timeclock_id',
        'timeclock_name',
        'from_date',
        'to_date',
        'total_hours',
    ];
}
