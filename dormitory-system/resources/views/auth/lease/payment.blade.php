@extends('layouts.app')

@section('content')
<h3>Make Payment</h3>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<p>Monthly Rent: ₱{{ number_format($monthlyRent, 2) }}</p>
<p>Occupied bedspace: {{ $lease->occupied_bedspace }}</p>
<p>Overdue Months: {{ $overdueMonths }}</p>
<p>Penalty Amount: ₱{{ number_format($penalty, 2) }}</p>
<p>Months left unpaid: {{ $monthsLeft }}</p>

<form method="POST" action="{{ route('tenant.payment.process') }}" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="months_to_pay" class="form-label">Months to Pay</label>
        <input type="number" name="months_to_pay" id="months_to_pay" class="form-control" min="1" required>
    </div>
    <select name="payment_method" id="" class="form-control">
        <option value="gcash" selected>gcash</option>
        <option value="paymaya">paymaya</option>
        <option value="cash">cash</option>
    </select><br>
    <div class="mb-3">
        <label for="image" class="form-label">Proof of payment</label>
        <input type="file" name="image" id="image" class="form-control" required>
    </div><br>
    <button type="submit" class="btn btn-primary">Submit request</button>
</form>
<!-- <a href="{{ route('tenant.dashboard') }}" class="btn btn-secondary mt-3">go to dashboard</a> -->
@endsection