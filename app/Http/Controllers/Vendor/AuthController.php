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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

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
                'businessName' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:vendors,email',
                'contact' => 'required|string|max:20',
                'address' => 'required|string',
                'yearOfEstablishment' => 'required|integer|min:1900|max:' . date('Y'),
                'password' => 'required|string|min:8',
                'passwordConfirmation' => 'required|string|same:password',
                'applicationForm' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
                'complianceCertificate' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
                'bankStatement' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            ]);

            if ($validator->fails()) {
                \Log::error('Vendor registration validation failed', $validator->errors()->toArray());
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Validation failed: ' . json_encode($validator->errors()->all()));
            }

            // Validate with Java server before creating vendor
            $javaValidationResult = $this->validateWithJavaServer($request);
            
            if (!$javaValidationResult['success']) {
                return redirect()->back()
                    ->withErrors(['java_validation' => $javaValidationResult['message']])
                    ->withInput()
                    ->with('error', 'Vendor validation failed: ' . $javaValidationResult['message']);
            }

            // Save vendor locally as well
            $vendor = Vendor::create([
                'business_name' => $request->businessName,
                'email' => $request->email,
                'contact' => $request->contact,
                'address' => $request->address,
                'yearOfEstablishment' => $request->yearOfEstablishment,
                'password' => Hash::make($request->password),
                'application_form' => $request->file('applicationForm') ? $request->file('applicationForm')->getClientOriginalName() : null,
                'compliance_certificate' => $request->file('complianceCertificate') ? $request->file('complianceCertificate')->getClientOriginalName() : null,
                'bank_statement' => $request->file('bankStatement') ? $request->file('bankStatement')->getClientOriginalName() : null,
            ]);

            return redirect()->route('vendor.login')->with('success', 'Registration successful! Please check your email for your password.');
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

    /**
     * Validate vendor data with Java server
     */
    private function validateWithJavaServer(Request $request): array
    {
        try {
            // Configure Java server URL - update this with your actual Java server URL
            $javaServerUrl = env('SPRING_API_URL', 'http://localhost:8080/api') . '/validate-vendor';
            
            $validationData = [
                'business_name' => $request->businessName,
                'email' => $request->email,
                'phone' => $request->contact,
                'address' => $request->address,
                'year_of_establishment' => $request->yearOfEstablishment,
                'contact' => $request->contact,
            ];

            // Make HTTP request to Java server
            $response = Http::timeout(30)->post($javaServerUrl, $validationData);
            
            if ($response->successful()) {
                $result = $response->json();
                
                return [
                    'success' => $result['success'] ?? false,
                    'errors' => $result['errors'] ?? [],
                    'data' => $result['data'] ?? null,
                    'message' => $result['message'] ?? 'Validation completed'
                ];
            } else {
                // If Java server is not available, log the error but continue with registration
                Log::warning('Java validation server not available', [
                    'url' => $javaServerUrl,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                
                return [
                    'success' => true, // Continue with registration if Java server is down
                    'errors' => [],
                    'data' => null,
                    'message' => 'Java validation server not available, proceeding with registration'
                ];
            }
            
        } catch (\Exception $e) {
            Log::error('Java validation server error', [
                'error' => $e->getMessage(),
                'vendor_data' => $request->only(['businessName', 'email', 'contact', 'address'])
            ]);
            
            // If Java server is completely unavailable, continue with registration
            return [
                'success' => true,
                'errors' => [],
                'data' => null,
                'message' => 'Java validation server unavailable, proceeding with registration'
            ];
        }
    }
} 