<?php

namespace Modules\CustomerRetail\App\Http\Controllers\Customer;

use Modules\CustomerRetail\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Modules\CustomerRetail\Notifications\CustomerWelcome;

class SignupController extends Controller
{
    public function show()
    {
        return view('customerretail::customer.signup');
    }

    public function register(Request $request)
    {
        \Log::info('Retailer register called');
        // dd('Retailer register called');
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            // add other retailer fields as needed
        ]);

        // 1. Create the user
        $user = \App\Models\User::create([
            'name' => $validated['business_name'],
            'email' => $validated['email'],
            'password' => \Hash::make($validated['password']),
            'role' => 'retailer', // if you have a role column
        ]);

        // 2. Create the retailer
        $retailer = \Modules\CustomerRetail\App\Models\Retailer::create([
            'business_name' => $validated['business_name'],
            'email' => $validated['email'],
            'password' => \Hash::make($validated['password']),
            'user_id' => $user->id,
            // add other retailer fields as needed
        ]);

        // Log in as retailer
        \Auth::guard('retailer')->login($retailer);

        return redirect()->route('retailer.dashboard')->with('success', 'Registration successful!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('customer.home')->with('success', 'You have been logged out successfully!');
    }
} 