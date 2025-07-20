<?php

namespace Modules\CustomerRetail\App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth('customer')->user();
        return view('customerretail::customer.profile', compact('user'));
    }

    public function edit()
    {
        $user = auth('customer')->user();
        return view('customerretail::customer.profile_edit', compact('user'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        $user = auth('customer')->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();
        return redirect()->route('customer.profile')->with('success', 'Profile updated successfully.');
    }
} 