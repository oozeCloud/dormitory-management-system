@extends('layouts.app')

@section('content')
<h3>Edit Profile</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<form method="post" action="{{ route('tenant.profile.update') }}">
    @csrf
    <div class="mb-3">
        <label>First Name</label>
        <input type="text" name="firstname" value="{{ $tenant->first_name }}" class="form-control">
    </div>
    <div class="mb-3">
        <label>Last Name</label>
        <input type="text" name="lastname" value="{{ $tenant->last_name }}" class="form-control">
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="text" name="email" value="{{ $tenant->email }}" class="form-control">
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" value="{{ $tenant->phone }}" class="form-control">
    </div>
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" value="{{ $tenant->username }}" class="form-control">
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="text" name="password" class="form-control">
    </div>
    <button class="btn btn-primary">Update</button>
</form>
<a href="{{ route('tenant.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
@endsection
