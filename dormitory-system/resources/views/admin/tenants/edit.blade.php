@extends('layouts.app')

@section('content')
<h3>Edit Tenant</h3>

<form method="POST" action="{{ route('admin.tenants.update', $tenant->id) }}">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="first_name" class="form-label">First Name</label>
        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $tenant->first_name }}" required>
    </div>
    <div class="mb-3">
        <label for="last_name" class="form-label">Last Name</label>
        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $tenant->last_name }}" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="{{ $tenant->email }}" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" name="phone" id="phone" class="form-control" value="{{ $tenant->phone }}">
    </div>
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" value="{{ $tenant->username }}" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">New Password (Leave blank to keep current password)</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update Tenant</button>
</form>
<a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary mb-3">Back</a>
@endsection