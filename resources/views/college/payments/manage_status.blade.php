@extends('college.layouts.app')

@section('title', 'Manage Payment Status')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Payment Status</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.payments.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Payments
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

    <div class="card">
        <div class="card-header">
            <i class="bi bi-credit-card me-1"></i>
            Payment Status Management
        </div>
        <div class="card-body">
            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Payment ID</th>
                                <th>Related Bill</th>
                                <th>Amount (₹ Cr)</th>
                                <th>Payment Date</th>
                                <th>Current Status</th>
                                <th>Transaction Reference</th>
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
                                            @elseif($payment->payment_status == 'processed') bg-info
                                            @elseif($payment->payment_status == 'completed') bg-success
                                            @elseif($payment->payment_status == 'rejected') bg-danger
                                            @else bg-secondary @endif">
                                            {{ ucfirst($payment->payment_status) }}
                                        </span>
                                    </td>
                                    <td>{{ $payment->transaction_reference ?? 'N/A' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#statusModal{{ $payment->payment_id }}">
                                            <i class="bi bi-pencil-square"></i> Update Status
                                        </button>
                                        
                                        <!-- Status Update Modal -->
                                        <div class="modal fade" id="statusModal{{ $payment->payment_id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $payment->payment_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="statusModalLabel{{ $payment->payment_id }}">Update Payment Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('college.payments.status.update', $payment->payment_id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="status{{ $payment->payment_id }}" class="form-label">Status</label>
                                                                <select class="form-select" id="status{{ $payment->payment_id }}" name="status" required>
                                                                    <option value="pending" {{ $payment->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="completed" {{ $payment->payment_status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                                    <option value="rejected" {{ $payment->payment_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="remarks{{ $payment->payment_id }}" class="form-label">College Remarks</label>
                                                                <textarea class="form-control" id="remarks{{ $payment->payment_id }}" name="remarks" rows="3">{{ $payment->remarks }}</textarea>
                                                                <small class="text-muted">Add any comments or details about this status change.</small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
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
                    <i class="bi bi-credit-card-2-front display-4 text-muted"></i>
                    <p class="mt-3">No payments found. Create your first payment to get started.</p>
                    <a href="{{ route('college.payments.create') }}" class="btn btn-primary">Record New Payment</a>
                </div>
            @endif
        </div>
    </div>
@endsection 