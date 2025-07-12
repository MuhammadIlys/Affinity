<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referred_employeesModel extends Model
{
    use HasFactory;
    protected $table = 'referred_employees';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'hours_worked',
        'total_amount',
        'status',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
