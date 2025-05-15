<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Room;
use App\Models\Lease;
use App\Models\Tenant;

class DashboardController extends Controller
{
    public function index()
    {
        $tenant = Auth::guard('tenant')->user();
        $lease = $tenant->lease()->with('room')->first();
        $room = Room::findOrFail($lease->room_id);
        return view('tenant.dashboard', compact('tenant', 'lease', 'room'));
    }

    public function destroy(Tenant $tenant)
    {
        $room = Room::findOrFail($tenant->room_id);
        $room->decrement('occupancy');
        $tenant->delete();
        return view('auth.login')->with('success', 'Tenant deleted successfully.');
    }
}
