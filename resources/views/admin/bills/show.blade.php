@extends('admin.layouts.app')

@section('title', 'Bill Details')

@section('content')
<style>
    /* Modern Design System for Bill Details */
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
    }
    
    .modern-card-header.primary {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .modern-card-header h5 {
        font-weight: 700;
        font-size: 13px;
        margin: 0;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .modern-card-header.primary h5 {
        color: white;
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
        min-width: 120px;
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
    
    .modern-badge.status-approved {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .modern-badge.status-rejected {
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        color: white;
    }
    
    .modern-badge.status-paid {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
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
    
    .form-text-modern {
        font-size: 11px;
        font-weight: 500;
        color: #6c757d;
        margin-top: 6px;
    }
    
    .modern-table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
    
    .modern-table tbody td {
        padding: 12px;
        font-size: 13px;
        font-weight: 500;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .progress-modern {
        height: 8px;
        border-radius: 4px;
        background: rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 4px;
    }
    
    .progress-modern .progress-bar {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-radius: 4px;
        transition: width 0.6s ease;
    }
    
    .progress-modern.large {
        height: 12px;
        margin-bottom: 8px;
    }
    
    .summary-card {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        padding: 16px 20px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.1);
    }
    
    .summary-card h5 {
        font-weight: 700;
        font-size: 1.2rem;
        margin: 0;
        color: #2c3e50;
    }
    
    .summary-card.success h5 {
        color: #28a745;
    }
    
    .summary-card.primary h5 {
        color: #4facfe;
    }
    
    .summary-card.secondary h5 {
        color: #6c757d;
    }
    
    .summary-card small {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #6c757d;
    }
    
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 16px;
    }
    
    .action-section {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
        border: 1px solid rgba(102, 126, 234, 0.08);
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 16px;
    }
    
    .action-section-title {
        font-weight: 700;
        font-size: 14px;
        color: #495057;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .action-section-title i {
        width: 24px;
        height: 24px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }
    
    .quick-action-btn {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 1px solid rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        padding: 16px 20px;
        text-decoration: none;
        color: #495057;
        font-weight: 600;
        font-size: 13px;
        text-align: center;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
        position: relative;
        overflow: hidden;
        width: 100%;
        margin-bottom: 12px;
    }
    
    .quick-action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s ease;
    }
    
    .quick-action-btn:hover::before {
        left: 100%;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(102, 126, 234, 0.15);
        color: #495057;
    }
    
    .quick-action-btn .icon-wrapper {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 4px;
        transition: all 0.3s ease;
    }
    
    .quick-action-btn .action-text {
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        line-height: 1.2;
    }
    
    .quick-action-btn .action-description {
        font-weight: 500;
        font-size: 11px;
        opacity: 0.8;
        margin-top: 4px;
        line-height: 1.3;
    }
    
    .quick-action-btn.success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }
    
    .quick-action-btn.success .icon-wrapper {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .quick-action-btn.success:hover {
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
        color: white;
    }
    
    .quick-action-btn.danger {
        background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
    }
    
    .quick-action-btn.danger .icon-wrapper {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .quick-action-btn.danger:hover {
        box-shadow: 0 6px 20px rgba(220, 53, 69, 0.4);
        color: white;
    }
    
    .quick-action-btn.primary {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.3);
    }
    
    .quick-action-btn.primary .icon-wrapper {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .quick-action-btn.primary:hover {
        box-shadow: 0 6px 20px rgba(79, 172, 254, 0.4);
        color: white;
    }
    
    .quick-action-btn.info {
        background: linear-gradient(135deg, #17a2b8 0%, #20c997 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    }
    
    .quick-action-btn.info .icon-wrapper {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .quick-action-btn.info:hover {
        box-shadow: 0 6px 20px rgba(23, 162, 184, 0.4);
        color: white;
    }
    
    .quick-action-btn.secondary {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }
    
    .quick-action-btn.secondary .icon-wrapper {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }
    
    .quick-action-btn.secondary:hover {
        box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
        color: white;
    }
    
    .action-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
    }
    
    .bill-image {
        border-radius: 12px;
        max-height: 150px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .bill-image:hover {
        transform: scale(1.05);
        box-shadow: 0 6px 24px rgba(102, 126, 234, 0.15);
    }
    
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #6c757d;
    }
    
    .empty-state .display-4 {
        font-size: 3rem;
        margin-bottom: 16px;
    }
    
    .empty-state p {
        font-size: 13px;
        font-weight: 500;
        margin-bottom: 20px;
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
        
        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<!-- Modern Header -->
<div class="modern-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1><i class="bi bi-file-earmark-text me-2"></i>Bill Details: {{ $bill->bill_no }}</h1>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.bills.index') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Bills
            </a>
            <a href="{{ route('bills.print', $bill->bill_id) }}" class="modern-btn modern-btn-primary" target="_blank">
                <i class="bi bi-printer"></i> Print Bill
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

<!-- Status Update Card -->
<div class="modern-card">
    <div class="modern-card-header primary">
        <h5><i class="bi bi-gear me-2"></i>Update Bill Status</h5>
    </div>
    <div class="modern-card-body">
        <form action="{{ route('admin.bills.update', $bill->bill_id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="bill_status" class="modern-form-label required">Bill Status</label>
                    <select class="modern-form-select @error('bill_status') is-invalid @enderror" id="bill_status" name="bill_status" required>
                        @foreach(App\Models\Bill::getStatusOptions() as $value => $label)
                            <option value="{{ $value }}" {{ old('bill_status', $bill->bill_status) == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('bill_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-8 mb-3">
                    <label for="admin_remarks" class="modern-form-label">Administrative Remarks</label>
                    <textarea class="modern-form-control @error('admin_remarks') is-invalid @enderror" id="admin_remarks" 
                        name="admin_remarks" rows="2" placeholder="Add any remarks or feedback on this bill">{{ old('admin_remarks', $bill->admin_remarks) }}</textarea>
                    @error('admin_remarks')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="form-text-modern">Add any remarks or feedback on this bill that will be visible to the college.</small>
                </div>
            </div>
            
            <div class="d-flex justify-content-end">
                <button type="submit" class="modern-btn modern-btn-primary">
                    <i class="bi bi-save"></i> Update Status
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <!-- Bill Information Card -->
    <div class="col-md-6 mb-4">
        <div class="modern-card h-100">
            <div class="modern-card-header">
                <h5><i class="bi bi-file-earmark-text me-2"></i>Bill Information</h5>
            </div>
            <div class="modern-card-body">
                <div class="info-item">
                    <div class="info-label">Bill Number</div>
                    <p class="info-value">{{ $bill->bill_no }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Bill Amount</div>
                    <p class="info-value amount">₹ {{ number_format($bill->bill_amt, 2) }} Crores</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Bill Date</div>
                    <p class="info-value">{{ $bill->bill_date->format('d-m-Y') }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Status</div>
                    <p class="info-value">
                        <span class="modern-badge status-{{ $bill->bill_status }}">
                            <i class="bi bi-{{ $bill->bill_status == 'pending' ? 'clock' : ($bill->bill_status == 'approved' ? 'check-circle' : ($bill->bill_status == 'paid' ? 'credit-card' : 'x-circle')) }}"></i>
                            {{ ucfirst($bill->bill_status) }}
                        </span>
                    </p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Submission Date</div>
                    <p class="info-value">{{ $bill->created_at->format('d-m-Y H:i') }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Submitted By</div>
                    <p class="info-value">{{ $bill->user->username }}</p>
                </div>
                
                @if($bill->description)
                    <div style="background: linear-gradient(135deg, rgba(168, 237, 234, 0.1) 0%, rgba(254, 214, 227, 0.1) 100%); border: 1px solid rgba(168, 237, 234, 0.2); border-radius: 12px; padding: 16px 20px; margin-top: 16px;">
                        <h6 style="font-weight: 700; font-size: 13px; color: #495057; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Description</h6>
                        <p style="font-size: 13px; font-weight: 500; margin: 0; color: #2c3e50; line-height: 1.5;">{{ $bill->description }}</p>
                    </div>
                @endif
                
                @if($bill->bill_image)
                    <div style="background: linear-gradient(135deg, rgba(168, 237, 234, 0.1) 0%, rgba(254, 214, 227, 0.1) 100%); border: 1px solid rgba(168, 237, 234, 0.2); border-radius: 12px; padding: 16px 20px; margin-top: 16px;">
                        <h6 style="font-weight: 700; font-size: 13px; color: #495057; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px;">Bill Image</h6>
                        <a href="{{ asset('storage/' . $bill->bill_image) }}" target="_blank" class="d-block">
                            <img src="{{ asset('storage/' . $bill->bill_image) }}" alt="Bill Image" class="bill-image">
                            <small class="d-block mt-2" style="color: #667eea; font-weight: 600; font-size: 11px;">Click to view full image</small>
                        </a>
                    </div>
                @endif
                
                @if($bill->admin_remarks)
                    <div style="background: linear-gradient(135deg, rgba(168, 237, 234, 0.1) 0%, rgba(254, 214, 227, 0.1) 100%); border: 1px solid rgba(168, 237, 234, 0.2); border-radius: 12px; padding: 16px 20px; margin-top: 16px;">
                        <h6 style="font-weight: 700; font-size: 13px; color: #495057; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;">Admin Remarks</h6>
                        <p style="font-size: 13px; font-weight: 500; margin: 0; color: #2c3e50; line-height: 1.5;">{{ $bill->admin_remarks }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Project Information Card -->
    <div class="col-md-6 mb-4">
        <div class="modern-card h-100">
            <div class="modern-card-header">
                <h5><i class="bi bi-building me-2"></i>College Information</h5>
            </div>
            <div class="modern-card-body">
                <div class="info-item">
                    <div class="info-label">College</div>
                    <p class="info-value">{{ $bill->college->college_name }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Type</div>
                    <p class="info-value">
                        @if($bill->college->type === 'professional')
                            Professional College
                        @else
                            Model Degree College (MDC)
                        @endif
                    </p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Phase</div>
                    <p class="info-value">Phase {{ $bill->college->phase }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">District</div>
                    <p class="info-value">{{ $bill->college->district }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">State</div>
                    <p class="info-value">{{ $bill->college->state }}</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Total Funding</div>
                    <p class="info-value amount">₹ {{ number_format($bill->funding->approved_amt, 2) }} Crores</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">Central Share</div>
                    <p class="info-value amount">₹ {{ number_format($bill->funding->central_share, 2) }} Crores</p>
                </div>
                
                <div class="info-item">
                    <div class="info-label">State Share</div>
                    <p class="info-value amount">₹ {{ number_format($bill->funding->state_share, 2) }} Crores</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Physical Progress Section -->
<div class="modern-card">
    <div class="modern-card-header">
        <h5><i class="bi bi-graph-up me-2"></i>Physical Progress Details</h5>
    </div>
    <div class="modern-card-body">
        @if($bill->progress->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table mb-0">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Completion</th>
                            <th>Status</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bill->progress as $progress)
                            <tr>
                                <td><strong>{{ $progress->category->category_name }}</strong></td>
                                <td>
                                    <div class="progress-modern">
                                        <div class="progress-bar" role="progressbar" 
                                            style="width: {{ $progress->completion_percent }}%;" 
                                            aria-valuenow="{{ $progress->completion_percent }}" 
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small style="font-size: 11px; font-weight: 600;">{{ number_format($progress->completion_percent, 0) }}% Complete</small>
                                </td>
                                <td>
                                    <span class="modern-badge status-{{ $progress->progress_status == 'completed' ? 'approved' : ($progress->progress_status == 'in_progress' ? 'pending' : 'rejected') }}">
                                        {{ str_replace('_', ' ', ucfirst($progress->progress_status)) }}
                                    </span>
                                </td>
                                <td>{{ $progress->description ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Overall Progress Summary -->
            <div class="modern-card mt-4" style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.05) 0%, rgba(32, 201, 151, 0.05) 100%); border: 1px solid rgba(40, 167, 69, 0.1);">
                <div class="modern-card-header" style="background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(32, 201, 151, 0.1) 100%);">
                    <h5><i class="bi bi-bar-chart-line me-2"></i>Overall Progress Summary</h5>
                </div>
                <div class="modern-card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @php
                                $avgProgress = $bill->progress->avg('completion_percent') ?? 0;
                                $completedItems = $bill->progress->where('progress_status', 'completed')->count();
                                $inProgressItems = $bill->progress->where('progress_status', 'in_progress')->count();
                                $notStartedItems = $bill->progress->where('progress_status', 'not_started')->count();
                                $totalItems = $bill->progress->count();
                            @endphp
                            
                            <h5 style="font-weight: 700; margin-bottom: 16px; color: #2c3e50;">Average Completion: {{ number_format($avgProgress, 0) }}%</h5>
                            <div class="progress-modern large">
                                <div class="progress-bar" role="progressbar" 
                                    style="width: {{ $avgProgress }}%;" 
                                    aria-valuenow="{{ $avgProgress }}" 
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="summary-card success">
                                        <h5>{{ $completedItems }}</h5>
                                        <small>Completed Tasks</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="summary-card primary">
                                        <h5>{{ $inProgressItems }}</h5>
                                        <small>In Progress Tasks</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="summary-card secondary">
                                        <h5>{{ $notStartedItems }}</h5>
                                        <small>Not Started Tasks</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="empty-state">
                <i class="bi bi-exclamation-circle display-4"></i>
                <p>No progress information available for this bill.</p>
            </div>
        @endif
    </div>
</div>

<!-- Quick Actions -->
<div class="modern-card">
    <div class="modern-card-header">
        <h5><i class="bi bi-lightning-charge me-2"></i>Quick Actions</h5>
    </div>
    <div class="modern-card-body">
        @if($bill->bill_status === 'pending')
            <div class="action-section">
                <div class="action-section-title">
                    <i class="bi bi-gear"></i>
                    Status Management
                </div>
                <div class="action-grid">
                    <form action="{{ route('admin.bills.updateStatus', $bill->bill_id) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="quick-action-btn success" 
                            onclick="return confirm('Are you sure you want to approve this bill?');">
                            <div class="icon-wrapper">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="action-text">Approve Bill</div>
                            <div class="action-description">Mark this bill as approved and ready for payment processing</div>
                        </button>
                    </form>
                    
                    <form action="{{ route('admin.bills.updateStatus', $bill->bill_id) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="rejected">
                        <button type="submit" class="quick-action-btn danger"
                            onclick="return confirm('Are you sure you want to reject this bill?');">
                            <div class="icon-wrapper">
                                <i class="bi bi-x-circle"></i>
                            </div>
                            <div class="action-text">Reject Bill</div>
                            <div class="action-description">Reject this bill and send it back for corrections</div>
                        </button>
                    </form>
                </div>
            </div>
        @endif
        
        @if($bill->bill_status === 'approved')
            <div class="action-section">
                <div class="action-section-title">
                    <i class="bi bi-credit-card"></i>
                    Payment Processing
                </div>
                <div class="action-grid">
                    <form action="{{ route('admin.bills.updateStatus', $bill->bill_id) }}" method="POST" style="margin: 0;">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="status" value="paid">
                        <button type="submit" class="quick-action-btn primary"
                            onclick="return confirm('Are you sure you want to mark this bill as paid?');">
                            <div class="icon-wrapper">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <div class="action-text">Mark as Paid</div>
                            <div class="action-description">Confirm that payment has been processed for this bill</div>
                        </button>
                    </form>
                </div>
            </div>
        @endif
        
        <div class="action-section">
            <div class="action-section-title">
                <i class="bi bi-eye"></i>
                Related Information
            </div>
            <div class="action-grid">
                <a href="{{ route('admin.colleges.show', $bill->college_id) }}" class="quick-action-btn info">
                    <div class="icon-wrapper">
                        <i class="bi bi-building"></i>
                    </div>
                    <div class="action-text">College Details</div>
                    <div class="action-description">View complete information about {{ $bill->college->college_name }}</div>
                </a>
                
                <a href="{{ route('admin.fundings.show', $bill->funding_id) }}" class="quick-action-btn secondary">
                    <div class="icon-wrapper">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="action-text">Funding Details</div>
                    <div class="action-description">Review funding allocation and disbursement information</div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 