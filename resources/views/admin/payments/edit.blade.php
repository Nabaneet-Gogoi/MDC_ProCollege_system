@extends('admin.layouts.app')

@section('title', 'Edit Payment')

@section('content')
<style>
    /* Modern Design System for Payment Edit */
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
    
    .form-control-plaintext-modern {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 500;
        color: #2c3e50;
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
    
    .readonly-field {
        background: linear-gradient(135deg, rgba(168, 237, 234, 0.1) 0%, rgba(254, 214, 227, 0.1) 100%);
        border: 1px solid rgba(168, 237, 234, 0.2);
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 13px;
        font-weight: 500;
        color: #495057;
        resize: none;
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
        <h1><i class="bi bi-pencil me-2"></i>Edit Payment</h1>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.payments.show', $payment->payment_id) }}" class="modern-btn modern-btn-primary">
                <i class="bi bi-eye"></i> View Details
            </a>
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

<div class="modern-card">
    <div class="modern-card-header">
        <h5><i class="bi bi-credit-card me-2"></i>Payment #{{ $payment->payment_id }} for Bill #{{ $payment->bill->bill_no }}</h5>
    </div>
    <div class="modern-card-body">
        <form action="{{ route('admin.payments.update', $payment->payment_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="modern-form-label">Bill Information</label>
                <div class="form-control-plaintext-modern">
                    <strong>Bill #{{ $payment->bill->bill_no }}</strong> - {{ $payment->bill->college->college_name }} - 
                    <span style="color: #667eea; font-weight: 700;">₹{{ number_format($payment->bill->bill_amt, 2) }} Cr</span>
                </div>
            </div>
            
            <div class="form-group">
                <label class="modern-form-label">Payment Amount</label>
                <div class="form-control-plaintext-modern">
                    <span style="color: #667eea; font-weight: 700; font-size: 15px;">₹{{ number_format($payment->payment_amt, 2) }} Cr</span>
                </div>
                <small class="form-text-modern">Payment amount cannot be changed after creation</small>
            </div>
            
            <div class="form-group">
                <label class="modern-form-label">Payment Date</label>
                <div class="form-control-plaintext-modern">
                    {{ $payment->payment_date->format('d-m-Y') }}
                </div>
            </div>
            
            <div class="form-group">
                <label for="payment_status" class="modern-form-label">Payment Status</label>
                <select class="modern-form-select @error('payment_status') is-invalid @enderror" 
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
            
            <div class="form-group">
                <label for="transaction_reference" class="modern-form-label">Transaction Reference</label>
                <input type="text" class="modern-form-control @error('transaction_reference') is-invalid @enderror" 
                    id="transaction_reference" name="transaction_reference" 
                    value="{{ old('transaction_reference', $payment->transaction_reference) }}"
                    placeholder="Enter transaction reference number">
                @error('transaction_reference')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text-modern">Enter bank transaction reference number, check number, or other identifier</small>
            </div>
            
            <div class="form-group">
                <label for="remarks" class="modern-form-label">College Remarks</label>
                <textarea class="readonly-field" id="remarks" rows="2" readonly>{{ $payment->remarks }}</textarea>
                <small class="form-text-modern">College remarks cannot be edited by administrators</small>
            </div>
            
            <div class="form-group">
                <label for="admin_remarks" class="modern-form-label">Admin Remarks</label>
                <textarea class="modern-form-control @error('admin_remarks') is-invalid @enderror" 
                    id="admin_remarks" name="admin_remarks" rows="3" 
                    placeholder="Enter administrative remarks or notes">{{ old('admin_remarks', $payment->admin_remarks) }}</textarea>
                @error('admin_remarks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-actions">
                <button type="submit" class="modern-btn modern-btn-primary">
                    <i class="bi bi-save"></i> Update Payment
                </button>
                <a href="{{ route('admin.payments.show', $payment->payment_id) }}" class="modern-btn modern-btn-cancel">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection 