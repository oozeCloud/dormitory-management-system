@extends('layouts.app')

@section('content')
<h3 class="mb-4">Lease Application</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('tenant.lease.submit') }}">
    @csrf
    <div class="mb-4">
        <label for="lease_term" class="form-label">Lease Term (months)</label>
        <input type="number" name="lease_term" min="1" class="form-control" required>
    </div>

    <div class="mb-4">
        <label for="occupied_bedspace" class="form-label">Bedspace to occupy</label>
        <input type="number" name="occupied_bedspace" min="1" class="form-control" required>
    </div>

    <div class="mb-4">
        <label for="room_type" class="form-label">Type of room (boarding requires downpayment)</label>
        <select name="room_type" id="" class="form-control" required>
            <option value="boarding" selected>boarding</option>
            <option value="transient">transient</option>
        </select>
    </div>

    <div class="mb-4">
        <label for="room" class="form-label">Select Room:</label>
        <div class="row">
            @foreach($rooms as $room)
            @if($room->occupancy != $room->capacity)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <img src="{{ asset($room->image) }}" class="card-img-top" alt="Room Image" style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">Room: {{ $room->label }}</h5>
                        <p class="card-text">
                            Floor: {{ $room->floor }} <br>
                            Rent: ₱{{ number_format($room->monthly_rent / max(1, $room->occupancy ?: 1), 2) }} <br>
                            Occupancy: {{ $room->occupancy }} / {{ $room->capacity }}
                        </p>
                        <div class="form-check">
                            <input type="radio" name="room_id" value="{{ $room->id }}" id="room-{{ $room->id }}" class="form-check-input" required>
                            <label for="room-{{ $room->id }}" class="form-check-label">Select this room</label>
                        </div>
                    </div>
                </div>
            </div>
            @else
            No available rooms!
            @endif
            @endforeach
        </div>
    </div>

    <button class="btn btn-primary">Submit Application</button>
</form>
<a href="{{ route('tenant.register.show') }}" class="btn btn-secondary mt-3">Back</a>
@endsection