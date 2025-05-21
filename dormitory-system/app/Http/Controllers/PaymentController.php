<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['tenant', 'room'])->orderBy('created_at', 'desc')->get();
        return view('admin.payments.index', compact('payments'));
    }

    public function showPaymentForm()
    {
        $tenant = Auth::guard('tenant')->user();
        $lease = $tenant->lease;

        $room = $lease->room;

        if ($lease->status == 'pending') {
            $monthlyRent = $room->monthly_rent / (max(1, $room->occupancy) + $lease->occupied_bedspace);
        }else {
            $monthlyRent = $room->monthly_rent / max(1, $room->occupancy);
        }

        $toPay = $monthlyRent * $lease->occupied_bedspace;
        $monthsLeft = $lease->lease_term - $lease->months_paid;

        $dueDate = now()->addDays(30);
        $overdueMonths = now()->greaterThan($dueDate)
            ? now()->diffInMonths($dueDate)
            : 0;
        $penalty = $overdueMonths * ($monthlyRent * 0.03);

        return view('tenant.payment.make_payment', compact('tenant', 'lease', 'room', 'monthlyRent', 'overdueMonths', 'penalty', 'monthsLeft', 'toPay'));
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'months_to_pay' => 'required|integer|min:1',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $monthsToPay = (int) $request->months_to_pay;

        $tenant = Auth::guard('tenant')->user();
        $lease = $tenant->lease;
        $room = $lease->room;

        if ($lease->status == 'pending') {
            $monthlyRent = $room->monthly_rent / (max(1, $room->occupancy) + $lease->occupied_bedspace);
        }else {
            $monthlyRent = $room->monthly_rent / max(1, $room->occupancy);
        }

        $totalAmount = $monthlyRent * $monthsToPay;

        $imagePath = null;
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $imagePath = 'images/' . $originalName;
            $request->file('image')->move(public_path('images'), $originalName);
        }

        $totalAmount *= $lease->occupied_bedspace;

        Payment::create([
            'tenant_id' => $tenant->id,
            'room_id' => $room->id,
            'months_paid' => $monthsToPay,
            'penalty_amount' => 0,
            'total_amount' => $totalAmount,
            'image' => $imagePath,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'payment_date' => now(),
        ]);

        $lease->months_paid += $monthsToPay;
        $lease->save();

        return redirect()->route('tenant.dashboard')->with('success', 'Payment successful.');
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

    public function updateStatus(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);
        $payment->status = $request->status;
        $payment->save();

        return redirect()->route('admin.payments.index')->with('success', 'Payment status updated.');
    }
}