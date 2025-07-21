<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\EmployeesModel;
use App\Models\TransactionsModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $referrers = User::where('role', 'user')->count();
        $employees = EmployeesModel::count();
        $admins = User::where('role', 'admin')->count();
        $total_amount = $user->total_amount;
        $pending_payouts = TransactionsModel::where('status', 'pending')->sum('total_amount');
        $completed_payouts = TransactionsModel::where('status', 'completed')->sum('total_amount');
        return view('Admin.index', compact('pending_payouts','completed_payouts','user', 'referrers', 'employees', 'admins', 'total_amount'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('Admin.profile.profile', compact('user'));
    }

    public function saveProfile(Request $request)
    {
        $validated = $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'gender'       => 'nullable|in:male,female',
            'dob'          => 'nullable|date',
            'role'         => 'required|string|max:50',
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:1000',
        ]);

        // Clean up carriage returns in address
        if (isset($validated['address'])) {
            $validated['address'] = str_replace(["\r\n", "\r", "\n"], ' ', $validated['address']);
        }

        // Fetch user and update
        $user = Auth::user();
        $user->update($validated);
        return redirect()->back()->with('success', 'User updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password'       => 'required',                // Current password
            'newpassword'    => 'required|min:6',
            'renewpassword'  => 'required|same:newpassword',
        ]);

        $user = Auth::user();

        // Check if current password matches
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Current password is incorrect.'])->withInput();
        }

        // Update password
        $user->password = Hash::make($request->newpassword);
        $user->password_text = $request->newpassword; // optional, only if you're storing plain text
        $user->save();

        return back()->with('success', 'Password changed successfully!');
    }

    public function saveProfileImage(Request $request)
    {

        // Validate the image file
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:2048',  // Adjust size limit as needed
        ]);

        // Check if the user is logged in
        $user = Auth::user();  // Assuming the user is logged in

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension(); // Generate a unique image name

            // Define the destination path
            $destinationPath = public_path('assets/users');

            // Store the image
            $image->move($destinationPath, $imageName);

            // Update user profile image in the database
            $user->image = 'assets/users/' . $imageName;
            $user->save();

            // Return the image URL to the frontend
            return response()->json([
                'success' => true,
                'imageUrl' => asset($user->image),  // Use asset() to get the full URL for the uploaded image
            ]);
        }
    }
}
