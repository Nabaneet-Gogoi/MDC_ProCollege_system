@extends('college.layouts.app')

@section('title', 'Payment History')

@section('styles')
<style>
/* Educational Theme Variables */
:root {
    --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%);
    --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
    --warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
    --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
    --danger-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
    --secondary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
    --shadow-modern: 0 4px 20px rgba(0, 0, 0, 0.1);
    --shadow-hover: 0 8px 25px rgba(0, 0, 0, 0.15);
}

/* Compact Header */
.modern-header {
    padding: 12px 0 8px 0 !important;
    margin-bottom: 16px !important;
    border-bottom: 2px solid #e5e7eb;
}

.modern-header h1 {
    font-size: 1.5rem !important;
    font-weight: 700;
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin: 0;
}

/* Modern Button System */
.btn-modern {
    transition: all 0.3s ease;
    border: 1px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(2px);
    font-weight: 600;
    font-size: 0.8rem;
    padding: 6px 12px;
}

.btn-modern.btn-success {
    background: var(--success-gradient);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.btn-modern.btn-primary {
    background: var(--info-gradient);
    box-shadow: 0 4px 12px rgba(8, 145, 178, 0.3);
}

.btn-modern.btn-secondary {
    background: var(--secondary-gradient);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-hover);
}

/* Compact Card System */
.modern-card {
    border: none;
    border-radius: 12px;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    box-shadow: var(--shadow-modern);
    transition: all 0.3s ease;
    margin-bottom: 16px;
}

.modern-card .card-header {
    background: var(--primary-gradient);
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 12px 16px;
    font-weight: 600;
    font-size: 0.9rem;
}

.modern-card .card-body {
    padding: 16px;
}

/* Filter Form Compact Design */
.filter-form .row {
    gap: 0;
}

.filter-form .col-md-3 {
    padding-right: 8px;
    padding-left: 8px;
}

.filter-form .form-label {
    font-size: 0.8rem;
    font-weight: 600;
    color: #374151;
    margin-bottom: 4px;
}

.filter-form .form-control,
.filter-form .form-select {
    font-size: 0.85rem;
    padding: 6px 10px;
    border-radius: 6px;
    border: 1px solid #d1d5db;
    transition: all 0.2s ease;
}

.filter-form .form-control:focus,
.filter-form .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Enhanced Table */
.modern-table {
    font-size: 0.85rem;
}

.modern-table thead th {
    background: linear-gradient(145deg, #f1f5f9 0%, #e2e8f0 100%);
    font-weight: 600;
    color: #374151;
    padding: 10px 12px;
    border: none;
    font-size: 0.8rem;
}

.modern-table tbody td {
    padding: 10px 12px;
    vertical-align: middle;
    border-color: #f1f5f9;
}

.modern-table tbody tr {
    transition: all 0.2s ease;
}

.modern-table tbody tr:hover {
    background-color: #f8fafc;
    transform: translateX(2px);
}

/* Enhanced Badges */
.badge-modern {
    font-size: 0.7rem;
    padding: 4px 8px;
    font-weight: 600;
    border-radius: 12px;
}

.badge-modern.bg-warning {
    background: var(--warning-gradient) !important;
    color: white;
}

.badge-modern.bg-success {
    background: var(--success-gradient) !important;
    color: white;
}

.badge-modern.bg-info {
    background: var(--info-gradient) !important;
    color: white;
}

.badge-modern.bg-danger {
    background: var(--danger-gradient) !important;
    color: white;
}

.badge-modern.bg-secondary {
    background: var(--secondary-gradient) !important;
    color: white;
}

/* Action Buttons */
.btn-action {
    padding: 4px 8px;
    font-size: 0.75rem;
    border-radius: 6px;
    transition: all 0.2s ease;
}

.btn-action:hover {
    transform: translateY(-1px);
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 40px 20px;
}

.empty-state i {
    font-size: 3rem;
    color: #9ca3af;
    margin-bottom: 16px;
}

.empty-state p {
    color: #6b7280;
    font-size: 0.9rem;
}

/* Responsive Optimizations */
@media (max-width: 768px) {
    .modern-header h1 {
        font-size: 1.25rem !important;
    }
    
    .btn-modern {
        font-size: 0.75rem;
        padding: 5px 10px;
    }
    
    .filter-form .col-md-3 {
        margin-bottom: 12px;
    }
    
    .modern-table {
        font-size: 0.8rem;
    }
    
    .modern-table thead th,
    .modern-table tbody td {
        padding: 8px 6px;
    }
}
</style>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom modern-header">
        <h1 class="h2">Payment History</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.payments.create') }}" class="btn btn-sm btn-success btn-modern me-2">
                <i class="bi bi-plus-circle"></i> Record New Payment
            </a>
            <a href="{{ route('college.payments.status.manage') }}" class="btn btn-sm btn-primary btn-modern me-2">
                <i class="bi bi-gear"></i> Manage Payment Status
            </a>
            <a href="{{ route('college.dashboard') }}" class="btn btn-sm btn-secondary btn-modern">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="modern-card">
        <div class="card-header">
            <i class="bi bi-funnel me-1"></i>
            Filter Payments
        </div>
        <div class="card-body">
            <form action="{{ route('college.payments.filter') }}" method="GET" class="filter-form">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="bill_id" class="form-label">Bill Number</label>
                        <select class="form-select" id="bill_id" name="bill_id">
                            <option value="">All Bills</option>
                            @foreach($bills ?? [] as $bill)
                                <option value="{{ $bill->bill_id }}" {{ request('bill_id') == $bill->bill_id ? 'selected' : '' }}>
                                    {{ $bill->bill_no }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Payment Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('college.payments.index') }}" class="btn btn-outline-secondary btn-modern me-2">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                    <button type="submit" class="btn btn-primary btn-modern">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Payments List Card -->
    <div class="modern-card">
        <div class="card-header">
            <i class="bi bi-credit-card me-1"></i>
            Payment Records
        </div>
        <div class="card-body">
            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover modern-table">
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Bill Number</th>
                                <th>Amount (₹ Cr)</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Transaction Ref</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                                <tr>
                                    <td>{{ $payment->payment_id }}</td>
                                    <td>
                                        <a href="{{ route('college.bills.show', $payment->bill->bill_id) }}" class="text-decoration-none">
                                            {{ $payment->bill->bill_no }}
                                        </a>
                                    </td>
                                    <td><strong>{{ number_format($payment->payment_amt, 2) }}</strong></td>
                                    <td>{{ $payment->payment_date->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge badge-modern
                                            @if($payment->payment_status == 'pending') bg-warning
                                            @elseif($payment->payment_status == 'completed') bg-success
                                            @else bg-secondary @endif">
                                            {{ ucfirst($payment->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->transaction_reference ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('college.payments.show', $payment->payment_id) }}" class="btn btn-sm btn-info btn-action" title="View details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $payments->links() }}
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-credit-card-x"></i>
                    <p class="mt-3">No payment records found matching your criteria.</p>
                </div>
            @endif
        </div>
    </div>
@endsection 