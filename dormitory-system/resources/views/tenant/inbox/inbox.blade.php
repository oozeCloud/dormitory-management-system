@extends('layouts.app')

@section('content')
<h3>Inbox</h3>
<a href="{{ route('tenant.dashboard') }}" class="btn btn-secondary mt-3">Back</a>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table">
    <thead>
        <tr>
            <th>From</th>
            <th>Message</th>
            <th>Received At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($messages as $message)
        <tr>
            <td>
                Admin
            </td>
            <td>{{ $message->content }}</td>
            <td>{{ $message->created_at->format('M d, Y h:i A') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection