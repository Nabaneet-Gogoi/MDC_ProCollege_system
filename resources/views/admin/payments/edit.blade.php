@extends('admin.layouts.app')

@section('title', 'Edit Payment')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Payment</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.payments.show', $payment->payment_id) }}" class="btn btn-sm btn-info me-2">
                <i class="bi bi-eye"></i> View Details
            </a>
            <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Payments
            </a>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="bi bi-credit-card me-1"></i>
            Payment #{{ $payment->payment_id }} for Bill #{{ $payment->bill->bill_no }}
        </div>
        <div class="card-body">
            <form action="{{ route('admin.payments.update', $payment->payment_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-bold">Bill Information</label>
                    <div class="col-md-9">
                        <p class="form-control-plaintext">
                            Bill #{{ $payment->bill->bill_no }} - {{ $payment->bill->college->college_name }} - 
                            ₹{{ number_format($payment->bill->bill_amt, 2) }} Cr
                        </p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-bold">Payment Amount</label>
                    <div class="col-md-9">
                        <p class="form-control-plaintext">₹{{ number_format($payment->payment_amt, 2) }} Cr</p>
                        <small class="form-text text-muted">Payment amount cannot be changed after creation</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-md-3 col-form-label fw-bold">Payment Date</label>
                    <div class="col-md-9">
                        <p class="form-control-plaintext">{{ $payment->payment_date->format('d-m-Y') }}</p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="payment_status" class="col-md-3 col-form-label">Payment Status</label>
                    <div class="col-md-9">
                        <select class="form-select @error('payment_status') is-invalid @enderror" 
                            id="payment_status" name="payment_status" required>
                            <option value="pending" {{ old('payment_status', $payment->payment_status) == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="completed" {{ old('payment_status', $payment->payment_status) == 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>
                        </select>
                        @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="transaction_reference" class="col-md-3 col-form-label">Transaction Reference</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control @error('transaction_reference') is-invalid @enderror" 
                            id="transaction_reference" name="transaction_reference" 
                            value="{{ old('transaction_reference', $payment->transaction_reference) }}">
                        @error('transaction_reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Enter bank transaction reference number, check number, or other identifier</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="remarks" class="col-md-3 col-form-label">College Remarks</label>
                    <div class="col-md-9">
                        <textarea class="form-control" id="remarks" rows="2" readonly>{{ $payment->remarks }}</textarea>
                        <small class="form-text text-muted">College remarks cannot be edited by administrators</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="admin_remarks" class="col-md-3 col-form-label">Admin Remarks</label>
                    <div class="col-md-9">
                        <textarea class="form-control @error('admin_remarks') is-invalid @enderror" 
                            id="admin_remarks" name="admin_remarks" rows="3">{{ old('admin_remarks', $payment->admin_remarks) }}</textarea>
                        @error('admin_remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i> Update Payment
                        </button>
                        <a href="{{ route('admin.payments.show', $payment->payment_id) }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection 