@extends('layouts.app')

@section('content')
<h3>Lease Applications</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Back</a>
<table class="table">
    <thead>
        <tr>
            <th>Tenant</th>
            <th>Room</th>
            <th>Lease Term</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($applications as $application)
        <tr>
            <td>{{ $application->tenant->first_name }} {{ $application->tenant->last_name }}</td>
            <td>{{ $application->room->label }}</td>
            <td>{{ $application->lease_term }} months</td>
            <td>{{ ucfirst($application->status) }}</td>
            <td>
                <form method="post" action="{{ route('admin.lease.approve', $application->id) }}" style="display: inline;">
                    @csrf
                    <button class="btn btn-success btn-sm">Approve</button>
                </form>
                <form method="post" action="{{ route('admin.lease.reject', $application->id) }}" style="display: inline;">
                    @csrf
                    <button class="btn btn-danger btn-sm">Reject</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection