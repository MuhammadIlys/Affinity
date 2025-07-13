<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeesModel extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'gender',
        'job_title',
        'phone',
        'dob',
        'address',
        'status',
        'refered_by',
        'total_amount',
        'connecteam_user_id'
    ];
    public function referrer()
    {
        return $this->belongsTo(User::class, 'refered_by')
            ->select('id', 'first_name', 'last_name');
    }
}
