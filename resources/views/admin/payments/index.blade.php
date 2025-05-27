@extends('admin.layouts.app')

@section('title', 'Manage Payments')

@section('content')
<style>
    /* Modern Design System for Payments */
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
    
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        border: 1px solid rgba(102, 126, 234, 0.1);
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(102, 126, 234, 0.15);
    }
    
    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
    }
    
    .stat-icon.pending {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    }
    
    .stat-icon.completed {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }
    
    .stat-icon.total {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stat-content h3 {
        font-weight: 700;
        font-size: 1.5rem;
        margin: 0;
        color: #2c3e50;
    }
    
    .stat-content p {
        font-weight: 500;
        font-size: 11px;
        margin: 0;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
        padding: 20px;
    }
    
    .modern-form-control, .modern-form-select {
        border-radius: 10px;
        border: 1px solid #dee2e6;
        padding: 8px 12px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    
    .modern-form-control:focus, .modern-form-select:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
    }
    
    .modern-form-label {
        font-weight: 600;
        font-size: 12px;
        color: #495057;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
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
        padding: 16px 12px;
        border: none;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
    }
    
    .modern-table tbody tr:hover {
        background: rgba(102, 126, 234, 0.05);
        transform: scale(1.01);
    }
    
    .modern-table tbody td {
        padding: 12px;
        font-size: 13px;
        font-weight: 500;
        vertical-align: middle;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    .modern-badge {
        padding: 4px 8px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .modern-badge.status-pending {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
        color: white;
    }
    
    .modern-badge.status-completed {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        color: white;
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        transition: all 0.3s ease;
        margin: 0 2px;
    }
    
    .btn-action:hover {
        transform: translateY(-1px);
    }
    
    .btn-action.btn-info {
        background: #17a2b8;
        color: white;
    }
    
    .btn-action.btn-success {
        background: #28a745;
        color: white;
    }
    
    .btn-action.btn-primary {
        background: #007bff;
        color: white;
    }
    
    .btn-action.btn-danger {
        background: #dc3545;
        color: white;
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
        
        .stats-container {
            grid-template-columns: 1fr;
        }
        
        .stat-card {
            padding: 16px;
        }
    }
</style>

<!-- Modern Header -->
<div class="modern-header">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <h1><i class="bi bi-credit-card me-2"></i>Manage Payments</h1>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.payments.create') }}" class="modern-btn modern-btn-primary">
                <i class="bi bi-plus-circle"></i> Record New Payment
            </a>
            <a href="{{ route('admin.dashboard') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
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

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show" role="alert" style="border-radius: 12px; border: 1px solid rgba(23, 162, 184, 0.2);">
        {{ session('info') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Statistics Cards -->
<div class="stats-container">
    <div class="stat-card">
        <div class="stat-icon total">
            <i class="bi bi-credit-card"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $payments->total() ?? 0 }}</h3>
            <p>Total Payments</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon pending">
            <i class="bi bi-clock"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $payments->where('payment_status', 'pending')->count() ?? 0 }}</h3>
            <p>Pending Payments</p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon completed">
            <i class="bi bi-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3>{{ $payments->where('payment_status', 'completed')->count() ?? 0 }}</h3>
            <p>Completed Payments</p>
        </div>
    </div>
</div>

<!-- Filter Card -->
<div class="modern-card">
    <div class="modern-card-header">
        <h5><i class="bi bi-funnel me-2"></i>Filter Payments</h5>
    </div>
    <div class="modern-card-body">
        <form action="{{ route('admin.payments.filter') }}" method="GET">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="college_id" class="form-label modern-form-label">College</label>
                    <select class="form-select modern-form-select" id="college_id" name="college_id">
                        <option value="">All Colleges</option>
                        @foreach($colleges ?? [] as $college)
                            <option value="{{ $college->college_id }}" {{ request('college_id') == $college->college_id ? 'selected' : '' }}>
                                {{ $college->college_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="status" class="form-label modern-form-label">Payment Status</label>
                    <select class="form-select modern-form-select" id="status" name="status">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="date_from" class="form-label modern-form-label">Date From</label>
                    <input type="date" class="form-control modern-form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                
                <div class="col-md-3 mb-3">
                    <label for="date_to" class="form-label modern-form-label">Date To</label>
                    <input type="date" class="form-control modern-form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('admin.payments.index') }}" class="modern-btn" style="background: rgba(108, 117, 125, 0.15); color: #6c757d;">
                    <i class="bi bi-x-circle"></i> Clear Filters
                </a>
                <button type="submit" class="modern-btn modern-btn-primary">
                    <i class="bi bi-funnel"></i> Apply Filters
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Payments List Card -->
<div class="modern-card">
    <div class="modern-card-header">
        <h5><i class="bi bi-credit-card me-2"></i>Payments List</h5>
    </div>
    <div class="modern-card-body p-0">
        @if($payments->count() > 0)
            <div class="table-responsive">
                <table class="table modern-table mb-0">
                    <thead>
                        <tr>
                            <th>Payment ID</th>
                            <th>Bill Number</th>
                            <th>College</th>
                            <th>Amount (₹ Cr)</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Transaction Ref</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            <tr>
                                <td><strong>{{ $payment->payment_id }}</strong></td>
                                <td>
                                    <a href="{{ route('admin.bills.show', $payment->bill->bill_id) }}" class="text-decoration-none" style="color: #667eea; font-weight: 600;">
                                        {{ $payment->bill->bill_no }}
                                    </a>
                                </td>
                                <td title="{{ $payment->bill->college->college_name }}">{{ Str::limit($payment->bill->college->college_name, 20) }}</td>
                                <td><strong>{{ number_format($payment->payment_amt, 2) }}</strong></td>
                                <td>{{ $payment->payment_date->format('d-m-Y') }}</td>
                                <td>
                                    <span class="modern-badge status-{{ $payment->payment_status }}">
                                        {{ ucfirst($payment->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->transaction_reference ?? 'N/A' }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-1">
                                        <a href="{{ route('admin.payments.show', $payment->payment_id) }}" class="btn-action btn-info" title="View details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        
                                        @if(in_array($payment->payment_status, ['pending']))
                                            <a href="{{ route('admin.payments.edit', $payment->payment_id) }}" class="btn-action btn-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        
                                        @if($payment->payment_status === 'pending')
                                            <form action="{{ route('admin.payments.updateStatus', $payment->payment_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="btn-action btn-success" title="Mark as Completed" 
                                                    onclick="return confirm('Are you sure you want to mark this payment as completed?');">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($payment->payment_status === 'pending')
                                            <form action="{{ route('admin.payments.destroy', $payment->payment_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-action btn-danger" title="Delete Payment"
                                                    onclick="return confirm('Are you sure you want to delete this payment?');">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            @if($payments->hasPages())
                <div class="d-flex justify-content-center p-3" style="background: #f8f9fa;">
                    {{ $payments->links() }}
                </div>
            @endif
        @else
            <div class="empty-state">
                <i class="bi bi-credit-card-x display-4"></i>
                <p>No payments found matching your criteria.</p>
                <a href="{{ route('admin.payments.create') }}" class="modern-btn modern-btn-primary">
                    <i class="bi bi-plus-circle"></i> Record New Payment
                </a>
            </div>
        @endif
    </div>
</div>
@endsection 