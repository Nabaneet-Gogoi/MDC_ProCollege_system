@extends('college.layouts.app')

@section('title', 'Payment History')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Payment History</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.payments.create') }}" class="btn btn-sm btn-success me-2">
                <i class="bi bi-plus-circle"></i> Record New Payment
            </a>
            <a href="{{ route('college.payments.status.manage') }}" class="btn btn-sm btn-primary me-2">
                <i class="bi bi-gear"></i> Manage Payment Status
            </a>
            <a href="{{ route('college.dashboard') }}" class="btn btn-sm btn-secondary">
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
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-funnel me-1"></i>
            Filter Payments
        </div>
        <div class="card-body">
            <form action="{{ route('college.payments.filter') }}" method="GET">
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
                    <a href="{{ route('college.payments.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Payments List Card -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-credit-card me-1"></i>
            Payment Records
        </div>
        <div class="card-body">
            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
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
                                    <td>{{ number_format($payment->payment_amt, 2) }}</td>
                                    <td>{{ $payment->payment_date->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($payment->payment_status == 'pending') bg-warning
                                            @elseif($payment->payment_status == 'completed') bg-success
                                            @else bg-secondary @endif">
                                            {{ ucfirst($payment->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->transaction_reference ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('college.payments.show', $payment->payment_id) }}" class="btn btn-sm btn-info" title="View details">
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
                <div class="text-center py-4">
                    <i class="bi bi-credit-card-x display-4 text-muted"></i>
                    <p class="mt-3">No payment records found matching your criteria.</p>
                </div>
            @endif
        </div>
    </div>
@endsection 