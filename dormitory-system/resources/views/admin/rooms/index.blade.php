@extends('layouts.app')

@section('content')
<h3>Rooms</h3>

<a href="{{ route('admin.rooms.create') }}" class="btn btn-primary mb-3">Add Room</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Back</a>

<table class="table">
    <thead>
        <tr>
            <th>Room Label</th>
            <th>image</th>
            <th>Floor</th>
            <th>Monthly Rent</th>
            <th>Occupancy level</th>
            <th>Capacity</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($rooms as $room)
        <tr>
            <td>{{ $room->label }}</td>
            <td><img src="{{ asset($room->image) }}" class="card-img-top" alt="Room Image" style="height: 100px; object-fit: cover;"></td>
            <td>{{ $room->floor }}</td>
            <td>₱{{ number_format($room->monthly_rent, 2) }}</td>
            <td>{{ $room->occupancy }}</td>
            <td>{{ $room->capacity }}</td>
            <td>
                <a href="{{ route('admin.rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection