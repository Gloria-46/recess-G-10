<?php
namespace Modules\Vendor\App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'business_name' => ['required', 'string', 'max:255'],
            'physical_address' => ['required', 'string', 'max:255'],
            'tel_no' => ['required', 'string', 'max:50'],
            'year_of_establishment' => ['required', 'integer', 'min:1800', 'max:' . date('Y')],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'business_name' => $validated['business_name'],
            'physical_address' => $validated['physical_address'],
            'tel_no' => $validated['tel_no'],
            'year_of_establishment' => $validated['year_of_establishment'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user); // log the user in

        return redirect()->route('dashboard'); // redirect to dashboard
    }
}
