<?php

namespace App\Http\Controllers\Admin;

use App\Models\Room;
use App\Models\Tenant;
use App\Models\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TenantController extends Controller
{
    public function index()
    {
        $tenants = Tenant::all();
        return view('admin.tenants.index', compact('tenants'));
    }

    public function edit(Tenant $tenant)
    {
        return view('admin.tenants.edit', compact('tenant'));
    }

    public function update(Request $request, Tenant $tenant)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:tenants,email,' . $tenant->id,
            'phone' => 'nullable|string|max:15',
            'username' => 'required|string|max:255|unique:tenants,username,' . $tenant->id,
            'password' => 'nullable|string|min:8',
        ]);

        $tenant->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => $request->filled('password') ? bcrypt($request->password) : $tenant->password,
        ]);

        return redirect()->route('admin.tenants.index')->with('success', 'Tenant updated successfully.');
    }

    public function destroy(Tenant $tenant)
    {
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
        return redirect()->route('admin.tenants.index')->with('success', 'Tenant deleted successfully.');
    }
}