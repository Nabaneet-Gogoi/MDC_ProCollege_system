@extends('admin.layouts.app')

@section('title', 'Audit Logs')

@section('styles')
<style>
    .audit-logs-container {
        background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
        min-height: calc(100vh - 60px);
        padding: 20px 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.15) 1px, transparent 1px);
        background-size: 30px 30px;
        opacity: 0.4;
        pointer-events: none;
    }
    
    .page-header h1 {
        color: white;
        font-weight: 700;
        font-size: 2.5rem;
        margin: 0;
        position: relative;
        z-index: 2;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .page-header .header-icon {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 15px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .filter-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        border: 1px solid rgba(102, 126, 234, 0.1);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .filter-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    
    .filter-card .card-header {
        background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        padding: 20px 25px;
        font-weight: 700;
        color: #667eea;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .filter-card .card-body {
        padding: 25px;
    }
    
    .form-label {
        font-weight: 600;
        color: #4a5568;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }
    
    .form-control, .form-select {
        border: 2px solid rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        background: white;
        transform: translateY(-1px);
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
    }
    
    .btn-primary:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        transform: translateY(-2px);
        box-shadow: 0 12px 25px rgba(102, 126, 234, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        font-weight: 600;
        color: #4a5568;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }
    
    .btn-secondary:hover {
        background: linear-gradient(135deg, #cbd5e0 0%, #a0aec0 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        color: #2d3748;
    }
    
    .logs-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        border: 1px solid rgba(102, 126, 234, 0.1);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .logs-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    
    .logs-card .card-header {
        background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        padding: 20px 25px;
        font-weight: 700;
        color: #667eea;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table thead th {
        background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
        border: none;
        padding: 18px 15px;
        font-weight: 700;
        color: #667eea;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .table tbody tr {
        transition: all 0.3s ease;
        border: none;
    }
    
    .table tbody tr:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, rgba(248, 249, 255, 0.5) 100%);
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.1);
    }
    
    .table tbody td {
        padding: 18px 15px;
        border: none;
        vertical-align: middle;
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(102, 126, 234, 0.05);
    }
    
    .badge {
        padding: 8px 12px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid;
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
        border-color: #38a169;
        box-shadow: 0 2px 8px rgba(72, 187, 120, 0.3);
    }
    
    .badge.bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }
    
    .badge.bg-danger {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%) !important;
        border-color: #e53e3e;
        box-shadow: 0 2px 8px rgba(245, 101, 101, 0.3);
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%) !important;
        border-color: #3182ce;
        box-shadow: 0 2px 8px rgba(66, 153, 225, 0.3);
    }
    
    .btn-info {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        border: none;
        border-radius: 10px;
        padding: 8px 16px;
        font-weight: 600;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(66, 153, 225, 0.3);
    }
    
    .btn-info:hover {
        background: linear-gradient(135deg, #3182ce 0%, #2c5282 100%);
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(66, 153, 225, 0.4);
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #a0aec0;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: 20px;
        opacity: 0.5;
    }
    
    .empty-state h3 {
        color: #4a5568;
        margin-bottom: 10px;
    }
    
    .pagination {
        justify-content: center;
        margin-top: 30px;
        gap: 5px;
    }
    
    .page-link {
        border: none;
        border-radius: 10px;
        padding: 10px 15px;
        margin: 0 2px;
        color: #667eea;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .page-link:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .page-item.active .page-link {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .page-header {
            padding: 20px;
            border-radius: 15px;
        }
        
        .page-header h1 {
            font-size: 1.8rem;
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }
        
        .filter-card .card-body {
            padding: 20px;
        }
        
        .table-responsive {
            border-radius: 15px;
            overflow: hidden;
        }
        
        .table thead th,
        .table tbody td {
            padding: 12px 8px;
            font-size: 0.8rem;
        }
        
        .btn {
            padding: 10px 15px;
            font-size: 0.85rem;
        }
    }
    
    /* Animation for loading states */
    .loading-shimmer {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 2s infinite;
    }
    
    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }
</style>
@endsection

