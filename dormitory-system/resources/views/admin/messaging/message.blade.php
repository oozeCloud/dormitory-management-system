@extends('layouts.app')

@section('content')
<h3>Message Tenants</h3>
@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<form method="POST" action="{{ route('admin.message.send') }}">
    @csrf
    <div class="mb-3">
        <label for="tenant" class="form-label">Select Tenant</label>
        <select name="receiver_id" id="tenant" class="form-control" required>
            @foreach($tenants as $tenant)
            <option value="{{ $tenant->id }}">{{ $tenant->first_name }} {{ $tenant->last_name }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Your Message</label>
        <textarea name="content" id="message" class="form-control" rows="5" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Send Message</button>
</form>
<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
@endsection