@extends('admin.layouts.app')

@section('title', 'Record New Payment')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Record New Payment</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
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
            Payment Details
        </div>
        <div class="card-body">
            <form action="{{ route('admin.payments.store') }}" method="POST">
                @csrf
                
                <div class="row mb-3">
                    <label for="bill_id" class="col-md-3 col-form-label">Select Bill</label>
                    <div class="col-md-9">
                        <select class="form-select @error('bill_id') is-invalid @enderror" id="bill_id" name="bill_id" required>
                            <option value="">-- Select Bill --</option>
                            @foreach($bills as $bill)
                                <option value="{{ $bill->bill_id }}" {{ old('bill_id') == $bill->bill_id ? 'selected' : '' }}>
                                    {{ $bill->bill_no }} - {{ $bill->college->college_name }} - ₹{{ number_format($bill->bill_amt, 2) }} Cr
                                </option>
                            @endforeach
                        </select>
                        @error('bill_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="payment_amt" class="col-md-3 col-form-label">Payment Amount (₹ Cr)</label>
                    <div class="col-md-9">
                        <input type="number" class="form-control @error('payment_amt') is-invalid @enderror" 
                            id="payment_amt" name="payment_amt" value="{{ old('payment_amt') }}" 
                            step="0.01" min="0.01" required>
                        @error('payment_amt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Enter the amount in crores (e.g., 1.5 for ₹1.5 Crores)</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="payment_date" class="col-md-3 col-form-label">Payment Date</label>
                    <div class="col-md-9">
                        <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                            id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                        @error('payment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="payment_status" class="col-md-3 col-form-label">Payment Status</label>
                    <div class="col-md-9">
                        <select class="form-select @error('payment_status') is-invalid @enderror" 
                            id="payment_status" name="payment_status" required>
                            <option value="pending" {{ old('payment_status', 'pending') == 'pending' ? 'selected' : '' }}>
                                Pending
                            </option>
                            <option value="completed" {{ old('payment_status', 'pending') == 'completed' ? 'selected' : '' }}>
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
                            id="transaction_reference" name="transaction_reference" value="{{ old('transaction_reference') }}">
                        @error('transaction_reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Enter bank transaction reference number, check number, or other identifier</small>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="remarks" class="col-md-3 col-form-label">Remarks</label>
                    <div class="col-md-9">
                        <textarea class="form-control @error('remarks') is-invalid @enderror" 
                            id="remarks" name="remarks" rows="3">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-1"></i> Record Payment
                        </button>
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary ms-2">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add JavaScript validation as needed
            const form = document.querySelector('form');
            form.addEventListener('submit', function(event) {
                const paymentAmt = document.getElementById('payment_amt').value;
                if (parseFloat(paymentAmt) <= 0) {
                    alert('Payment amount must be greater than zero');
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection 