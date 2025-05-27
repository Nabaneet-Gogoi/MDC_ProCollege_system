@extends('admin.layouts.app')

@section('title', 'Record New Payment')

@section('content')
<style>
    /* Modern Design System for Payment Create */
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
    
    .modern-btn-cancel {
        background: rgba(108, 117, 125, 0.15);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.3);
    }
    
    .modern-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
    }
    
    .modern-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }
    
    .modern-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        border: 1px solid rgba(102, 126, 234, 0.1);
        overflow: hidden;
        margin-bottom: 24px;
    }
    
    .modern-card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 16px 20px;
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
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
        padding: 24px;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    .modern-form-label {
        font-weight: 600;
        font-size: 12px;
        color: #495057;
        margin-bottom: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: block;
    }
    
    .modern-form-label.required::after {
        content: ' *';
        color: #dc3545;
        font-weight: 700;
    }
    
    .modern-form-control, .modern-form-select {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
        width: 100%;
        background: white;
    }
    
    .modern-form-control:focus, .modern-form-select:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
        outline: none;
    }
    
    .modern-form-control.is-invalid, .modern-form-select.is-invalid {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .modern-form-control::placeholder {
        color: #adb5bd;
        font-style: italic;
    }
    
    .form-text-modern {
        font-size: 11px;
        font-weight: 500;
        color: #6c757d;
        margin-top: 6px;
    }
    
    .invalid-feedback {
        font-size: 11px;
        font-weight: 600;
        color: #dc3545;
        margin-top: 6px;
    }
    
    .form-actions {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        padding: 20px;
        margin-top: 24px;
        display: flex;
        gap: 12px;
        align-items: center;
    }
    
    .validation-summary {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, rgba(253, 126, 20, 0.05) 100%);
        border: 1px solid rgba(220, 53, 69, 0.2);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
    }
    
    .validation-summary h6 {
        font-weight: 700;
        font-size: 13px;
        color: #dc3545;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }
    
    .validation-summary ul {
        margin: 0;
        padding-left: 20px;
    }
    
    .validation-summary li {
        font-size: 12px;
        font-weight: 500;
        color: #dc3545;
        margin-bottom: 4px;
    }
    
    .loading-state {
        opacity: 0.7;
        pointer-events: none;
    }
    
    .loading-spinner {
        width: 16px;
        height: 16px;
        border: 2px solid transparent;
        border-top: 2px solid currentColor;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-right: 6px;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
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
        
        .form-actions {
            flex-direction: column;
            align-items: stretch;
        }
    }
</style>

<!-- Modern Header -->
<div class="modern-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1><i class="bi bi-plus-circle me-2"></i>Record New Payment</h1>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.payments.index') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Payments
            </a>
        </div>
    </div>
</div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="border-radius: 12px; border: 1px solid rgba(220, 53, 69, 0.2);">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="validation-summary">
        <h6><i class="bi bi-exclamation-triangle me-2"></i>Please correct the following errors</h6>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="modern-card">
    <div class="modern-card-header">
        <h5><i class="bi bi-credit-card me-2"></i>Payment Details</h5>
    </div>
    <div class="modern-card-body">
        <form action="{{ route('admin.payments.store') }}" method="POST" id="paymentForm">
            @csrf
            
            <div class="form-group">
                <label for="bill_id" class="modern-form-label required">Select Bill</label>
                <select class="modern-form-select @error('bill_id') is-invalid @enderror" id="bill_id" name="bill_id" required>
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
                <small class="form-text-modern">Select the bill for which you want to record a payment</small>
            </div>
            
            <div class="form-group">
                <label for="payment_amt" class="modern-form-label required">Payment Amount (₹ Cr)</label>
                <input type="number" class="modern-form-control @error('payment_amt') is-invalid @enderror" 
                    id="payment_amt" name="payment_amt" value="{{ old('payment_amt') }}" 
                    step="0.01" min="0.01" required
                    placeholder="e.g., 1.50">
                @error('payment_amt')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text-modern">Enter the amount in crores (e.g., 1.5 for ₹1.5 Crores)</small>
            </div>
            
            <div class="form-group">
                <label for="payment_date" class="modern-form-label required">Payment Date</label>
                <input type="date" class="modern-form-control @error('payment_date') is-invalid @enderror" 
                    id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                @error('payment_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text-modern">Date when the payment was made</small>
            </div>
            
            <div class="form-group">
                <label for="payment_status" class="modern-form-label required">Payment Status</label>
                <select class="modern-form-select @error('payment_status') is-invalid @enderror" 
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
                <small class="form-text-modern">Current status of the payment</small>
            </div>
            
            <div class="form-group">
                <label for="transaction_reference" class="modern-form-label">Transaction Reference</label>
                <input type="text" class="modern-form-control @error('transaction_reference') is-invalid @enderror" 
                    id="transaction_reference" name="transaction_reference" value="{{ old('transaction_reference') }}"
                    placeholder="Enter reference number, check number, etc.">
                @error('transaction_reference')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text-modern">Enter bank transaction reference number, check number, or other identifier</small>
            </div>
            
            <div class="form-group">
                <label for="admin_remarks" class="modern-form-label">Admin Remarks</label>
                <textarea class="modern-form-control @error('admin_remarks') is-invalid @enderror" 
                    id="admin_remarks" name="admin_remarks" rows="3" 
                    placeholder="Enter any administrative notes or remarks">{{ old('admin_remarks') }}</textarea>
                @error('admin_remarks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text-modern">Optional administrative notes about this payment</small>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                    <i class="bi bi-check-circle"></i> Record Payment
                </button>
                <a href="{{ route('admin.payments.index') }}" class="modern-btn modern-btn-cancel">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const submitBtn = document.getElementById('submitBtn');
    const paymentAmtInput = document.getElementById('payment_amt');
    
    // Form submission handling with loading state
    form.addEventListener('submit', function(event) {
        // Validate payment amount
        const paymentAmt = parseFloat(paymentAmtInput.value);
        if (paymentAmt <= 0) {
            alert('Payment amount must be greater than zero');
            event.preventDefault();
            return;
        }
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<span class="loading-spinner"></span>Recording Payment...';
        form.classList.add('loading-state');
    });
    
    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
    
    // Enhanced form validation feedback
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(function(input) {
        input.addEventListener('blur', function() {
            if (this.hasAttribute('required') && !this.value.trim()) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid') && this.value.trim()) {
                this.classList.remove('is-invalid');
            }
        });
    });
    
    // Payment amount formatting
    paymentAmtInput.addEventListener('blur', function() {
        if (this.value) {
            const value = parseFloat(this.value);
            if (!isNaN(value)) {
                this.value = value.toFixed(2);
            }
        }
    });
});
</script>
@endsection 