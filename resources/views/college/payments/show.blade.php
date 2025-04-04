@extends('college.layouts.app')

@section('title', 'Payment Details')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Payment Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.payments.index') }}" class="btn btn-sm btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Payments
            </a>
            <a href="{{ route('payments.print', $payment->payment_id) }}" class="btn btn-sm btn-primary" target="_blank">
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
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-credit-card me-1"></i>
                        Payment Information
                    </div>
                    <span class="badge 
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
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width: 35%">Payment ID:</th>
                                    <td>{{ $payment->payment_id }}</td>
                                </tr>
                                <tr>
                                    <th>Amount:</th>
                                    <td class="fw-bold">₹{{ number_format($payment->payment_amt, 2) }} Cr</td>
                                </tr>
                                <tr>
                                    <th>Payment Date:</th>
                                    <td>{{ $payment->payment_date->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Transaction Reference:</th>
                                    <td>{{ $payment->transaction_reference ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Created On:</th>
                                    <td>{{ $payment->created_at->format('d-m-Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th>Last Updated:</th>
                                    <td>{{ $payment->updated_at->format('d-m-Y h:i A') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    @if($payment->remarks)
                        <div class="mt-3">
                            <h6 class="fw-bold">College Remarks:</h6>
                            <p>{{ $payment->remarks }}</p>
                        </div>
                    @endif
                    
                    @if($payment->admin_remarks)
                        <div class="mt-3">
                            <h6 class="fw-bold">Admin Remarks:</h6>
                            <p>{{ $payment->admin_remarks }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <!-- Bill Details Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-file-earmark-text me-1"></i>
                    Related Bill Information
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th style="width: 35%">Bill Number:</th>
                                    <td>
                                        <a href="{{ route('college.bills.show', $payment->bill->bill_id) }}" class="text-decoration-none">
                                            {{ $payment->bill->bill_no }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Bill Amount:</th>
                                    <td>₹{{ number_format($payment->bill->bill_amt, 2) }} Cr</td>
                                </tr>
                                <tr>
                                    <th>Bill Date:</th>
                                    <td>{{ $payment->bill->bill_date->format('d-m-Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Bill Status:</th>
                                    <td>
                                        <span class="badge 
                                            @if($payment->bill->bill_status == 'pending') bg-warning
                                            @elseif($payment->bill->bill_status == 'approved') bg-success
                                            @elseif($payment->bill->bill_status == 'rejected') bg-danger
                                            @else bg-primary @endif">
                                            {{ ucfirst($payment->bill->bill_status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Funding Source:</th>
                                    <td>{{ $payment->bill->funding->approved_amt }} Cr (Central: {{ $payment->bill->funding->central_share }} Cr, State: {{ $payment->bill->funding->state_share }} Cr)</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Payment Summary -->
                    <div class="mt-4">
                        <h6 class="fw-bold">Payment Summary:</h6>
                        @php
                            $totalPaid = $payment->bill->payments->sum('payment_amt');
                            $remainingAmount = $payment->bill->bill_amt - $totalPaid;
                            $paidPercentage = ($totalPaid / $payment->bill->bill_amt) * 100;
                        @endphp
                        
                        <div class="mt-2">
                            <div class="progress" style="height: 10px;">
                                <div class="progress-bar bg-success" role="progressbar" 
                                    style="width: {{ $paidPercentage }}%;" 
                                    aria-valuenow="{{ $paidPercentage }}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small>Paid: ₹{{ number_format($totalPaid, 2) }} Cr ({{ number_format($paidPercentage, 1) }}%)</small>
                                <small>Remaining: ₹{{ number_format($remainingAmount, 2) }} Cr</small>
                            </div>
                        </div>
                        
                        @if($payment->bill->payments->count() > 1)
                            <div class="table-responsive mt-3">
                                <h6 class="fw-bold">All Payments for this Bill:</h6>
                                <table class="table table-sm table-striped">
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
                                                        class="text-decoration-none">
                                                        {{ $billPayment->payment_id }}
                                                    </a>
                                                </td>
                                                <td>₹{{ number_format($billPayment->payment_amt, 2) }} Cr</td>
                                                <td>{{ $billPayment->payment_date->format('d-m-Y') }}</td>
                                                <td>
                                                    <span class="badge 
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