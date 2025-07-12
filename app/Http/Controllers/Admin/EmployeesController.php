<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeesModel;
use App\Models\User;
use App\Services\ConnecteamService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EmployeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $employees = EmployeesModel::with('referrer')->get();
        $employees = EmployeesModel::with('referrer')->get();
        // return $employees;
        return view('Admin.employee.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $referrers = User::where('role', 'user')->get();
        return view('Admin.employee.create', compact('referrers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ConnecteamService $connecteam)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'job_title' => 'required|string|max:255',
            'dob' => 'required|max:255',
            'phone' => ['required', 'regex:/^\+[1-9]\d{9,14}$/'],
            'address' => 'required|string|max:255',
        ]);

        $employee = EmployeesModel::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'job_title' => $request->job_title,
            'dob' => $request->dob,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'status' => $request->status,
            'refered_by' => $request->referred_by,
        ]);

        if ($employee) {
            // Prepare data for Connecteam
            $userData = [
                "userType"     => "user",
                "isArchived"   => false,
                "firstName"    => $employee->first_name,
                "lastName"     => $employee->last_name,
                "phoneNumber"  => $employee->phone,
                "email"        => $employee->email,
                "gender"        => $employee->gender,
                "dob"        => $employee->dob,
            ];

            $userData['phoneNumber'] = preg_replace('/[^\d+]/', '', $userData['phoneNumber']);

            // Create user in Connecteam
            $result = $connecteam->createUser($userData);
            if ($result['success']) {
                $connecteamUserId = $result['response']['data']['results'][0]['userId'] ?? null;
                $kioskcode = $result['response']['data']['results'][0]['kioskCode'] ?? null;

                if ($connecteamUserId) {
                    $employee->update([
                        'connecteam_user_id' => $connecteamUserId,
                        'kioskcode' => $kioskcode
                    ]);
                }
            } else {
                Log::warning("Failed to create Connecteam user for employee ID {$employee->id}: " . json_encode($result['error']));
                return redirect()->back()->with('error', 'Something went wrong kindly try again');
            }
        }
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = EmployeesModel::findorfail($id);
        return view('Admin.employee.employee_details',compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = EmployeesModel::findorfail($id);
        $referrers = User::where('role', 'user')->get();

        return view('Admin.employee.create', compact('employee', 'referrers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = EmployeesModel::findOrFail($id);
        $employee->first_name = $request->first_name;
        $employee->last_name = $request->last_name;
        $employee->job_title = $request->job_title;
        $employee->dob = $request->dob;
        $employee->gender = $request->gender;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->refered_by = $request->referred_by;
        $employee->status = $request->status;

        if ($employee->save()) {
            return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
        } else {
            return redirect()->route('employees.index')->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = decrypt($id);
        $employee = EmployeesModel::findorfail($id);
        if ($employee->delete()) {
            return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
        } else {
            return redirect()->route('employees.index')->with('error', 'Something went wrong');
        }
    }
    public function getConnecteamUser($id, ConnecteamService $connecteam)
    {
        $employee = EmployeesModel::findOrFail($id);

        if (!$employee->connecteam_user_id) {
            return back()->with('error', 'No Connecteam user ID found for this employee.');
        }

        try {
            $result = $connecteam->getUser($employee->connecteam_user_id);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString()
            ], 500);
        }

        dd($result); // This line was preventing the code below from executing

        if ($result['success']) {
            // Based on the commented out code, it seems you intended to return a view
            // or the raw result depending on the desired behavior.
            // I'm assuming you want to return the view based on the commented out code.
            $user = $result['response']['data']['results'][0] ?? null;
            return view('Admin.Employees.connecteam-user', compact('user', 'employee'));
        } else {
            // If not successful, return an error message to the user.
            return back()->with('error', 'Failed to fetch user from Connecteam. ' . json_encode($result['error']));
        }
    }
}
