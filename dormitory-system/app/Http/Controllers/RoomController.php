<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_label' => 'required|string|max:255',
            'floor' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'monthly_rent' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $imagePath = 'images/' . $originalName;
            $request->file('image')->move(public_path('images'), $originalName);
        }

        Room::create([
            'label' => $request->room_label,
            'floor' => $request->floor,
            'image' => $imagePath,
            'monthly_rent' => $request->monthly_rent,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully.');
    }

    public function edit(Room $room)
    {
        return view('admin.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room)
    {
        $request->validate([
            'room_label' => 'required|string|max:255',
            'floor' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'monthly_rent' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('image')) {
            if ($room->image && file_exists(public_path('images/' . $room->image))) {
                unlink(public_path('images/' . $room->image));
            }

            $originalName = $request->file('image')->getClientOriginalName();
            $imagePath = 'images/' . $originalName;
            $request->file('image')->move(public_path('images'), $originalName);

            $room->image = $imagePath;
        }

        $room->update([
            'label' => $request->room_label,
            'floor' => $request->floor,
            'monthly_rent' => $request->monthly_rent,
            'capacity' => $request->capacity,
        ]);

        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        if ($room->image) {
            \Storage::disk('public')->delete($room->image);
        }

        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}