@section('content')
<div class="audit-logs-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1>
            <div class="header-icon">
                <i class="bi bi-journal-text"></i>
            </div>
            Audit Logs
        </h1>
    </div>

    <!-- Filter Form -->
    <div class="filter-card">
        <div class="card-header">
            <i class="bi bi-funnel-fill"></i>
            Advanced Filters
        </div>
        <div class="card-body">
            <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="row g-4">
                <div class="col-lg-3 col-md-6">
                    <label for="admin_id" class="form-label">
                        <i class="bi bi-person me-1"></i> Admin
                    </label>
                    <select class="form-select" id="admin_id" name="admin_id">
                        <option value="">All Admins</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->admin_id }}" {{ request('admin_id') == $admin->admin_id ? 'selected' : '' }}>
                                {{ $admin->name ?? $admin->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <label for="action" class="form-label">
                        <i class="bi bi-activity me-1"></i> Action
                    </label>
                    <select class="form-select" id="action" name="action">
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <label for="model_type" class="form-label">
                        <i class="bi bi-box me-1"></i> Model Type
                    </label>
                    <input type="text" class="form-control" id="model_type" name="model_type" 
                           value="{{ request('model_type') }}" placeholder="e.g. College, User">
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <label for="date_from" class="form-label">
                        <i class="bi bi-calendar-event me-1"></i> Date From
                    </label>
                    <input type="date" class="form-control" id="date_from" name="date_from" 
                           value="{{ request('date_from') }}">
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <label for="date_to" class="form-label">
                        <i class="bi bi-calendar-check me-1"></i> Date To
                    </label>
                    <input type="date" class="form-control" id="date_to" name="date_to" 
                           value="{{ request('date_to') }}">
                </div>
                
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-3 justify-content-start">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search me-2"></i> Apply Filters
                        </button>
                        <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i> Clear All
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="logs-card">
        <div class="card-header">
            <i class="bi bi-list-check"></i>
            Audit Log Entries
            @if($auditLogs->total() > 0)
                <span class="badge bg-primary ms-2">{{ $auditLogs->total() }} Total</span>
            @endif
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th width="60">ID</th>
                            <th width="150">Admin</th>
                            <th width="100">Action</th>
                            <th width="180">Model</th>
                            <th>Description</th>
                            <th width="140">Date & Time</th>
                            <th width="80">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditLogs as $log)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $log->id }}</span>
                                </td>
                                <td>
                                    @if($log->admin)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="rounded-circle bg-gradient-primary d-flex align-items-center justify-content-center" 
                                                     style="width: 32px; height: 32px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                                    <i class="bi bi-person text-white" style="font-size: 14px;"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.85rem;">
                                                    {{ $log->admin->name ?? 'N/A' }}
                                                </div>
                                                <div class="text-muted" style="font-size: 0.75rem;">
                                                    {{ $log->admin->email }}
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm me-2">
                                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                                     style="width: 32px; height: 32px;">
                                                    <i class="bi bi-gear text-white" style="font-size: 14px;"></i>
                                                </div>
                                            </div>
                                            <span class="text-muted fw-semibold">System</span>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge 
                                        {{ $log->action == 'create' ? 'bg-success' : '' }}
                                        {{ $log->action == 'update' ? 'bg-primary' : '' }}
                                        {{ $log->action == 'delete' ? 'bg-danger' : '' }}
                                        {{ !in_array($log->action, ['create', 'update', 'delete']) ? 'bg-info' : '' }}
                                    ">
                                        <i class="bi 
                                            {{ $log->action == 'create' ? 'bi-plus-circle' : '' }}
                                            {{ $log->action == 'update' ? 'bi-pencil-square' : '' }}
                                            {{ $log->action == 'delete' ? 'bi-trash' : '' }}
                                            {{ !in_array($log->action, ['create', 'update', 'delete']) ? 'bi-activity' : '' }}
                                        me-1"></i>
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            <i class="bi bi-box text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-dark" style="font-size: 0.85rem;">
                                                {{ class_basename($log->model_type) }}
                                            </div>
                                            @if($log->model_id)
                                                <div class="text-muted" style="font-size: 0.75rem;">
                                                    ID: {{ $log->model_id }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 300px;" title="{{ $log->description }}">
                                        {{ Str::limit($log->description, 60) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted">
                                        <div style="font-size: 0.85rem;">{{ $log->created_at->format('M d, Y') }}</div>
                                        <div style="font-size: 0.75rem;">{{ $log->created_at->format('H:i:s') }}</div>
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('admin.audit-logs.show', $log) }}" 
                                       class="btn btn-info btn-sm"
                                       title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7">
                                    <div class="empty-state">
                                        <i class="bi bi-journal-x"></i>
                                        <h3>No Audit Logs Found</h3>
                                        <p>There are no audit logs matching your current filters.</p>
                                        @if(request()->hasAny(['admin_id', 'action', 'model_type', 'date_from', 'date_to']))
                                            <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Reset Filters
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($auditLogs->hasPages())
                <div class="d-flex justify-content-center p-4">
                    {{ $auditLogs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth animations for form interactions
        const formControls = document.querySelectorAll('.form-control, .form-select');
        
        formControls.forEach(control => {
            control.addEventListener('focus', function() {
                this.closest('.col-lg-3, .col-md-6, .col-12')?.classList.add('focused');
            });
            
            control.addEventListener('blur', function() {
                this.closest('.col-lg-3, .col-md-6, .col-12')?.classList.remove('focused');
            });
        });
        
        // Enhanced table row interactions
        const tableRows = document.querySelectorAll('.table tbody tr');
        
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.01)';
                this.style.zIndex = '5';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
                this.style.zIndex = '1';
            });
        });
        
        // Auto-submit form on filter changes (optional)
        const autoSubmitSelects = document.querySelectorAll('#admin_id, #action');
        
        autoSubmitSelects.forEach(select => {
            select.addEventListener('change', function() {
                // Add a small delay to prevent accidental submissions
                setTimeout(() => {
                    if (this.value !== '') {
                        this.closest('form').submit();
                    }
                }, 500);
            });
        });
        
        // Initialize tooltips for truncated text
        const truncatedElements = document.querySelectorAll('.text-truncate[title]');
        
        truncatedElements.forEach(el => {
            el.addEventListener('mouseenter', function() {
                if (this.scrollWidth > this.clientWidth) {
                    // Show tooltip logic can be added here
                }
            });
        });
    });
</script>
@endsection 