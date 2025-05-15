@extends('layouts.app')

@section('content')
<h3>Add Room</h3>

<form method="POST" action="{{ route('admin.rooms.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="room_label" class="form-label">Room Label</label>
        <input type="text" name="room_label" id="room_label" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="floor" class="form-label">Floor</label>
        <input type="number" name="floor" id="floor" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="image" class="form-control">
    </div>
    <div class="mb-3">
        <label for="monthly_rent" class="form-label">Monthly Rent</label>
        <input type="number" name="monthly_rent" id="monthly_rent" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="capacity" class="form-label">Capacity</label>
        <input type="number" name="capacity" id="capacity" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Room</button>
</form>
<a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary mb-3">Back</a>
@endsection