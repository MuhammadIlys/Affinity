<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmployeesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(){
        $user = Auth::user();
        $amount = $user->total_amount;
        $referred_users = EmployeesModel::where('refered_by',$user->id)
        ->count();
        return view('User.index',compact('amount','referred_users','user'));
    }
}
