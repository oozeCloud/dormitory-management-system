<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        $tenant = Auth::guard('tenant')->user();
        $lease = $tenant->lease;

        $room = $lease->room;

        $monthlyRent = $room->monthly_rent / max(1, $room->occupancy);
        $dueDate = now()->addDays(30);
        $overdueMonths = now()->greaterThan($dueDate)
            ? now()->diffInMonths($dueDate)
            : 0;
        $penalty = $overdueMonths * ($monthlyRent * 0.03);

        return view('tenant.payment.make_payment', compact('tenant', 'lease', 'room', 'monthlyRent', 'overdueMonths', 'penalty'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'months_to_pay' => 'required|integer|min:1',
        ]);

        $monthsToPay = (int) $request->months_to_pay;

        $tenant = Auth::guard('tenant')->user();
        $lease = $tenant->lease;
        $room = $lease->room;

        $monthlyRent = $room->monthly_rent / max(1, $room->occupancy);

        $totalAmount = $monthlyRent * $monthsToPay;

        Payment::create([
            'tenant_id' => $tenant->id,
            'room_id' => $room->id,
            'months_paid' => $monthsToPay,
            'penalty_amount' => 0,
            'total_amount' => $totalAmount,
            'payment_date' => now(),
        ]);

        return redirect()->route('tenant.payment.history')->with('success', 'Payment successful. Invoice generated.');
    }

    public function paymentHistory()
    {
        $tenant = Auth::guard('tenant')->user();
        $payments = Payment::where('tenant_id', $tenant->id)->latest()->get();

        return view('tenant.payment.payment_history', compact('payments'));
    }

    public function showInvoice($id)
    {
        $payment = Payment::with('tenant', 'room')->findOrFail($id);

        return view('tenant.payment.invoice', compact('payment'));
    }
}