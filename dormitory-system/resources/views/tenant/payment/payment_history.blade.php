@extends('layouts.app')

@section('content')
<h3>Payment History</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
<a href="{{ route('tenant.dashboard') }}" class="btn btn-secondary mt-3">Back</a>

<table class="table">
    <thead>
        <tr>
            <th>Payment Date</th>
            <th>Months Paid</th>
            <th>Penalty Amount</th>
            <th>Total Amount</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
            @if($payment->status == 'approved')
                <tr onclick="window.location='{{ route('tenant.payment.invoice', $payment->id) }}'" style="cursor: pointer;">
                    <td>{{ $payment->payment_date->format('M d, Y') }}</td>
                    <td>{{ $payment->months_paid }}</td>
                    <td>₱{{ number_format($payment->penalty_amount, 2) }}</td>
                    <td>₱{{ number_format($payment->total_amount, 2) }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
@endsection