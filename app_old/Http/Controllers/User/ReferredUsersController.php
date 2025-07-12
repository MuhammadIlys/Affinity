<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmployeesModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReferredUsersController extends Controller
{
    
    public function referredUsers(){
        $referred_users = EmployeesModel::where('refered_by',Auth::user()->id)->select('first_name','last_name','email','refered_by','job_title','phone','total_amount','status')
        ->with('referrer')
        ->get();
        // return $referred_users;
        return view('User.referred_users.index',compact('referred_users'));
    }

}
