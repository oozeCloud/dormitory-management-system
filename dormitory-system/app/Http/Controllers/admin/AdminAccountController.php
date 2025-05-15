<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAccountController extends Controller
{
    public function edit()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.account.edit', compact('admin'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:admins,username,' . Auth::id(),
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin = Auth::guard('admin')->user();

        $admin->username = $request->username;

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }

        $admin->save();

        return redirect()->route('admin.dashboard')->with('success', 'Account updated successfully.');
    }
}