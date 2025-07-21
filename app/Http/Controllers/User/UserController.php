<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EmployeesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $amount = $user->total_amount;
        $referred_users = EmployeesModel::where('refered_by', $user->id)
            ->count();
        return view('User.index', compact('amount', 'referred_users', 'user'));
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
