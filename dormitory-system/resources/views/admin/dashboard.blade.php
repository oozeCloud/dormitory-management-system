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
        <div class="card bg-light p-3">
            <h5>Actions</h5>
            <a href="{{ route('admin.lease.applications') }}" class="btn btn-primary">View Applications</a><br>
            <a href="{{ route('admin.message.tenants') }}" class="btn btn-primary">Message Tenants</a><br>
            <a href="{{ route('admin.inbox') }}" class="btn btn-sm btn-primary">View Inbox</a><br>
            <a href="{{ route('admin.rooms.index') }}" class="btn btn-sm btn-primary">Manage Rooms</a><br>
            <a href="{{ route('admin.tenants.index') }}" class="btn btn-sm btn-primary">Manage Tenants</a><br>
            <a href="{{ route('admin.account.edit') }}" class="btn btn-sm btn-primary">Edit Account</a><br>
        </div>
    </div>
</div>
<br><br>
<form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn btn-sm btn-danger">Logout</button>
</form>
@endsection
