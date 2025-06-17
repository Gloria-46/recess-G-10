<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('vendor.auth.login');
    }

    public function showRegisterForm()
    {
        return view('vendor.auth.register');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::guard('vendor')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('vendor.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'business_name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:vendors',
                'password' => 'required|string|min:8|confirmed',
                'phone' => 'nullable|string|max:20',
                'address' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                // Log validation errors
                \Log::error('Vendor registration validation failed', $validator->errors()->toArray());
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Validation failed: ' . json_encode($validator->errors()->all()));
            }

            $vendor = Vendor::create([
                'business_name' => $request->business_name,
                'email' => $request->email,
                'password' => \Hash::make($request->password),
                'phone' => $request->phone,
                'address' => $request->address,
                'about' => '',
                'profile_image' => null,
                'is_active' => true,
            ]);

            if (!$vendor) {
                \Log::error('Vendor registration failed: Vendor not created');
                return redirect()->back()->with('error', 'Vendor could not be created.');
            }

            \Log::info('Vendor registered successfully', ['id' => $vendor->id, 'email' => $vendor->email]);
            \Auth::guard('vendor')->login($vendor);

            return redirect()->route('vendor.dashboard')->with('success', 'Registration successful!');
        } catch (\Exception $e) {
            \Log::error('Vendor registration exception', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Registration failed: ' . $e->getMessage());
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('vendor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('vendor.login');
    }

    public function showForgotPasswordForm()
    {
        return view('vendor.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $vendor = Vendor::where('email', $request->email)->first();
        if (!$vendor) {
            return back()->with('error', 'We can\'t find a vendor with that email address.');
        }

        // Generate token
        $token = Str::random(60);
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'email' => $request->email,
                'token' => Hash::make($token),
                'created_at' => Carbon::now(),
            ]
        );

        // Send email (simple inline, you can use notifications if preferred)
        $resetUrl = url(route('vendor.password.reset', ['token' => $token, 'email' => $request->email], false));
        Mail::raw("Reset your password: $resetUrl", function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Vendor Password Reset');
        });

        return back()->with('status', 'We have emailed your password reset link!');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        $email = $request->query('email');
        return view('vendor.auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $reset = DB::table('password_resets')
            ->where('email', $request->email)
            ->first();

        if (!$reset || !Hash::check($request->token, $reset->token)) {
            return back()->with('error', 'This password reset token is invalid.');
        }

        $vendor = Vendor::where('email', $request->email)->first();
        if (!$vendor) {
            return back()->with('error', 'We can\'t find a vendor with that email address.');
        }

        $vendor->password = Hash::make($request->password);
        $vendor->save();

        // Delete the reset record
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('vendor.login')->with('status', 'Your password has been reset! You can now log in.');
    }
} 