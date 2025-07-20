<?php

namespace App\Http\Controllers;

use App\Models\AllowedEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.signup');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:7|max:255',
            'terms' => 'accepted',
        ], [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'password.required' => 'Password is required',
            'terms.accepted' => 'You must accept the terms and conditions'
        ]);

        $email = strtolower(trim($request->email));

        if (str_ends_with($email, '@admin.uptrend.com')) {
            $allowed = \App\Models\AllowedEmail::whereRaw('LOWER(email) = ?', [$email])->where('role', 'admin')->exists();
            if (!$allowed) {
                return back()->withErrors(['email' => 'This admin email is not allowed.'])->withInput($request->except('password'));
            }
            $role = 'admin';
        } elseif (str_ends_with($email, '@vendor.uptrend.com')) {
            $allowed = \App\Models\AllowedEmail::whereRaw('LOWER(email) = ?', [$email])->where('role', 'vendor')->exists();
            if (!$allowed) {
                return back()->withErrors(['email' => 'This vendor email is not allowed.'])->withInput($request->except('password'));
            }
            $role = 'vendor';
        } elseif (str_ends_with($email, '@warehouse.uptrend.com')) {
            $allowed = \App\Models\AllowedEmail::whereRaw('LOWER(email) = ?', [$email])->where('role', 'warehouse')->exists();
            if (!$allowed) {
                return back()->withErrors(['email' => 'This warehouse email is not allowed.'])->withInput($request->except('password'));
            }
            $role = 'warehouse';
        // } elseif (str_ends_with($email, '@retailer.uptrend.com')) {
        //     $allowed = \App\Models\AllowedEmail::whereRaw('LOWER(email) = ?', [$email])->where('role', 'retailer')->exists();
        //     if (!$allowed) {
        //         return back()->withErrors(['email' => 'This retailer email is not allowed.'])->withInput($request->except('password'));
        //     }
        //     $role = 'retailer';
        } else {
            $role = 'customer'; 
        }
        
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => $role,
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        // return redirect(\App\Providers\RouteServiceProvider::HOME);
        switch ($user->role) {
            case 'admin':
                return redirect('/admin/dashboard');
            case 'vendor':
                return redirect('/vendor/dashboard');
            // case 'retailer':
            //     return redirect('/retailer/dashboard');
            case 'warehouse':
                return redirect('/warehouse/dashboard');
            case 'customer':
                return redirect('/customer/home');
            default:
                return redirect('/'); // fallback
            // $dd($user->role)
        }
    }
} 