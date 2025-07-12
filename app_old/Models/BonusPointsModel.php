<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusPointsModel extends Model
{
    use HasFactory;
    protected $table = 'bonus_points';
    protected $fillable = ['referrer_id','employee_id','work_hours_id'];
}
