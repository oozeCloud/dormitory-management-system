<?php

namespace App\Http\Controllers\Tenant;

use App\Models\Room;
use App\Models\Lease;
use App\Models\Tenant;
use App\Models\Message;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        if ($tenant->id) {
            Message::where('sender_id', $tenant->id)->delete();
        }

        $tenant->delete();

        Auth::guard('tenant')->logout();

        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}
