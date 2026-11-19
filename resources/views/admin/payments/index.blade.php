@extends('admin.backend_master')

@section('contentpanel')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h1 class="h3 mb-0 text-gray-800">Payments & Insights</h1>
    </div>
</div>

<div class="row mb-4">
    <!-- Total Revenue -->
    <a href="{{ route('admin.payments.index') }}" style="text-decoration:none;" class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Total Revenue</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">₹{{ number_format($totalRevenue, 2) }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-rupee-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Successful Payments -->
    <a href="{{ route('admin.payments.index', ['status' => 'success']) }}" style="text-decoration:none;" class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Successful Payments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $successfulPayments }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Pending Payments -->
    <a href="{{ route('admin.payments.index', ['status' => 'pending']) }}" style="text-decoration:none;" class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Pending Payments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingPayments }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>

    <!-- Failed Payments -->
    <a href="{{ route('admin.payments.index', ['status' => 'failed']) }}" style="text-decoration:none;" class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Failed/Denied Payments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $failedPayments }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Recent Transactions</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Date & Time</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Package</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Txn ID</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->created_at->format('d M Y, h:i A') }}</td>
                            <td>{{ $payment->user->name ?? 'N/A' }}</td>
                            <td>{{ $payment->user->email ?? 'N/A' }}</td>
                            <td>{{ $payment->package->name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($payment->amount, 2) }}</td>
                            <td>
                                @if($payment->status == 'success')
                                    <span class="badge bg-success">Success</span>
                                @elseif($payment->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">Failed</span>
                                @endif
                            </td>
                            <td>{{ $payment->transaction_id ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No payments found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $payments->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
