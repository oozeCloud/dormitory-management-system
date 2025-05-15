@extends('layouts.app')

@section('content')
<h3>Edit Room</h3>
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form method="POST" action="{{ route('admin.rooms.update', $room->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="room_label" class="form-label">Room Label</label>
        <input type="text" name="room_label" id="room_label" class="form-control" value="{{ $room->label }}" required>
    </div>
    <div class="mb-3">
        <label for="floor" class="form-label">Floor</label>
        <input type="number" name="floor" id="floor" class="form-control" value="{{ $room->floor }}" required>
    </div>
    <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" name="image" id="image" class="form-control">
        @if($room->image)
            <img src="{{ asset($room->image) }}" alt="Room Image" class="img-thumbnail mt-2" width="150">
        @endif
    </div>
    <div class="mb-3">
        <label for="monthly_rent" class="form-label">Monthly Rent</label>
        <input type="number" name="monthly_rent" id="monthly_rent" class="form-control" value="{{ $room->monthly_rent }}" required>
    </div>
    <div class="mb-3">
        <label for="capacity" class="form-label">Capacity</label>
        <input type="number" name="capacity" id="capacity" class="form-control" value="{{ $room->capacity }}" required>
    </div>
    <button type="submit" class="btn btn-primary">Update Room</button>
</form>
<a href="{{ route('admin.rooms.index') }}" class="btn btn-secondary mb-3">Back</a>
@endsection