@extends('college.layouts.app')

@section('title', 'Payment Details')

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
    display: flex;
    justify-content: between;
    align-items: center;
}

.modern-card .card-body {
    padding: 16px;
}

/* Enhanced Table Design */
.detail-table {
    font-size: 0.9rem;
    margin-bottom: 0;
}

.detail-table th {
    font-weight: 600;
    color: #374151;
    padding: 8px 0;
    border: none;
    background: transparent;
    width: 35%;
}

.detail-table td {
    padding: 8px 0;
    border: none;
    color: #1f2937;
}

.detail-table tr {
    border-bottom: 1px solid #f3f4f6;
}

.detail-table tr:last-child {
    border-bottom: none;
}

/* Enhanced Badges */
.badge-modern {
    font-size: 0.75rem;
    padding: 6px 12px;
    font-weight: 600;
    border-radius: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
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

.badge-modern.bg-primary {
    background: var(--primary-gradient) !important;
    color: white;
}

/* Enhanced Amount Display */
.amount-display {
    font-size: 1.1rem;
    font-weight: 700;
    color: #059669;
    background: linear-gradient(135deg, #059669, #10b981);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

/* Progress Bar Enhancements */
.progress-modern {
    height: 12px;
    border-radius: 6px;
    background: #f1f5f9;
    overflow: hidden;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
}

.progress-modern .progress-bar {
    background: var(--success-gradient);
    border-radius: 6px;
    transition: width 1s ease-in-out;
    position: relative;
    overflow: hidden;
}

.progress-modern .progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Remarks Section */
.remarks-section {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 8px;
    padding: 12px 16px;
    margin-top: 12px;
    border-left: 4px solid #3b82f6;
}

.remarks-section h6 {
    color: #374151;
    font-size: 0.85rem;
    font-weight: 600;
    margin-bottom: 6px;
}

.remarks-section p {
    color: #6b7280;
    font-size: 0.85rem;
    margin: 0;
    line-height: 1.5;
}

/* Payment Summary Table */
.summary-table {
    font-size: 0.8rem;
}

.summary-table thead th {
    background: linear-gradient(145deg, #f1f5f9 0%, #e2e8f0 100%);
    font-weight: 600;
    color: #374151;
    padding: 8px 10px;
    border: none;
    font-size: 0.75rem;
}

.summary-table tbody td {
    padding: 8px 10px;
    vertical-align: middle;
    border-color: #f1f5f9;
    font-size: 0.8rem;
}

.summary-table tbody tr {
    transition: all 0.2s ease;
}

.summary-table tbody tr:hover {
    background-color: #f8fafc;
    transform: translateX(2px);
}

.summary-table tbody tr.table-primary {
    background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(147, 197, 253, 0.1));
    border-left: 3px solid #3b82f6;
}

/* Payment Progress Info */
.progress-info {
    display: flex;
    justify-content: between;
    margin-top: 6px;
    font-size: 0.75rem;
}

.progress-info small {
    color: #6b7280;
    font-weight: 500;
}

/* Link Styling */
.modern-link {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
}

.modern-link:hover {
    color: #1d4ed8;
    text-decoration: underline;
}

/* Responsive Layout Optimization */
@media (max-width: 768px) {
    .modern-header h1 {
        font-size: 1.25rem !important;
    }
    
    .btn-modern {
        font-size: 0.75rem;
        padding: 5px 10px;
    }
    
    .modern-card .card-body {
        padding: 12px;
    }
    
    .detail-table {
        font-size: 0.85rem;
    }
    
    .detail-table th {
        width: 40%;
    }
    
    .summary-table {
        font-size: 0.75rem;
    }
    
    .summary-table thead th,
    .summary-table tbody td {
        padding: 6px 8px;
    }
    
    .amount-display {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .modern-header .btn-toolbar {
        flex-direction: column;
        gap: 8px;
    }
    
    .modern-header .btn-modern {
        width: 100%;
        justify-content: center;
    }
    
    .row > div[class*="col-"] {
        margin-bottom: 16px;
    }
}
</style>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom modern-header">
        <h1 class="h2">Payment Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.payments.index') }}" class="btn btn-sm btn-secondary btn-modern me-2">
                <i class="bi bi-arrow-left"></i> Back to Payments
            </a>
            <a href="{{ route('payments.print', $payment->payment_id) }}" class="btn btn-sm btn-primary btn-modern" target="_blank">
                <i class="bi bi-printer"></i> Print Payment
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

    <div class="row">
        <div class="col-md-6">
            <!-- Payment Details Card -->
            <div class="modern-card">
                <div class="card-header">
                    <div>
                        <i class="bi bi-credit-card me-2"></i>
                        Payment Information
                    </div>
                    <span class="badge badge-modern
                        @if($payment->payment_status == 'pending') bg-warning
                        @elseif($payment->payment_status == 'processed') bg-info
                        @elseif($payment->payment_status == 'completed') bg-success
                        @elseif($payment->payment_status == 'rejected') bg-danger
                        @else bg-secondary @endif">
                        {{ ucfirst($payment->payment_status) }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless detail-table">
                            <tbody>
                                <tr>
                                    <th><i class="bi bi-hash me-1"></i>Payment ID:</th>
                                    <td><strong>{{ $payment->payment_id }}</strong></td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-currency-rupee me-1"></i>Amount:</th>
                                    <td class="amount-display">₹{{ number_format($payment->payment_amt, 2) }} Cr</td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-calendar-date me-1"></i>Payment Date:</th>
                                    <td>{{ $payment->payment_date->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-receipt me-1"></i>Transaction Reference:</th>
                                    <td>{{ $payment->transaction_reference ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-clock me-1"></i>Created On:</th>
                                    <td>{{ $payment->created_at->format('d-m-Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-arrow-clockwise me-1"></i>Last Updated:</th>
                                    <td>{{ $payment->updated_at->format('d-m-Y h:i A') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    @if($payment->remarks)
                        <div class="remarks-section">
                            <h6><i class="bi bi-chat-text me-1"></i>College Remarks:</h6>
                            <p>{{ $payment->remarks }}</p>
                        </div>
                    @endif
                    
                    @if($payment->admin_remarks)
                        <div class="remarks-section">
                            <h6><i class="bi bi-shield-check me-1"></i>Admin Remarks:</h6>
                            <p>{{ $payment->admin_remarks }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Bill Details Card -->
            <div class="modern-card">
                <div class="card-header">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    Related Bill Information
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless detail-table">
                            <tbody>
                                <tr>
                                    <th><i class="bi bi-file-text me-1"></i>Bill Number:</th>
                                    <td>
                                        <a href="{{ route('college.bills.show', $payment->bill->bill_id) }}" class="modern-link">
                                            {{ $payment->bill->bill_no }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-currency-rupee me-1"></i>Bill Amount:</th>
                                    <td class="amount-display">₹{{ number_format($payment->bill->bill_amt, 2) }} Cr</td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-calendar me-1"></i>Bill Date:</th>
                                    <td>{{ $payment->bill->bill_date->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-check-circle me-1"></i>Bill Status:</th>
                                    <td>
                                        <span class="badge badge-modern
                                            @if($payment->bill->bill_status == 'pending') bg-warning
                                            @elseif($payment->bill->bill_status == 'approved') bg-success
                                            @elseif($payment->bill->bill_status == 'rejected') bg-danger
                                            @else bg-primary @endif">
                                            {{ ucfirst($payment->bill->bill_status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th><i class="bi bi-bank me-1"></i>Funding Source:</th>
                                    <td>
                                        <div class="funding-info">
                                            <div><strong>Total:</strong> ₹{{ $payment->bill->funding->approved_amt }} Cr</div>
                                            <small class="text-muted">
                                                Central: ₹{{ $payment->bill->funding->central_share }} Cr | 
                                                State: ₹{{ $payment->bill->funding->state_share }} Cr
                                            </small>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Enhanced Payment Summary -->
                    <div class="mt-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-graph-up me-1"></i>Payment Progress Summary
                        </h6>
                        @php
                            $totalPaid = $payment->bill->payments->sum('payment_amt');
                            $remainingAmount = $payment->bill->bill_amt - $totalPaid;
                            $paidPercentage = ($totalPaid / $payment->bill->bill_amt) * 100;
                        @endphp
                        
                        <div class="mt-2">
                            <div class="progress progress-modern">
                                <div class="progress-bar" role="progressbar" 
                                    style="width: {{ $paidPercentage }}%;" 
                                    aria-valuenow="{{ $paidPercentage }}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100"></div>
                            </div>
                            <div class="progress-info">
                                <small><strong>Paid:</strong> ₹{{ number_format($totalPaid, 2) }} Cr ({{ number_format($paidPercentage, 1) }}%)</small>
                                <small><strong>Remaining:</strong> ₹{{ number_format($remainingAmount, 2) }} Cr</small>
                            </div>
                        </div>
                        
                        @if($payment->bill->payments->count() > 1)
                            <div class="table-responsive mt-4">
                                <h6 class="fw-bold mb-2">
                                    <i class="bi bi-list-check me-1"></i>All Payments for this Bill
                                </h6>
                                <table class="table table-sm table-striped summary-table">
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
                                            <tr @if($billPayment->payment_id === $payment->payment_id) class="table-primary" @endif>
                                                <td>
                                                    <a href="{{ route('college.payments.show', $billPayment->payment_id) }}" 
                                                        class="modern-link">
                                                        {{ $billPayment->payment_id }}
                                                    </a>
                                                    @if($billPayment->payment_id === $payment->payment_id)
                                                        <small class="badge bg-primary ms-1">Current</small>
                                                    @endif
                                                </td>
                                                <td><strong>₹{{ number_format($billPayment->payment_amt, 2) }} Cr</strong></td>
                                                <td>{{ $billPayment->payment_date->format('d-m-Y') }}</td>
                                                <td>
                                                    <span class="badge badge-modern
                                                        @if($billPayment->payment_status == 'pending') bg-warning
                                                        @elseif($billPayment->payment_status == 'processed') bg-info
                                                        @elseif($billPayment->payment_status == 'completed') bg-success
                                                        @elseif($billPayment->payment_status == 'rejected') bg-danger
                                                        @else bg-secondary @endif">
                                                        {{ ucfirst($billPayment->payment_status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 