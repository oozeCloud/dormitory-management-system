@extends('layouts.app')

@section('content')
<h3>Invoice Receipt</h3>

<div class="card">
    <div class="card-body">
        <p><strong>Tenant Name:</strong> {{ $payment->tenant->first_name }} {{ $payment->tenant->last_name }}</p>
        <p><strong>Room:</strong> {{ $payment->room->label }}</p>
        <p><strong>Months Paid:</strong> {{ $payment->months_paid }}</p>
        <p><strong>Penalty Amount:</strong> ₱{{ number_format($payment->penalty_amount, 2) }}</p>
        <p><strong>Total Amount:</strong> ₱{{ number_format($payment->total_amount, 2) }}</p>
        <p><strong>Payment Date:</strong> {{ $payment->payment_date->format('M d, Y') }}</p>
    </div>
</div>

<a href="{{ route('tenant.payment.history') }}" class="btn btn-secondary mt-3">Back to Payment History</a>
@endsection