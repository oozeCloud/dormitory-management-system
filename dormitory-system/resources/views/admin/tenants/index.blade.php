@extends('layouts.app')

@section('content')
<h3>Manage Tenants</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Back</a>

<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($tenants as $tenant)
        <tr>
            <td>{{ $tenant->first_name }} {{ $tenant->last_name }}</td>
            <td>{{ $tenant->email }}</td>
            <td>{{ $tenant->phone }}</td>
            <td>{{ $tenant->username }}</td>
            <td>
                <a href="{{ route('admin.tenants.edit', $tenant) }}" class="btn btn-sm btn-warning">Edit</a>
                <form action="{{ route('admin.tenants.delete', $tenant) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection