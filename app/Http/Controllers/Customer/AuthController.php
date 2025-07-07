<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        Log::info('Customer login attempt', ['email' => $credentials['email']]);

        if (\Illuminate\Support\Facades\Auth::guard('customer')->attempt($credentials)) {
            $request->session()->regenerate();
            Log::info('Customer login successful', ['email' => $credentials['email']]);
            return redirect()->intended(route('customer.home'));
        }

        Log::warning('Customer login failed', ['email' => $credentials['email']]);

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }
} 