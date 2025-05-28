@extends('college.layouts.app')

@section('title', 'Manage Payment Status')

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

.btn-modern.btn-secondary {
    background: var(--secondary-gradient);
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.btn-modern.btn-primary {
    background: var(--info-gradient);
    box-shadow: 0 4px 12px rgba(8, 145, 178, 0.3);
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

.badge-modern.bg-info {
    background: var(--info-gradient) !important;
    color: white;
}

.badge-modern.bg-success {
    background: var(--success-gradient) !important;
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
    padding: 6px 12px;
    font-size: 0.75rem;
    border-radius: 6px;
    transition: all 0.2s ease;
    background: var(--primary-gradient);
    border: none;
    color: white;
    box-shadow: 0 2px 8px rgba(30, 60, 114, 0.3);
}

.btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(30, 60, 114, 0.4);
    color: white;
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

/* Enhanced Modal */
.modal {
    z-index: 1055 !important;
}

.modal-backdrop {
    z-index: 1054 !important;
    background: rgba(30, 60, 114, 0.4);
    backdrop-filter: blur(4px);
}

.modal-dialog {
    z-index: 1056 !important;
    position: relative;
}

.modal-content {
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    border: none;
    border-radius: 16px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    pointer-events: auto !important;
}

.modal-header {
    background: var(--primary-gradient);
    color: white;
    border-radius: 16px 16px 0 0;
    padding: 16px 20px;
    border-bottom: none;
}

.modal-title {
    font-weight: 600;
    font-size: 1.1rem;
}

.modal-body {
    padding: 20px;
}

.modal-footer {
    border-top: 1px solid #e5e7eb;
    padding: 16px 20px;
    border-radius: 0 0 16px 16px;
}

.modal .form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 6px;
}

.modal .form-control,
.modal .form-select {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 8px 12px;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.modal .form-control:focus,
.modal .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.modal .btn {
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.2s ease;
}

.modal .btn-primary {
    background: var(--primary-gradient);
    border: none;
    box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3);
}

.modal .btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(30, 60, 114, 0.4);
}

.modal .btn-secondary {
    background: #6b7280;
    border: none;
    color: white;
}

.modal .btn-close {
    filter: brightness(0) invert(1);
    opacity: 0.8;
}

.modal .btn-close:hover {
    opacity: 1;
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
    
    .modern-table {
        font-size: 0.8rem;
    }
    
    .modern-table thead th,
    .modern-table tbody td {
        padding: 8px 6px;
    }
    
    .modal-dialog {
        margin: 10px;
    }
    
    .modal-body {
        padding: 16px;
    }
}
</style>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom modern-header">
        <h1 class="h2">Manage Payment Status</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.payments.index') }}" class="btn btn-sm btn-secondary btn-modern">
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

    <div class="modern-card">
        <div class="card-header">
            <i class="bi bi-credit-card me-1"></i>
            Payment Status Management
        </div>
        <div class="card-body">
            @if($payments->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover modern-table">
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
                                    <td><strong>{{ number_format($payment->payment_amt, 2) }}</strong></td>
                                    <td>{{ $payment->payment_date->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge badge-modern
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
                                        <button type="button" class="btn btn-sm btn-action update-payment-status-btn" 
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
                <div class="empty-state">
                    <i class="bi bi-credit-card-2-front"></i>
                    <p class="mt-3">No payments found. Create your first payment to get started.</p>
                    <a href="{{ route('college.payments.create') }}" class="btn btn-primary btn-modern">Record New Payment</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Enhanced Modal for Payment Status Update -->
    <div class="modal fade" id="paymentStatusUpdateModal" tabindex="-1" aria-labelledby="paymentStatusUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentStatusUpdateModalLabel">
                        <i class="bi bi-gear me-2"></i>Update Payment Status
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="paymentStatusUpdateForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modalPaymentStatus" class="form-label">
                                <i class="bi bi-check-circle me-1"></i>Status
                            </label>
                            <select class="form-select" id="modalPaymentStatus" name="status" required>
                                <option value="pending">Pending</option>
                                <option value="processed">Processed</option>
                                <option value="completed">Completed</option>
                                <option value="rejected">Rejected</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modalPaymentRemarks" class="form-label">
                                <i class="bi bi-chat-text me-1"></i>College Remarks
                            </label>
                            <textarea class="form-control" id="modalPaymentRemarks" name="remarks" rows="3" placeholder="Add any comments or details about this status change..."></textarea>
                            <small class="text-muted">Add any comments or details about this status change.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-1"></i>Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
            modalTitle.innerHTML = `<i class="bi bi-gear me-2"></i>Update Payment Status for Bill: ${billNo}`;
            
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