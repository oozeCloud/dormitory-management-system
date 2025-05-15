@extends('layouts.app')

@section('content')
<h2>Tenant Registration</h2>

<form method="post" action="{{ route('tenant.register') }}">
    @csrf
    <div class="row">
        <div class="col-md-6 mb-3">
            <label>First Name</label>
            <input type="text" name="first_name" required class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label>Last Name</label>
            <input type="text" name="last_name" required class="form-control">
        </div>
    </div>
    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" required class="form-control">
    </div>
    <div class="mb-3">
        <label>Phone</label>
        <input type="text" name="phone" required class="form-control">
    </div>
    <div class="mb-3">
        <label>Username</label>
        <input type="text" name="username" required class="form-control">
    </div>
    <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" required class="form-control">
    </div>
    <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" required class="form-control">
    </div>
    <button class="btn btn-success">Register</button>
</form>
@endsection
