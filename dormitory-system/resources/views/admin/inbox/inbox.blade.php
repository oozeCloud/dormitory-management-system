@extends('layouts.app')

@section('content')
<h3>Inbox</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
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
                {{ $message->sender->first_name }} {{ $message->sender->last_name }}
            </td>
            <td>{{ $message->content }}</td>
            <td>{{ $message->created_at->format('M d, Y h:i A') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection