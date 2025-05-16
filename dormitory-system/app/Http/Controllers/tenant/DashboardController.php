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

    public function destroy($id)
    {
        $tenant = Auth::guard('tenant')->user();

        if ($tenant->id != $id) {
            return redirect()->route('tenant.dashboard')->with('error', 'Unauthorized action.');
        }

        if ($tenant->room_id) {
            $room = Room::find($tenant->room_id);
            if ($room) {
                $room->decrement('occupancy');
            }
        }

        $tenant->delete();

        Auth::guard('tenant')->logout();

        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}
