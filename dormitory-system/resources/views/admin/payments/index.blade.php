@extends('layouts.app')

@section('content')
<h3>Review Payments</h3>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-3">Back</a>
<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Tenant</th>
                <th>Room</th>
                <th>Months Paid</th>
                <th>Overdue</th>
                <th>Penalty</th>
                <th>Total</th>
                <th>Method</th>
                <th>Proof of payment</th>
                <th>Status</th>
                <th>Payment Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->tenant->first_name ?? '' }} {{ $payment->tenant->last_name ?? '' }}</td>
                <td>{{ $payment->room->label ?? '' }}</td>
                <td>{{ $payment->months_paid }}</td>
                <td>{{ $payment->overdue_months }}</td>
                <td>₱{{ number_format($payment->penalty_amount, 2) }}</td>
                <td>₱{{ number_format($payment->total_amount, 2) }}</td>
                <td>{{ $payment->payment_method }}</td>
                <td>
                    @if($payment->image)
                        <a href="{{ asset($payment->image) }}" target="_blank">View</a>
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    <span class="badge 
                        @if($payment->status == 'approved') bg-success 
                        @elseif($payment->status == 'rejected') bg-danger 
                        @else bg-warning text-dark @endif">
                        {{ ucfirst($payment->status) }}
                    </span>
                </td>
                <td>{{ $payment->payment_date }}</td>
                <td>
                    @if($payment->status == 'pending')
                    <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <button class="btn btn-success btn-sm mb-1" type="submit">Approve</button>
                    </form>
                    <form action="{{ route('admin.payments.updateStatus', $payment->id) }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="status" value="rejected">
                        <button class="btn btn-danger btn-sm" type="submit">Reject</button>
                    </form>
                    @else
                        <em>No action</em>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection