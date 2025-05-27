@extends('admin.layouts.app')

@section('title', 'Payment Details')

@section('content')
<style>
    /* Modern Design System for Payment Details */
    .modern-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        position: relative;
        border-radius: 16px;
        margin-bottom: 24px;
        padding: 20px 24px;
        color: white;
        overflow: hidden;
    }
    
    .modern-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 50%, rgba(255,255,255,0.1) 1px, transparent 1px),
                    radial-gradient(circle at 80% 50%, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 20px 20px;
        opacity: 0.3;
    }
    
    .modern-header h1 {
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        z-index: 10;
        position: relative;
    }
    
    .modern-btn {
        border: none;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        cursor: pointer;
        z-index: 10;
        position: relative;
    }
    
    .modern-btn-primary {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(79, 172, 254, 0.3);
    }
    
    .modern-btn-secondary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
    }
    
    .modern-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    }
    
    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(102, 126, 234, 0.1);
        overflow: hidden;
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }
    
    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(102, 126, 234, 0.15);
    }
    
    .modern-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 16px 20px;
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        display: flex;
        justify-content: between;
        align-items: center;
    }
    
    .modern-card-header h5 {
        font-weight: 700;
        font-size: 13px;
        margin: 0;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .modern-card-body {
        padding: 20px;
    }
    
    .info-item {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%);
        border: 1px solid rgba(102, 126, 234, 0.08);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.3s ease;
    }
    
    .info-item:hover {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        transform: translateX(4px);
    }
    
    .info-label {
        font-weight: 600;
        font-size: 12px;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        min-width: 140px;
    }
    
    .info-value {
        font-weight: 500;
        font-size: 13px;
        color: #2c3e50;
        margin: 0;
        text-align: right;
        flex: 1;
    }
    
    .info-value.amount {
        font-weight: 700;
        font-size: 15px;
        color: #667eea;
    }
    
    .modern-badge {
        padding: 6px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .modern-badge.status-pending {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        color: white;
    }
    
    .modern-badge.status-processed {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
    }
    
    .modern-badge.status-completed {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .modern-badge.status-rejected {
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        color: white;
    }
    
    .modern-badge.status-approved {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .action-group {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        padding: 20px;
        margin-top: 20px;
    }
    
    .action-group h6 {
        font-weight: 700;
        font-size: 13px;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
    }
    
    .btn-action {
        border: none;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 12px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.3s ease;
        cursor: pointer;
        margin: 4px;
    }
    
    .btn-action:hover {
        transform: translateY(-1px);
    }
    
    .btn-action.btn-info {
        background: #17a2b8;
        color: white;
        box-shadow: 0 3px 10px rgba(23, 162, 184, 0.3);
    }
    
    .btn-action.btn-success {
        background: #28a745;
        color: white;
        box-shadow: 0 3px 10px rgba(40, 167, 69, 0.3);
    }
    
    .btn-action.btn-danger {
        background: #dc3545;
        color: white;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
    }
    
    .btn-action.btn-outline-danger {
        background: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        border: 1px solid rgba(220, 53, 69, 0.3);
    }
    
    .progress-modern {
        height: 12px;
        border-radius: 6px;
        background: rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin: 12px 0;
    }
    
    .progress-modern .progress-bar {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-radius: 6px;
        transition: width 0.6s ease;
    }
    
    .payment-summary {
        background: linear-gradient(135deg, rgba(40, 167, 69, 0.05) 0%, rgba(32, 201, 151, 0.05) 100%);
        border: 1px solid rgba(40, 167, 69, 0.1);
        border-radius: 12px;
        padding: 16px 20px;
        margin-top: 16px;
    }
    
    .modern-table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        margin-top: 16px;
    }
    
    .modern-table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 700;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px;
        border: none;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
    }
    
    .modern-table tbody tr.current-payment {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(0, 242, 254, 0.1) 100%);
        border: 1px solid rgba(79, 172, 254, 0.2);
    }
    
    .modern-table tbody td {
        padding: 12px;
        font-size: 13px;
        font-weight: 500;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .remarks-section {
        background: linear-gradient(135deg, rgba(168, 237, 234, 0.1) 0%, rgba(254, 214, 227, 0.1) 100%);
        border: 1px solid rgba(168, 237, 234, 0.2);
        border-radius: 12px;
        padding: 16px 20px;
        margin-top: 16px;
    }
    
    .remarks-section h6 {
        font-weight: 700;
        font-size: 13px;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }
    
    .remarks-section p {
        font-size: 13px;
        font-weight: 500;
        margin: 0;
        color: #2c3e50;
        line-height: 1.5;
    }
    
    @media (max-width: 768px) {
        .modern-header {
            padding: 12px 16px;
        }
        
        .modern-card-body {
            padding: 16px;
        }
        
        .modern-btn {
            padding: 6px 12px;
            font-size: 11px;
        }
        
        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .info-label {
            min-width: auto;
        }
        
        .info-value {
            text-align: left;
        }
    }
</style>

<!-- Modern Header -->
<div class="modern-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1><i class="bi bi-credit-card me-2"></i>Payment Details</h1>
        <div class="d-flex gap-2 flex-wrap">
            @if(in_array($payment->payment_status, ['pending', 'processed']))
                <a href="{{ route('admin.payments.edit', $payment->payment_id) }}" class="modern-btn modern-btn-primary">
                    <i class="bi bi-pencil"></i> Edit Payment
                </a>
            @endif
            <a href="{{ route('payments.print', $payment->payment_id) }}" class="modern-btn modern-btn-primary" target="_blank">
                <i class="bi bi-printer"></i> Print Payment
            </a>
            <a href="{{ route('admin.payments.index') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Payments
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 12px; border: 1px solid rgba(40, 167, 69, 0.2);">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: 1px solid rgba(220, 53, 69, 0.2);">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-md-6">
        <!-- Payment Details Card -->
        <div class="modern-card">
            <div class="modern-card-header">
                <h5><i class="bi bi-credit-card me-2"></i>Payment Information</h5>
                <span class="modern-badge status-{{ $payment->payment_status }}">
                    <i class="bi bi-{{ $payment->payment_status == 'pending' ? 'clock' : ($payment->payment_status == 'completed' ? 'check-circle' : ($payment->payment_status == 'processed' ? 'hourglass-split' : 'x-circle')) }}"></i>
                    {{ ucfirst($payment->payment_status) }}
                </span>
            </div>
            <div class="modern-card-body">
                <div class="info-item">
                    <div class="info-label">Payment ID</div>
                    <p class="info-value">{{ $payment->payment_id }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Amount</div>
                    <p class="info-value amount">₹{{ number_format($payment->payment_amt, 2) }} Cr</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Payment Date</div>
                    <p class="info-value">{{ $payment->payment_date->format('d-m-Y') }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Transaction Ref</div>
                    <p class="info-value">{{ $payment->transaction_reference ?? 'N/A' }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Created On</div>
                    <p class="info-value">{{ $payment->created_at->format('d-m-Y h:i A') }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Last Updated</div>
                    <p class="info-value">{{ $payment->updated_at->format('d-m-Y h:i A') }}</p>
                </div>
                
                @if($payment->remarks)
                    <div class="remarks-section">
                        <h6>College Remarks</h6>
                        <p>{{ $payment->remarks }}</p>
                    </div>
                @endif
                
                @if($payment->admin_remarks)
                    <div class="remarks-section">
                        <h6>Admin Remarks</h6>
                        <p>{{ $payment->admin_remarks }}</p>
                    </div>
                @endif
                
                <!-- Status Update Actions -->
                <div class="action-group">
                    <h6>Update Payment Status</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @if($payment->payment_status === 'pending')
                            <button type="button" class="btn-action btn-info" data-bs-toggle="modal" data-bs-target="#processPaymentModal">
                                <i class="bi bi-hourglass-split"></i> Mark as Processed
                            </button>
                            
                            <button type="button" class="btn-action btn-danger" data-bs-toggle="modal" data-bs-target="#rejectPaymentModal">
                                <i class="bi bi-x-circle"></i> Reject Payment
                            </button>
                        @endif
                        
                        @if($payment->payment_status === 'processed')
                            <button type="button" class="btn-action btn-success" data-bs-toggle="modal" data-bs-target="#completePaymentModal">
                                <i class="bi bi-check-circle"></i> Mark as Completed
                            </button>
                            
                            <button type="button" class="btn-action btn-danger" data-bs-toggle="modal" data-bs-target="#rejectPaymentModal">
                                <i class="bi bi-x-circle"></i> Reject Payment
                            </button>
                        @endif
                        
                        @if($payment->payment_status === 'pending')
                            <form action="{{ route('admin.payments.destroy', $payment->payment_id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-outline-danger" 
                                    onclick="return confirm('Are you sure you want to delete this payment? This action cannot be undone.');">
                                    <i class="bi bi-trash"></i> Delete Payment
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <!-- Bill Details Card -->
        <div class="modern-card">
            <div class="modern-card-header">
                <h5><i class="bi bi-file-earmark-text me-2"></i>Related Bill Information</h5>
            </div>
            <div class="modern-card-body">
                <div class="info-item">
                    <div class="info-label">Bill Number</div>
                    <p class="info-value">
                        <a href="{{ route('admin.bills.show', $payment->bill->bill_id) }}" class="text-decoration-none" style="color: #667eea; font-weight: 600;">
                            {{ $payment->bill->bill_no }}
                        </a>
                    </p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">College</div>
                    <p class="info-value">{{ $payment->bill->college->college_name }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Bill Amount</div>
                    <p class="info-value amount">₹{{ number_format($payment->bill->bill_amt, 2) }} Cr</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Bill Date</div>
                    <p class="info-value">{{ $payment->bill->bill_date->format('d-m-Y') }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Bill Status</div>
                    <p class="info-value">
                        <span class="modern-badge status-{{ $payment->bill->bill_status }}">
                            <i class="bi bi-{{ $payment->bill->bill_status == 'pending' ? 'clock' : ($payment->bill->bill_status == 'approved' ? 'check-circle' : 'x-circle') }}"></i>
                            {{ ucfirst($payment->bill->bill_status) }}
                        </span>
                    </p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Funding Source</div>
                    <p class="info-value">{{ $payment->bill->funding->approved_amt }} Cr (Central: {{ $payment->bill->funding->central_share }} Cr, State: {{ $payment->bill->funding->state_share }} Cr)</p>
                </div>
                
                <!-- Payment Summary -->
                <div class="payment-summary">
                    <h6 style="font-weight: 700; font-size: 13px; color: #495057; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">Payment Summary</h6>
                    @php
                        $totalPaid = $payment->bill->payments->sum('payment_amt');
                        $remainingAmount = $payment->bill->bill_amt - $totalPaid;
                        $paidPercentage = ($totalPaid / $payment->bill->bill_amt) * 100;
                    @endphp
                    
                    <div class="progress-modern">
                        <div class="progress-bar" role="progressbar" 
                            style="width: {{ $paidPercentage }}%;" 
                            aria-valuenow="{{ $paidPercentage }}" 
                            aria-valuemin="0" 
                            aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small style="font-size: 11px; font-weight: 600;">Paid: ₹{{ number_format($totalPaid, 2) }} Cr ({{ number_format($paidPercentage, 1) }}%)</small>
                        <small style="font-size: 11px; font-weight: 600;">Remaining: ₹{{ number_format($remainingAmount, 2) }} Cr</small>
                    </div>
                </div>
                
                @if($payment->bill->payments->count() > 1)
                    <div class="mt-3">
                        <h6 style="font-weight: 700; font-size: 13px; color: #495057; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">All Payments for this Bill</h6>
                        <div class="table-responsive">
                            <table class="table modern-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payment->bill->payments as $billPayment)
                                        <tr @if($billPayment->payment_id === $payment->payment_id) class="current-payment" @endif>
                                            <td>
                                                <a href="{{ route('admin.payments.show', $billPayment->payment_id) }}" 
                                                    class="text-decoration-none" style="color: #667eea; font-weight: 600;">
                                                    {{ $billPayment->payment_id }}
                                                </a>
                                            </td>
                                            <td><strong>₹{{ number_format($billPayment->payment_amt, 2) }} Cr</strong></td>
                                            <td>{{ $billPayment->payment_date->format('d-m-Y') }}</td>
                                            <td>
                                                <span class="modern-badge status-{{ $billPayment->payment_status }}">
                                                    {{ ucfirst($billPayment->payment_status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- Process Payment Modal -->
<div class="modal fade" id="processPaymentModal" tabindex="-1" aria-labelledby="processPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);">
            <form action="{{ route('admin.payments.updateStatus', $payment->payment_id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="processed">
                
                <div class="modal-header" style="background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%); color: white; border-bottom: none; border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title" id="processPaymentModalLabel" style="font-weight: 700; font-size: 15px;">Mark Payment as Processed</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px;">
                    <div class="mb-3">
                        <label for="admin_remarks" class="form-label" style="font-weight: 600; font-size: 12px; color: #495057; text-transform: uppercase; letter-spacing: 0.5px;">Admin Remarks</label>
                        <textarea class="form-control" id="admin_remarks" name="admin_remarks" rows="3" style="border-radius: 10px; border: 1px solid #dee2e6; font-size: 13px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none; padding: 0 24px 24px;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: rgba(108, 117, 125, 0.15); color: #6c757d; border-radius: 10px; font-weight: 600; font-size: 12px;">Cancel</button>
                    <button type="submit" class="btn-action btn-info">Mark as Processed</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Complete Payment Modal -->
<div class="modal fade" id="completePaymentModal" tabindex="-1" aria-labelledby="completePaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);">
            <form action="{{ route('admin.payments.updateStatus', $payment->payment_id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="completed">
                
                <div class="modal-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-bottom: none; border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title" id="completePaymentModalLabel" style="font-weight: 700; font-size: 15px;">Mark Payment as Completed</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px;">
                    <div class="mb-3">
                        <label for="admin_remarks" class="form-label" style="font-weight: 600; font-size: 12px; color: #495057; text-transform: uppercase; letter-spacing: 0.5px;">Admin Remarks</label>
                        <textarea class="form-control" id="admin_remarks" name="admin_remarks" rows="3" style="border-radius: 10px; border: 1px solid #dee2e6; font-size: 13px;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none; padding: 0 24px 24px;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: rgba(108, 117, 125, 0.15); color: #6c757d; border-radius: 10px; font-weight: 600; font-size: 12px;">Cancel</button>
                    <button type="submit" class="btn-action btn-success">Mark as Completed</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Payment Modal -->
<div class="modal fade" id="rejectPaymentModal" tabindex="-1" aria-labelledby="rejectPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);">
            <form action="{{ route('admin.payments.updateStatus', $payment->payment_id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="rejected">
                
                <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%); color: white; border-bottom: none; border-radius: 16px 16px 0 0;">
                    <h5 class="modal-title" id="rejectPaymentModalLabel" style="font-weight: 700; font-size: 15px;">Reject Payment</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 24px;">
                    <div class="mb-3">
                        <label for="admin_remarks" class="form-label" style="font-weight: 600; font-size: 12px; color: #495057; text-transform: uppercase; letter-spacing: 0.5px;">Admin Remarks <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="admin_remarks" name="admin_remarks" rows="3" required style="border-radius: 10px; border: 1px solid #dee2e6; font-size: 13px;"></textarea>
                        <div class="form-text" style="font-size: 11px;">Please provide a reason for rejecting this payment.</div>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: none; padding: 0 24px 24px;">
                    <button type="button" class="btn" data-bs-dismiss="modal" style="background: rgba(108, 117, 125, 0.15); color: #6c757d; border-radius: 10px; font-weight: 600; font-size: 12px;">Cancel</button>
                    <button type="submit" class="btn-action btn-danger">Reject Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 