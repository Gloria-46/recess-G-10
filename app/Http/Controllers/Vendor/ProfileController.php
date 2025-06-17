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
}
