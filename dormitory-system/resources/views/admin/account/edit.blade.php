@extends('layouts.app')

@section('content')
<h3>Edit Account</h3>

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

<form method="POST" action="{{ route('admin.account.update') }}">
    @csrf
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $admin->username) }}" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">New Password (Leave blank to keep current password)</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm New Password</label>
        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Update Account</button>
</form>
<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
@endsection