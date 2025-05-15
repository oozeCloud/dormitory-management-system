<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Lease;
use Illuminate\Support\Facades\Auth;

class LeaseController extends Controller
{
    public function showForm()
    {
        $rooms = Room::all();
        return view('auth.lease.apply', compact('rooms'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'room_id' => 'required|',
            'lease_term' => 'required|integer|min:1',
        ]);
        $tenant = Auth::guard('tenant')->user();
        Lease::create([
            'tenant_id' => $tenant->id,
            'room_id' => $request->room_id,
            'lease_term' => $request->lease_term,
            'status' => 'pending',
        ]);

        return redirect()->route('tenant.dashboard')->with('success', 'Lease application submitted.');
    }

    public function update(Request $request)
    {
        $tenant = Auth::guard('tenant')->user();

        $request->validate([
            'status' => 'required'
        ]);

        $tenant->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Lease approved');
    }

    public function edit()
    {
        $tenant = Auth::guard('tenant')->user();
        $lease = $tenant->lease;
        $rooms = Room::all();

        if (!$lease) {
            return redirect()->route('tenant.dashboard')->with('error', 'No lease agreement found.');
        }

        return view('tenant.lease.edit', compact('lease', 'rooms'));
    }

    public function updateLease(Request $request)
    {
        $request->validate([
            'room_id' => 'required|',
            'lease_term' => 'required|integer|min:1',
        ]);

        $tenant = Auth::guard('tenant')->user();
        $lease = $tenant->lease;

        if (!$lease) {
            return redirect()->route('tenant.dashboard')->with('error', 'No lease agreement found.');
        }

        $lease->update([
            'tenant_id' => $tenant->id,
            'room_id' => $request->room_id,
            'lease_term' => $request->lease_term,
            'status' => 'pending',
        ]);

        return redirect()->route('tenant.dashboard')->with('success', 'Lease agreement updated and submitted for admin approval.');
    }
}
