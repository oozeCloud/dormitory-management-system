<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\Lease;
use App\Models\Tenant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LeaseApprovalController extends Controller
{
    public function index()
    {
        $applications = Lease::with('tenant', 'room')->get();
        return view('admin.applications.index', compact('applications'));
    }

    public function approve(Request $request, $id)
    {
        $lease = Lease::findOrFail($id);
        if ($lease->status !== 'pending') {
            return back()->with('error', 'This lease application is already processed.');
        }

        $room = Room::findOrFail($lease->room_id);

        if ($room->occupancy >= $room->capacity) {
            return back()->with('error', 'Room is already full.');
        }

        $lease->status = 'approved';
        $lease->save();

        $room->occupancy = $room->occupancy + $lease->occupied_bedspace;
        $room->save();

        $tenant = Tenant::findOrFail($lease->tenant_id);
        $tenant->room_id = $lease->room_id;
        $tenant->save();

        return back()->with('success', 'Lease application approved.');
    }

    public function reject(Request $request, $id)
    {
        $lease = Lease::findOrFail($id);
        if ($lease->status !== 'pending') {
            return back()->with('error', 'This lease application is already processed.');
        }

        $lease->status = 'rejected';
        $lease->save();

        return back()->with('success', 'Lease application rejected.');
    }
}
