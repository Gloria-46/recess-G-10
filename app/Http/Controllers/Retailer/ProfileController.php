<?php

namespace App\Http\Controllers\Retailer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Retailer;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $retailer = Retailer::find(request()->user()->id);
        return view('retailer.profile.show', compact('retailer'));
    }

    public function edit()
    {
        $retailer = Retailer::find(request()->user()->id);
        return view('retailer.profile.edit', compact('retailer'));
    }

    public function update(Request $request)
    {
        $retailer = Retailer::find(request()->user()->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:retailers,email,' . $retailer->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $retailer->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('retailer.profile.show')->with('success', 'Profile updated successfully.');
    }
} 