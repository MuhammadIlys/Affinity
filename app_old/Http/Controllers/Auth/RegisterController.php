<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\SettingsModel;
use App\Models\User;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log as FacadesLog;

class RegisterController extends Controller
{
    public function index()
    {
        $logo = SettingsModel::select('logo')->first();
        return view('Auth.register',compact('logo'));
    }

    public function store(RegisterRequest $request)
    {
        if ($request->validated()) {
            try {
                $validatedData = $request->validated();
                $user = User::create([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => Hash::make($validatedData['password']),
                    'role' => 'admin',
                ]);
    
                // Log the user in
                if (Auth::attempt(['email' => $validatedData['email'], 'password' => $request->password])) {
                    return redirect()->route('admin.index')->with('success', 'Registration successful.');
                } else {
                    // Authentication failed, redirect back to register with an error
                    return redirect()->route('register')->withErrors(['error' => 'Something went wrong during registration. Please try again.']);
                }
    
            } catch (\Exception $e) {
                // Log the error
                FacadesLog::error('Registration error: ' . $e->getMessage());
                return redirect()->route('register')->withErrors(['error' => 'Something went wrong. Please try again.']);
            }
        }
    }
}
