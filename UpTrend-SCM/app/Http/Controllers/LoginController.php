<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.signin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');
        $email = $request->email;

        if (str_ends_with($email, '@retailer.uptrend.com')) {
            \Log::info('Attempting retailer login for: ' . $email);
            if (Auth::guard('retailer')->attempt($credentials, $remember)) {
                \Log::info('Retailer login successful for: ' . $email);
                $request->session()->regenerate();
                $user = Auth::guard('retailer')->user();
                $email = $user->email;
                // Always redirect to retailer dashboard
                return redirect(route('retailer.dashboard'));
            }
            \Log::warning('Retailer login failed for: ' . $email);
            return back()->withErrors(['message' => 'Retailer credentials do not match our records.'])->withInput($request->only('email'));
        }

        if (str_ends_with($email, '@customer.uptrend.com')) {
            \Log::info('Attempting customer login for: ' . $email);
            if (Auth::guard('web')->attempt($credentials, $remember)) {
                \Log::info('Customer login successful for: ' . $email);
                $request->session()->regenerate();
                $user = Auth::guard('web')->user();
                $email = $user->email;
                return redirect('/customer/dashboard');
            }
            \Log::warning('Customer login failed for: ' . $email);
            return back()->withErrors(['message' => 'Customer credentials do not match our records.'])->withInput($request->only('email'));
        }

        \Log::info('Attempting web login for: ' . $email);
        // Default to web guard for all other users
        if (Auth::attempt($credentials, $remember)) {
            \Log::info('Web login successful for: ' . $email);
            $request->session()->regenerate();
            // ... your existing role logic here ...
            $user = Auth::user();
            $email = $user->email;

            // Check for special roles
            if (str_ends_with($email, '@admin.uptrend.com')) {
                $allowed = \App\Models\AllowedEmail::where('email', $email)->where('role', 'admin')->exists();
                if (!$allowed) {
                    Auth::logout();
                    return back()->withErrors(['message' => 'This admin email is not allowed.'])->withInput($request->only('email'));
                }
                $user->role = 'admin';
            } elseif (str_ends_with($email, '@vendor.uptrend.com')) {
                $allowed = \App\Models\AllowedEmail::where('email', $email)->where('role', 'vendor')->exists();
                if (!$allowed) {
                    Auth::logout();
                    return back()->withErrors(['message' => 'This vendor email is not allowed.'])->withInput($request->only('email'));
                }
                $user->role = 'vendor';
            } elseif (str_ends_with($email, '@warehouse.uptrend.com')) {
                $allowed = \App\Models\AllowedEmail::where('email', $email)->where('role', 'warehouse')->exists();
                if (!$allowed) {
                    Auth::logout();
                    return back()->withErrors(['message' => 'This warehouse email is not allowed.'])->withInput($request->only('email'));
                }
                $user->role = 'warehouse';
            } elseif (str_ends_with($email, '@retailer.uptrend.com')) {
                $user->role = 'retailer';
            } else {
                // Default to customer
                $user->role = 'customer';
            }

            // Only save if the role column exists
            try {
                $user->save();
            } catch (\Exception $e) {
                // If role column doesn't exist, continue without saving role
            }

            $request->session()->regenerate();
            // Redirect directly to the user's dashboard
            switch ($user->role) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'vendor':
                    return redirect('/vendor/dashboard');
                case 'warehouse':
                    return redirect('/warehouse/dashboard');
                case 'retailer':
                    return redirect('/retailer/dashboard');
                default:
                    return redirect('/customer/home');
            }
        }
        \Log::warning('Web login failed for: ' . $email);

        return back()->withErrors([
            'message' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
} 