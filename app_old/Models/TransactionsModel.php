<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionsModel extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'referrer_id',
        'approved_by',
        'total_amount',
        'status',
    ];
    
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
