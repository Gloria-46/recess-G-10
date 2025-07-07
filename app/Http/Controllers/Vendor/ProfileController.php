<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $vendor = auth('vendor')->user();
        return view('vendor.profile.edit', compact('vendor'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $vendor = auth('vendor')->user();

        if (!\Hash::check($request->current_password, $vendor->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $vendor->password = \Hash::make($request->new_password);
        $vendor->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function update(Request $request)
    {
        $vendor = auth('vendor')->user();
        $request->validate([
            'business_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:vendors,email,' . $vendor->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);
        $vendor->business_name = $request->business_name;
        $vendor->email = $request->email;
        $vendor->phone = $request->phone;
        $vendor->address = $request->address;
        $vendor->save();
        return back()->with('success', 'Profile updated successfully.');
    }
}
