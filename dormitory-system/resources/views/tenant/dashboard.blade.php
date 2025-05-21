@extends('layouts.app')

@section('content')
<h3>Tenant Dashboard</h3>
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="card mb-4">
    <div class="card-body">
        <h5>Welcome, {{ $tenant->first_name }} {{ $tenant->last_name }}</h5>
        <p>Email: {{ $tenant->email }}</p>
        <p>Phone: {{ $tenant->phone }}</p>
        <p>Status: {{ $lease->status }}</p>
        @if($lease->status == 'pending')
            <p class="text-warning mt-2">Your lease application is currently under review.</p>
        @elseif($lease->status == 'approved')
            <p class="text-success mt-2">Your lease application has been approved! You can now move into your assigned room at {{ $room->label }}.</p>
        @elseif($lease->status == 'rejected')
            <p class="text-danger mt-2">Unfortunately, your lease application has been rejected. Please contact the admin for further details.</p>
        @else
            <p class="text-muted mt-2">No lease application found. Please submit a new application.</p>
        @endif
        <div class="d-flex">
            <a href="{{ route('tenant.profile.edit') }}" class="btn btn-sm btn-secondary me-2">Edit Profile</a>
            <form method="POST" action="{{ route('logout') }}" class="me-2">
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Logout</button>
            </form>
            <form method="POST" action="{{ route('tenant.delete', $tenant->id) }}" onsubmit="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Delete Account</button>
            </form>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card bg-light p-4">
            <h5 class="mb-4">Actions</h5>
            <div class="row g-3">
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('tenant.message.admin') }}" class="btn btn-primary w-100">Message Admin</a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('tenant.inbox') }}" class="btn btn-primary w-100">View Inbox</a>
                </div>
                @if($lease->status == 'approved')
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('tenant.payment.form') }}" class="btn btn-primary w-100">Make Payment</a>
                </div>
                @endif
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('tenant.payment.history') }}" class="btn btn-primary w-100">View Payment History</a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('tenant.lease.edit') }}" class="btn btn-primary w-100">Edit Lease Agreement</a>
                </div>
            </div>
        </div>
    </div>
</div>
<br>


@endsection
