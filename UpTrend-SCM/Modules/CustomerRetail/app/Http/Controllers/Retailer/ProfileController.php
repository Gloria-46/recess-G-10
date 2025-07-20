<?php

namespace Modules\CustomerRetail\App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CustomerRetail\App\Models\Retailer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::guard('retailer')->user();
        if (!$user) {
            return redirect()->route('retailer.login')->with('error', 'Please log in first.');
        }
        $retailer = Retailer::find($user->id);
        return view('customerretail::retailer.profile.show', compact('retailer'));
    }

    public function edit()
    {
        $user = Auth::guard('retailer')->user();
        if (!$user) {
            return redirect()->route('retailer.login')->with('error', 'Please log in first.');
        }
        $retailer = Retailer::find($user->id);
        return view('customerretail::retailer.profile.edit', compact('retailer'));
    }

    public function update(Request $request)
    {
        $user = Auth::guard('retailer')->user();
        if (!$user) {
            return redirect()->route('retailer.login')->with('error', 'Please log in first.');
        }
        $retailer = Retailer::find($user->id);

        $request->validate([
            'business_name' => 'required|string|max:255',
            'email' => 'required|email|unique:retailers,email,' . $retailer->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $updateData = [
            'business_name' => $request->business_name,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        $retailer->update($updateData);

        return redirect()->route('retailer.profile.show')->with('success', 'Profile updated successfully.');
    }
} 