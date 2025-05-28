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
                                        <button type="button" class="btn btn-sm btn-primary update-payment-status-btn" 
                                                data-payment-id="{{ $payment->payment_id }}"
                                                data-bill-no="{{ $payment->bill->bill_no }}"
                                                data-payment-status="{{ $payment->payment_status }}"
                                                data-payment-remarks="{{ $payment->remarks }}">
                                            <i class="bi bi-pencil-square"></i> Update Status
                                        </button>
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

    <!-- Single Modal for Payment Status Update (Outside the table) -->
    <div class="modal fade" id="paymentStatusUpdateModal" tabindex="-1" aria-labelledby="paymentStatusUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentStatusUpdateModalLabel">Update Payment Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="paymentStatusUpdateForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modalPaymentStatus" class="form-label">Status</label>
                            <select class="form-select" id="modalPaymentStatus" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="processed">Processed</option>
                                <option value="completed">Completed</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modalPaymentRemarks" class="form-label">College Remarks</label>
                            <textarea class="form-control" id="modalPaymentRemarks" name="remarks" rows="3"></textarea>
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
@endsection 

@section('styles')
<style>
/* Fix modal z-index and backdrop issues */
.modal {
    z-index: 1055 !important;
}

.modal-backdrop {
    z-index: 1054 !important;
}

/* Ensure modal content is clickable */
.modal-dialog {
    z-index: 1056 !important;
    position: relative;
}

.modal-content {
    background-color: #fff !important;
    border: 1px solid rgba(0,0,0,.2) !important;
    border-radius: 0.375rem !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    pointer-events: auto !important;
}

/* Ensure all modal elements are clickable */
.modal-header,
.modal-body,
.modal-footer {
    pointer-events: auto !important;
}

/* Fix button clickability */
.modal .btn {
    pointer-events: auto !important;
    z-index: 1 !important;
    position: relative !important;
}

.modal .btn-close {
    pointer-events: auto !important;
    z-index: 1 !important;
}

.modal .form-control,
.modal .form-select {
    pointer-events: auto !important;
    z-index: 1 !important;
}

/* Override any conflicting sidebar styles */
.sidebar {
    z-index: 100 !important;
}

/* Make sure modal appears above sidebar */
@media (max-width: 768px) {
    .modal {
        z-index: 1055 !important;
    }
    
    .modal-backdrop {
        z-index: 1054 !important;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('Payment status modal setup - DOM loaded');
    
    // Get modal elements
    const modal = document.getElementById('paymentStatusUpdateModal');
    const form = document.getElementById('paymentStatusUpdateForm');
    const modalTitle = document.getElementById('paymentStatusUpdateModalLabel');
    const statusSelect = document.getElementById('modalPaymentStatus');
    const remarksTextarea = document.getElementById('modalPaymentRemarks');
    
    if (!modal || !form) {
        console.error('Payment modal or form not found');
        return;
    }
    
    // Initialize Bootstrap modal
    const bsModal = new bootstrap.Modal(modal);
    
    // Add click event listeners to update payment status buttons
    document.querySelectorAll('.update-payment-status-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Update payment status button clicked');
            
            // Get data from button attributes
            const paymentId = this.dataset.paymentId;
            const billNo = this.dataset.billNo;
            const paymentStatus = this.dataset.paymentStatus;
            const paymentRemarks = this.dataset.paymentRemarks || '';
            
            console.log('Payment data:', { paymentId, billNo, paymentStatus, paymentRemarks });
            
            // Update modal title
            modalTitle.textContent = `Update Payment Status for Bill: ${billNo}`;
            
            // Set form action
            form.action = `/college/payments-status/${paymentId}`;
            
            // Set current values
            statusSelect.value = paymentStatus;
            remarksTextarea.value = paymentRemarks;
            
            // Show modal
            bsModal.show();
        });
    });
    
    // Ensure modal is working
    modal.addEventListener('show.bs.modal', function (event) {
        console.log('Payment modal is showing');
        event.target.style.pointerEvents = 'auto';
    });
    
    modal.addEventListener('shown.bs.modal', function (event) {
        console.log('Payment modal is shown');
        // Focus on the status select
        statusSelect.focus();
    });
    
    modal.addEventListener('hidden.bs.modal', function (event) {
        console.log('Payment modal is hidden');
        // Clean up
        form.reset();
    });
    
    // Debug: Log when any modal-related element is clicked
    document.addEventListener('click', function(e) {
        if (e.target.closest('.modal') || e.target.matches('[data-bs-toggle="modal"]')) {
            console.log('Payment modal-related element clicked:', e.target);
        }
    });
});
</script>
@endsection 