<?php

namespace Modules\Admin\Http\Controllers;

use App\Models\AllowedEmail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
            'role' => 'required',
        ]);
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
            'role' => 'required',
        ]);
        $allowedEmail->update($request->only('email', 'role'));
        return redirect()->route('admin.allowed_emails.index')->with('success', 'Allowed email updated.');
    }

    public function destroy(AllowedEmail $allowedEmail)
    {
        $allowedEmail->delete();
        return redirect()->route('admin.allowed_emails.index')->with('success', 'Allowed email deleted.');
    }
} 