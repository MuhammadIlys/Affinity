<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeesModel;
use App\Models\SettingsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ReferrerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $referrers = User::where('role', 'user')->get();
        $referrer_percent = SettingsModel::value('referrer_percent'); // returns value directly

        // Add earnings to each referrer
        foreach ($referrers as $referrer) {
            $referredEmployees = EmployeesModel::where('refered_by', $referrer->id)->get();

            $totalEarnings = 0;
            foreach ($referredEmployees as $employee) {
                $totalEarnings += ($employee->total_amount * $referrer_percent) / 100;
            }

            // Add earnings as a custom attribute
            $referrer->referral_earnings = round($totalEarnings, 2);
        }
        return view('Admin.referrer.index', compact('referrers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $referrers = User::where('role', 'user')->get();
        return view('Admin.referrer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'job_title' => 'required|string|max:255',
            'dob' => 'required|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'job_title' => $request->job_title,
            'dob' => $request->dob,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'user',
            'status' => $request->status,
            'createdby' => Auth::user()->id,
            'password_text' => encrypt($request->password),
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('referrers.index')->with('success', 'Referrer created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $referrer = User::findorfail($id);
        $total_amount = calculate_referrer_bonus($referrer);
        $referrer->total_amount = $total_amount;
        return view('Admin.referrer.referrer_details', compact('referrer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $referrer = User::findorfail($id);
        return view('Admin.referrer.create', compact('referrer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return $request->status;
        $user = User::findOrFail($id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->job_title = $request->job_title;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = $request->status;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->password_text = encrypt($request->password);
        }

        if ($user->save()) {
            return redirect()->route('referrers.index')->with('success', 'Referrer updated successfully.');
        } else {
            return redirect()->route('referrers.index')->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = decrypt($id);
        $referrer = User::findorfail($id);
        if ($referrer->delete()) {
            return redirect()->route('referrers.index')->with('success', 'Referrer deleted successfully.');
        } else {
            return redirect()->route('referrers.index')->with('error', 'Something went wrong');
        }
    }
}
