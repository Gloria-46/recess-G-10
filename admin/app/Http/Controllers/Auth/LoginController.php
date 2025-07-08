<?php

namespace App\Http\Controllers\Auth;

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
        return view('auth.signin');
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
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
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
