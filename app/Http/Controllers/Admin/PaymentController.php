<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'package'])->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $payments = $query->paginate(50)->withQueryString();
        
        $totalRevenue = Payment::where('status', 'success')->sum('amount');
        $successfulPayments = Payment::where('status', 'success')->count();
        $failedPayments = Payment::where('status', 'failed')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();

        return view('admin.payments.index', compact('payments', 'totalRevenue', 'successfulPayments', 'failedPayments', 'pendingPayments'));
    }
}
