<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\Payment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $roomCount = Room::count();
        $tenantCount = Tenant::count();
        $totalIncome = Payment::where('status', 'approved')->sum('total_amount');
        $activeLeases = Lease::where('status', 'approved')->count();

        return view('admin.dashboard', compact('roomCount', 'tenantCount', 'totalIncome', 'activeLeases'));
    }
}
