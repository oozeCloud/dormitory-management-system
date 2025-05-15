@extends('layouts.app')

@section('content')
<h3>Make Payment</h3>

<p>Monthly Rent: ₱{{ number_format($monthlyRent, 2) }}</p>
<p>Overdue Months: {{ $overdueMonths }}</p>
<p>Penalty Amount: ₱{{ number_format($penalty, 2) }}</p>

<form method="POST" action="{{ route('tenant.payment.process') }}">
    @csrf
    <div class="mb-3">
        <label for="months_to_pay" class="form-label">Months to Pay</label>
        <input type="number" name="months_to_pay" id="months_to_pay" class="form-control" min="1" required>
    </div>
    <button type="submit" class="btn btn-primary">Pay Now</button>
</form>
<a href="{{ route('tenant.dashboard') }}" class="btn btn-secondary mt-3">Back</a>
@endsection