<?php

namespace Modules\CustomerRetail\Http\Controllers\Customer;

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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Send welcome/confirmation email
        $user->notify(new CustomerWelcome());

        Auth::guard('web')->login($user);

        return redirect()->route('customer.home')->with('success', 'Registration successful!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('customer.home')->with('success', 'You have been logged out successfully!');
    }
} 