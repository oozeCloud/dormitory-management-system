@extends('layouts.app')

@section('content')
<h2>Login</h2>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="post" action="{{ route('tenant.login') }}">
    @csrf
    <div class="mb-3">
        <label for="username">Username</label>
        <input type="text" name="username" required class="form-control">
    </div>
    <div class="mb-3">
        <label for="password">Password</label>
        <input type="password" name="password" required class="form-control">
    </div>
    <button class="btn btn-primary" type="submit">Login</button>
</form>

<p class="mt-3">New tenant? <a href="{{ route('tenant.register.show') }}">Register here</a></p>
@endsection
