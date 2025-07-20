<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\AllowedEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AllowedEmailController extends Controller
{
    public function index()
    {
        $allowedEmails = AllowedEmail::all();
        return view('admin::allowed_emails.index', compact('allowedEmails'));
    }

    public function create()
    {
        return view('admin::allowed_emails.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:allowed_emails,email',
            'role' => 'required|in:admin,vendor,warehouse,retailer,customer',
        ]);

        $email = $request->email;
        $role = $request->role;

        // Enforce domain rules
        if (
            ($role === 'admin' && !str_ends_with($email, '@admin.uptrend.com')) ||
            ($role === 'vendor' && !str_ends_with($email, '@vendor.uptrend.com')) ||
            ($role === 'warehouse' && !str_ends_with($email, '@warehouse.uptrend.com')) ||
            ($role === 'retailer' && !str_ends_with($email, '@retailer.uptrend.com'))
        ) {
            return back()->withErrors(['email' => 'Email domain does not match the selected role.'])->withInput();
        }

        AllowedEmail::create($request->only('email', 'role'));
        return redirect()->route('admin.allowed_emails.index')->with('success', 'Allowed email added.');
    }

    public function edit(AllowedEmail $allowedEmail)
    {
        return view('admin::allowed_emails.edit', compact('allowedEmail'));
    }

    public function update(Request $request, AllowedEmail $allowedEmail)
    {
        $request->validate([
            'email' => 'required|email|unique:allowed_emails,email,' . $allowedEmail->id,
            'role' => 'required|in:admin,vendor,warehouse,retailer,customer',
        ]);

        $email = $request->email;
        $role = $request->role;

        // Enforce domain rules
        if (
            ($role === 'admin' && !str_ends_with($email, '@admin.uptrend.com')) ||
            ($role === 'vendor' && !str_ends_with($email, '@vendor.uptrend.com')) ||
            ($role === 'warehouse' && !str_ends_with($email, '@warehouse.uptrend.com')) ||
            ($role === 'retailer' && !str_ends_with($email, '@retailer.uptrend.com'))
        ) {
            return back()->withErrors(['email' => 'Email domain does not match the selected role.'])->withInput();
        }

        $allowedEmail->update($request->only('email', 'role'));
        return redirect()->route('admin.allowed_emails.index')->with('success', 'Allowed email updated.');
    }

    public function destroy(AllowedEmail $allowedEmail)
    {
        $allowedEmail->delete();
        return redirect()->route('admin.allowed_emails.index')->with('success', 'Allowed email deleted.');
    }
} 