<?php

namespace Modules\Admin\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;


class LoginController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin::auth.signin');
    }

    // protected function authenticated(Request $request, $user)
    // {
    //     $email = $user->email;

    //     if (str_ends_with($email, '@adminuptrend.com')) {
    //         $user->role = 'admin';
    //     } elseif (str_ends_with($email, '@vendoruptrend.com')) {
    //         $user->role = 'vendor';
    //     } elseif (str_ends_with($email, '@warehouseuptrend.com')) {
    //         $user->role = 'warehouse';
    //     } elseif (str_ends_with($email, '@retaileruptrend.com')) {
    //         $user->role = 'retailer';
    //     } else {
    //         $user->role = 'customer'; // fallback
    //     }

    //     $user->save();

    //     // Redirect based on role
    //     return match ($user->role) {
    //     'admin' => view('admin::dashboard'),
    //     'vendor' => view('vendor::dashboard'),
    //     'warehouse' => view('warehouse::dashboard'),
    //     'retailer' => view('retailer::dashboard'),
    //     default => view('customer::dashboard'),
    // };
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $rememberMe = $request->rememberMe ? true : false;

        if (Auth::attempt($credentials, $rememberMe)) {
            $user = Auth::user();
            $email = $user->email;

            // Only check allowed_emails for access, do not set or change the role here
            if (str_ends_with($email, '@admin.uptrend.com')) {
                $allowed = \App\Models\AllowedEmail::where('email', $email)->where('role', 'admin')->exists();
                if (!$allowed) {
                    Auth::logout();
                    return back()->withErrors(['message' => 'This admin email is not allowed.'])->withInput($request->only('email'));
                }
            } elseif (str_ends_with($email, '@vendor.uptrend.com')) {
                $allowed = \App\Models\AllowedEmail::where('email', $email)->where('role', 'vendor')->exists();
                if (!$allowed) {
                    Auth::logout();
                    return back()->withErrors(['message' => 'This vendor email is not allowed.'])->withInput($request->only('email'));
                }
            } elseif (str_ends_with($email, '@warehouse.uptrend.com')) {
                $allowed = \App\Models\AllowedEmail::where('email', $email)->where('role', 'warehouse')->exists();
                if (!$allowed) {
                    Auth::logout();
                    return back()->withErrors(['message' => 'This warehouse email is not allowed.'])->withInput($request->only('email'));
                }
            } elseif (str_ends_with($email, '@retailer.uptrend.com')) {
                $allowed = \App\Models\AllowedEmail::where('email', $email)->where('role', 'retailer')->exists();
                if (!$allowed) {
                    Auth::logout();
                    return back()->withErrors(['message' => 'This retailer email is not allowed.'])->withInput($request->only('email'));
                }
            }

            $request->session()->regenerate();

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            }
            if ($user->role === 'vendor') {
                return redirect('/vendor/dashboard');
            }
            if ($user->role === 'warehouse') {
                return redirect('/warehouse/dashboard');
            }
            if ($user->role === 'retailer') {
                return redirect('/retailer/dashboard');
            }
            return redirect('/customer/dashboard');
        }

        return back()->withErrors([
            'message' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email'));
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/sign-in');
    }
}
