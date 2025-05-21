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
            'occupied_bedspace' => 'required|integer|min:1',
            'room_type' => 'required',
        ]);

        $tenant = Auth::guard('tenant')->user();

        Lease::create([
            'tenant_id' => $tenant->id,
            'room_id' => $request->room_id,
            'lease_term' => $request->lease_term,
            'occupied_bedspace' => $request->occupied_bedspace,
            'room_type' => $request->room_type,
            'months_paid' => 0,
            'status' => 'pending',
        ]);

        if ($request->room_type == 'transient') {
            return redirect()->route('tenant.dashboard')->with('success', 'Lease application submitted.');
        }else {
            return redirect()->route('tenant.payment.form')->with('success', 'Lease application submitted.');
        }
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
            'occupied_bedspace' => 'required|integer|min:1',
            'room_type' => 'required'
        ]);

        $tenant = Auth::guard('tenant')->user();
        $lease = $tenant->lease;

        if (!$lease) {
            return redirect()->route('tenant.dashboard')->with('error', 'No lease agreement found.');
        }

        if($lease->room_id != $request->room_id){
            if ($tenant->room_id) {
                $room = Room::find($tenant->room_id);
                if ($room) {
                    $room->decrement('occupancy');
                }
            }

            $lease->update([
                'tenant_id' => $tenant->id,
                'room_id' => $request->room_id,
                'lease_term' => $request->lease_term,
                'occupied_bedspace' => $request->occupied_bedspace,
                'room_type' => $request->room_type,
                'months_paid' => 0,
                'status' => 'pending',
            ]);

            return redirect()->route('tenant.dashboard')->with('success', 'Lease agreement updated and submitted for admin approval.');
        }else {
            $lease->update([
                'tenant_id' => $tenant->id,
                'room_id' => $request->room_id,
                'lease_term' => $request->lease_term,
                'occupied_bedspace' => $request->occupied_bedspace,
                'room_type' => $request->room_type,
                'months_paid' => 0,
                'status' => 'pending',
            ]);

            return redirect()->route('tenant.dashboard')->with('success', 'Lease agreement updated and submitted for admin approval.');
        }

    }
}
