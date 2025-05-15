<?php

namespace App\Http\Controllers\Tenant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $tenant = Auth::guard('tenant')->user();
        return view('tenant.profile.edit', compact('tenant'));
    }

    public function update(Request $request)
    {
        $tenant = Auth::guard('tenant')->user();

        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'username' => 'required',
            'password' => 'nullable|min:6',
        ]);

        $tenant = Auth::guard('tenant')->user();

        $tenant->first_name = $request->firstname;
        $tenant->last_name = $request->lastname;
        $tenant->email = $request->email;
        $tenant->phone = $request->phone;
        $tenant->username = $request->username;

        if ($request->filled('password')) {
            $tenant->password = bcrypt($request->password);
        }

        $tenant->save();

        return redirect()->route('tenant.dashboard')->with('success', 'Profile updated.');
    }
}
