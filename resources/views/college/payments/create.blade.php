@extends('college.layouts.app')

@section('title', 'Record New Payment')

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

.btn-modern.btn-success {
    background: var(--success-gradient);
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.btn-modern.btn-outline-secondary {
    background: transparent;
    border: 2px solid #6b7280;
    color: #6b7280;
    box-shadow: none;
}

.btn-modern.btn-outline-secondary:hover {
    background: #6b7280;
    color: white;
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
    padding: 20px;
}

/* Enhanced Form Design */
.modern-form .row {
    margin-bottom: 16px;
}

.modern-form .col-form-label {
    font-weight: 600;
    color: #374151;
    font-size: 0.9rem;
    padding-top: 8px;
    padding-bottom: 8px;
}

.modern-form .form-control,
.modern-form .form-select {
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    padding: 10px 12px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
    background: #ffffff;
}

.modern-form .form-control:focus,
.modern-form .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: #ffffff;
}

.modern-form .form-control.is-invalid,
.modern-form .form-select.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

.modern-form .invalid-feedback {
    font-size: 0.8rem;
    font-weight: 500;
    margin-top: 4px;
}

.modern-form .form-text {
    font-size: 0.8rem;
    color: #6b7280;
    margin-top: 4px;
}

/* Enhanced Alert */
.alert-info-modern {
    background: linear-gradient(135deg, rgba(8, 145, 178, 0.1), rgba(34, 211, 238, 0.1));
    border: 1px solid rgba(8, 145, 178, 0.2);
    border-radius: 8px;
    color: #155e75;
    padding: 12px 16px;
    margin-bottom: 20px;
}

.alert-info-modern i {
    color: #0891b2;
}

/* Enhanced Buttons */
.btn-enhanced {
    padding: 10px 20px;
    font-weight: 600;
    border-radius: 8px;
    transition: all 0.2s ease;
    font-size: 0.9rem;
}

.btn-enhanced.btn-success {
    background: var(--success-gradient);
    border: none;
    color: white;
    box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
}

.btn-enhanced.btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 16px rgba(5, 150, 105, 0.4);
    color: white;
}

.btn-enhanced.btn-outline-secondary {
    border: 2px solid #6b7280;
    color: #6b7280;
    background: transparent;
}

.btn-enhanced.btn-outline-secondary:hover {
    background: #6b7280;
    color: white;
    transform: translateY(-1px);
}

/* Form Animations */
.modern-form .form-control:focus,
.modern-form .form-select:focus {
    animation: formFocus 0.2s ease;
}

@keyframes formFocus {
    0% { transform: scale(1); }
    50% { transform: scale(1.01); }
    100% { transform: scale(1); }
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
    
    .modern-card .card-body {
        padding: 16px;
    }
    
    .modern-form .col-form-label {
        font-size: 0.85rem;
        margin-bottom: 6px;
    }
    
    .modern-form .form-control,
    .modern-form .form-select {
        font-size: 0.85rem;
        padding: 8px 10px;
    }
    
    .btn-enhanced {
        font-size: 0.85rem;
        padding: 8px 16px;
    }
}

/* Loading State */
.btn-loading {
    position: relative;
    pointer-events: none;
}

.btn-loading::after {
    content: "";
    position: absolute;
    width: 16px;
    height: 16px;
    margin: auto;
    border: 2px solid transparent;
    border-top-color: #ffffff;
    border-radius: 50%;
    animation: button-loading-spinner 1s ease infinite;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
}

