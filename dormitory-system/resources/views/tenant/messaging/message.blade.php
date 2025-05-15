@extends('layouts.app')

@section('content')
<h3>Message Admin</h3>
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<form method="POST" action="{{ route('tenant.message.send') }}">
    @csrf
    <div class="mb-3">
        <label for="message" class="form-label">Your Message</label>
        <textarea name="content" id="message" class="form-control" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send Message</button>
</form>
<a href="{{ route('tenant.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
@endsection