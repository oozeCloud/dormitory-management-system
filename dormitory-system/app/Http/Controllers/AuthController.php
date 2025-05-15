<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Tenant;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (Auth::guard('tenant')->attempt($request->only('username', 'password'))) {
            return redirect()->route('tenant.dashboard');
        }
        else if (Auth::guard('admin')->attempt($request->only('username', 'password'))) {
            return redirect()->route('admin.dashboard');
        }
        else {
            return back()->with('error', 'Invalid credentials');    
        } 
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email',
            'phone'      => 'required',
            'username'   => 'required',
            'password'   => 'required|confirmed|min:6',
        ]);

        $tenant = Tenant::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
        ]);

        Auth::guard('tenant')->login($tenant);

        return redirect()->route('tenant.lease.show')->with('success', 'Registration successful.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        Auth::guard('tenant')->logout();
        return redirect()->route('tenant.login.show');
    }
}
