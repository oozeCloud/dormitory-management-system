@extends('layouts.app')

@section('content')
<h3>Admin Dashboard</h3>

<div class="row">
    <div class="col-md-3">
        <div class="card bg-light p-3">
            <h5>Total Rooms</h5>
            <p>{{ $roomCount }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light p-3">
            <h5>Total Registered</h5>
            <p>{{ $tenantCount }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light p-3">
            <h5>Active tenants</h5>
            <p>{{ $activeLeases }}</p>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-light p-3">
            <h5>Total Income</h5>
            <p>₱{{ number_format($totalIncome, 2) }}</p>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card bg-light p-4">
            <h5 class="mb-4">Actions</h5>
            <div class="row g-3">
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('admin.lease.applications') }}" class="btn btn-primary w-100">View Applications</a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('admin.message.tenants') }}" class="btn btn-primary w-100">Message Tenants</a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('admin.inbox') }}" class="btn btn-primary w-100">View Inbox</a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('admin.rooms.index') }}" class="btn btn-primary w-100">Manage Rooms</a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('admin.tenants.index') }}" class="btn btn-primary w-100">Manage Tenants</a>
                </div>
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('admin.account.edit') }}" class="btn btn-primary w-100">Edit Account</a>
                </div>
            </div>
        </div>
    </div>
</div>
<br><br>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-sm btn-danger">Logout</button>
</form>
@endsection
