<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\SettingsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function index()
    {
        $logo = SettingsModel::select('logo')->first();
        return view('Auth.login',compact('logo'));
    }

    public function login(LoginRequest $request)
    {
        if ($request->validated()) {
            try {
                $credentials = $request->validated();
                if (Auth::attempt($credentials)) {
                    $user = Auth::user();
                    if ($user->role === 'admin') {
                        return redirect()->route('admin.index')->with('success', 'Loggedin successful.');
                    } else {
                        return redirect()->route('user.index')->with('success', 'Loggedin successful.');
                    }
                }else {
                    // Invalid credentials
                    return back()->withErrors([
                        'email' => 'The provided credentials do not match our records.',
                    ])->onlyInput('email');
                }
            } catch (\Exception $e) {
                // Log the error
                Log::error('Login error: ' . $e->getMessage());
                return redirect()->route('login')->withErrors(['error' => 'Something went wrong. Please try again.']);
            }
        }
    }
}