@keyframes button-loading-spinner {
    from { transform: rotate(0turn); }
    to { transform: rotate(1turn); }
}
</style>
@endsection

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom modern-header">
        <h1 class="h2">Record New Payment</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.payments.index') }}" class="btn btn-sm btn-secondary btn-modern">
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

    <div class="modern-card">
        <div class="card-header">
            <i class="bi bi-credit-card me-1"></i>
            Payment Details
        </div>
        <div class="card-body">
            <form action="{{ route('college.payments.store') }}" method="POST" class="modern-form" id="paymentForm">
                @csrf
                
                <div class="row">
                    <label for="bill_id" class="col-md-3 col-form-label">
                        <i class="bi bi-file-earmark-text me-1"></i>Select Bill
                    </label>
                    <div class="col-md-9">
                        <select class="form-select @error('bill_id') is-invalid @enderror" id="bill_id" name="bill_id" required>
                            <option value="">-- Select Bill --</option>
                            @foreach($bills as $bill)
                                <option value="{{ $bill->bill_id }}" {{ old('bill_id') == $bill->bill_id ? 'selected' : '' }}>
                                    {{ $bill->bill_no }} - ₹{{ number_format($bill->bill_amt, 2) }} Cr
                                </option>
                            @endforeach
                        </select>
                        @error('bill_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <label for="payment_amt" class="col-md-3 col-form-label">
                        <i class="bi bi-currency-rupee me-1"></i>Payment Amount (₹ Cr)
                    </label>
                    <div class="col-md-9">
                        <input type="number" class="form-control @error('payment_amt') is-invalid @enderror" 
                            id="payment_amt" name="payment_amt" value="{{ old('payment_amt') }}" 
                            step="0.01" min="0.01" placeholder="e.g., 1.50" required>
                        @error('payment_amt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Enter the amount in crores (e.g., 1.5 for ₹1.5 Crores)</small>
                    </div>
                </div>
                
                <div class="row">
                    <label for="payment_date" class="col-md-3 col-form-label">
                        <i class="bi bi-calendar-date me-1"></i>Payment Date
                    </label>
                    <div class="col-md-9">
                        <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                            id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                        @error('payment_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row">
                    <label for="transaction_reference" class="col-md-3 col-form-label">
                        <i class="bi bi-hash me-1"></i>Transaction Reference
                    </label>
                    <div class="col-md-9">
                        <input type="text" class="form-control @error('transaction_reference') is-invalid @enderror" 
                            id="transaction_reference" name="transaction_reference" value="{{ old('transaction_reference') }}"
                            placeholder="Enter transaction reference or check number">
                        @error('transaction_reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Enter bank transaction reference number, check number, or other identifier</small>
                    </div>
                </div>
                
                <div class="row">
                    <label for="remarks" class="col-md-3 col-form-label">
                        <i class="bi bi-chat-text me-1"></i>College Remarks
                    </label>
                    <div class="col-md-9">
                        <textarea class="form-control @error('remarks') is-invalid @enderror" 
                            id="remarks" name="remarks" rows="3" placeholder="Add your notes or comments regarding this payment">{{ old('remarks') }}</textarea>
                        @error('remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Add your notes or comments regarding this payment</small>
                    </div>
                </div>
                
                <div class="alert alert-info-modern">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Important:</strong> Payment records created by college users must be verified by administrators. Initially, all payments will have a "Pending" status and require admin approval.
                </div>
                
                <div class="row">
                    <div class="col-md-9 offset-md-3">
                        <button type="submit" class="btn btn-success btn-enhanced me-3" id="submitBtn">
                            <i class="bi bi-check-circle me-1"></i> Record Payment
                        </button>
                        <a href="{{ route('college.payments.index') }}" class="btn btn-outline-secondary btn-enhanced">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('paymentForm');
    const submitBtn = document.getElementById('submitBtn');
    const paymentAmtInput = document.getElementById('payment_amt');
    const billSelect = document.getElementById('bill_id');
    
    // Enhanced form validation
    form.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Validate payment amount
        const paymentAmt = parseFloat(paymentAmtInput.value);
        if (isNaN(paymentAmt) || paymentAmt <= 0) {
            isValid = false;
            showFieldError(paymentAmtInput, 'Payment amount must be greater than zero');
        } else {
            clearFieldError(paymentAmtInput);
        }
        
        // Validate bill selection
        if (!billSelect.value) {
            isValid = false;
            showFieldError(billSelect, 'Please select a bill');
        } else {
            clearFieldError(billSelect);
        }
        
        if (!isValid) {
            event.preventDefault();
        } else {
            // Add loading state to submit button
            submitBtn.classList.add('btn-loading');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="me-2">Recording Payment...</span>';
        }
    });
    
    // Real-time validation for payment amount
    paymentAmtInput.addEventListener('input', function() {
        const value = parseFloat(this.value);
        if (!isNaN(value) && value > 0) {
            clearFieldError(this);
        }
    });
    
    // Bill selection change handler
    billSelect.addEventListener('change', function() {
        if (this.value) {
            clearFieldError(this);
        }
    });
    
    // Helper functions
    function showFieldError(field, message) {
        field.classList.add('is-invalid');
        
        // Remove existing error message
        const existingError = field.parentNode.querySelector('.custom-invalid-feedback');
        if (existingError) {
            existingError.remove();
        }
        
        // Add new error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback custom-invalid-feedback';
        errorDiv.textContent = message;
        field.parentNode.appendChild(errorDiv);
    }
    
    function clearFieldError(field) {
        field.classList.remove('is-invalid');
        const errorDiv = field.parentNode.querySelector('.custom-invalid-feedback');
        if (errorDiv) {
            errorDiv.remove();
        }
    }
    
    // Auto-format currency input
    paymentAmtInput.addEventListener('blur', function() {
        const value = parseFloat(this.value);
        if (!isNaN(value) && value > 0) {
            this.value = value.toFixed(2);
        }
    });
    
    // Set max date to today for payment date
    const paymentDateInput = document.getElementById('payment_date');
    const today = new Date().toISOString().split('T')[0];
    paymentDateInput.setAttribute('max', today);
});
</script>
@endsection 