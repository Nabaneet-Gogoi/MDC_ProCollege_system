@extends('rusa.layouts.app')

@section('title', 'Bill Progress Reports')

@section('styles')
<style>
    /* RUSA Progress Reports Specific Styles */
    .page-header {
        background: var(--rusa-gradient);
        border-radius: var(--radius-lg);
        padding: var(--spacing-lg);
        margin-bottom: var(--spacing-xl);
        box-shadow: var(--rusa-shadow);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        backdrop-filter: blur(2px);
    }
    
    .page-header h1 {
        color: #fff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }
    
    .btn-toolbar {
        position: relative;
        z-index: 1;
    }
    
    .btn-group .btn-sm {
        padding: var(--spacing-sm) var(--spacing-md);
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: var(--radius-md);
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary {
        border: 2px solid rgba(255, 255, 255, 0.8);
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(2px);
    }
    
    .btn-outline-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }
    
    /* Enhanced Progress Summary Card */
    .progress-summary-card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
        position: relative;
        margin-bottom: var(--spacing-xl);
    }
    
    .progress-summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--rusa-gradient);
    }
    
    .progress-summary-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
    }
    
    .card-header-rusa {
        background: linear-gradient(135deg, rgba(255, 224, 59, 0.1) 0%, rgba(253, 184, 19, 0.1) 100%);
        border-bottom: 1px solid rgba(255, 224, 59, 0.2);
        padding: var(--spacing-lg);
    }
    
    .card-header-rusa h5 {
        color: var(--rusa-accent);
        font-weight: 700;
        margin: 0;
        font-size: 1.1rem;
    }
    
    .card-header-rusa i {
        color: var(--rusa-tertiary);
        margin-right: var(--spacing-sm);
    }
    
    /* Compact RUSA Stat Cards */
    .rusa-stat-card {
        border: none;
        border-radius: var(--radius-md);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        backdrop-filter: blur(10px);
        margin-bottom: var(--spacing-lg);
        min-height: 100px;
    }
    
    .rusa-stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        bottom: 0;
        width: 4px;
    }
    
    .rusa-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }
    
    .rusa-stat-card.not-started {
        background: var(--warning-gradient);
        color: #fff;
        box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
    }
    
    .rusa-stat-card.not-started::before {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .rusa-stat-card.in-progress {
        background: var(--info-gradient);
        color: #fff;
        box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
    }
    
    .rusa-stat-card.in-progress::before {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .rusa-stat-card.completed {
        background: var(--success-gradient);
        color: #fff;
        box-shadow: 0 4px 15px rgba(25, 135, 84, 0.3);
    }
    
    .rusa-stat-card.completed::before {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .rusa-stat-card.total {
        background: var(--rusa-gradient);
        color: #fff;
        box-shadow: var(--rusa-shadow);
    }
    
    .rusa-stat-card.total::before {
        background: rgba(255, 255, 255, 0.3);
    }
    
    .rusa-stat-card .card-body {
        padding: var(--spacing-md);
        position: relative;
        z-index: 1;
    }
    
    .rusa-stat-card .stat-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: var(--spacing-xs);
        opacity: 0.9;
        font-weight: 600;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    .rusa-stat-card .stat-value {
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    .rusa-stat-card .stat-icon {
        font-size: 2.5rem;
        opacity: 0.4;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.3));
    }
    
    /* Enhanced Progress Reports Card */
    .progress-reports-card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
        position: relative;
    }
    
    .progress-reports-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--rusa-gradient);
    }
    
    .progress-reports-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
    }
    
    /* Enhanced Table Styles */
    .table-enhanced {
        margin: 0;
    }
    
    .table-enhanced thead th {
        background: var(--rusa-gradient-soft);
        color: #fff;
        border: none;
        padding: var(--spacing-md);
        font-weight: 600;
        font-size: 0.85rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    .table-enhanced tbody td {
        padding: var(--spacing-md);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 0.85rem;
        vertical-align: middle;
    }
    
    .table-enhanced tbody tr:hover {
        background-color: rgba(255, 224, 59, 0.08);
        transform: translateX(2px);
        transition: all 0.2s ease;
    }
    
    /* Enhanced Form Controls */
    .form-control-enhanced {
        border: 2px solid var(--rusa-primary);
        border-radius: var(--radius-md);
        padding: var(--spacing-sm) var(--spacing-md);
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        font-size: 0.85rem;
    }
    
    .form-control-enhanced:focus {
        border-color: var(--rusa-tertiary);
        box-shadow: 0 0 0 0.2rem rgba(255, 224, 59, 0.25);
        background: #fff;
    }
    
    .form-select-enhanced {
        border: 2px solid var(--rusa-secondary);
        border-radius: var(--radius-md);
        padding: var(--spacing-sm) var(--spacing-md);
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
        font-size: 0.85rem;
    }
    
    .form-select-enhanced:focus {
        border-color: var(--rusa-tertiary);
        box-shadow: 0 0 0 0.2rem rgba(253, 184, 19, 0.25);
        background: #fff;
    }
    
    /* Enhanced Progress Bars */
    .progress-enhanced {
        height: 8px;
        border-radius: var(--radius-sm);
        background: rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: relative;
    }
    
    .progress-bar-rusa {
        background: var(--rusa-gradient);
        transition: width 1s ease-in-out;
        position: relative;
        overflow: hidden;
    }
    
    .progress-bar-rusa::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        bottom: 0;
        right: -100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 2s infinite;
    }
    
    /* Enhanced Badges */
    .badge-rusa {
        background: var(--rusa-gradient);
        color: #fff;
        font-weight: 600;
        padding: 0.4em 0.8em;
        border-radius: var(--radius-sm);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    /* Empty State Enhancement */
    .empty-state {
        text-align: center;
        padding: var(--spacing-xxl);
        color: #6c757d;
    }
    
    .empty-state i {
        font-size: 4rem;
        margin-bottom: var(--spacing-lg);
        color: rgba(255, 224, 59, 0.3);
    }
    
    .empty-state .lead {
        color: #6c757d;
        font-weight: 500;
    }
    
    /* Responsive Improvements */
    @media (max-width: 768px) {
        .page-header {
            padding: var(--spacing-md);
        }
        
        .page-header h1 {
            font-size: 1.25rem;
        }
        
        .btn-toolbar {
            margin-top: var(--spacing-md);
        }
        
        .card-header-rusa {
            padding: var(--spacing-md);
        }
        
        .rusa-stat-card .stat-value {
            font-size: 1.5rem;
        }
        
        .rusa-stat-card .stat-icon {
            font-size: 2rem;
        }
        
        .table-enhanced {
            font-size: 0.75rem;
        }
        
        .table-enhanced thead th,
        .table-enhanced tbody td {
            padding: var(--spacing-sm);
        }
    }
    
    @media (max-width: 576px) {
        .rusa-stat-card {
            min-height: 80px;
        }
        
        .rusa-stat-card .card-body {
            padding: var(--spacing-sm);
        }
        
        .rusa-stat-card .stat-value {
            font-size: 1.3rem;
        }
        
        .rusa-stat-card .stat-icon {
            font-size: 1.8rem;
        }
    }
</style>
@endsection

@section('content')
    <!-- Enhanced Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h1><i class="bi bi-graph-up-arrow me-2"></i>Physical Progress from Bills</h1>
            <div class="btn-toolbar">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Progress Status Summary -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="progress-summary-card">
                <div class="card-header-rusa">
                    <h5><i class="bi bi-graph-up-arrow"></i>Bill Progress Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="rusa-stat-card not-started">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="stat-label">Not Started</div>
                                            <div class="stat-value">{{ $progressStats['not_started'] ?? 0 }}</div>
                                        </div>
                                        <div class="stat-icon">
                                            <i class="bi bi-hourglass-top"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="rusa-stat-card in-progress">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="stat-label">In Progress</div>
                                            <div class="stat-value">{{ $progressStats['in_progress'] ?? 0 }}</div>
                                        </div>
                                        <div class="stat-icon">
                                            <i class="bi bi-gear-wide-connected"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="rusa-stat-card completed">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="stat-label">Completed</div>
                                            <div class="stat-value">{{ $progressStats['completed'] ?? 0 }}</div>
                                        </div>
                                        <div class="stat-icon">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="rusa-stat-card total">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="stat-label">Total Reports</div>
                                            <div class="stat-value">{{ ($progressStats['not_started'] ?? 0) + ($progressStats['in_progress'] ?? 0) + ($progressStats['completed'] ?? 0) }}</div>
                                        </div>
                                        <div class="stat-icon">
                                            <i class="bi bi-clipboard-data"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Progress Reports List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="progress-reports-card">
                <div class="card-header-rusa d-flex justify-content-between align-items-center flex-wrap">
                    <h5><i class="bi bi-list-check"></i>Progress from Bills</h5>
                    <div class="d-flex mt-2 mt-md-0 gap-2">
                        <select class="form-select form-select-enhanced" id="statusFilter" style="min-width: 120px;">
                            <option value="all">All Status</option>
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                        </select>
                        <input type="text" id="searchTable" class="form-control form-control-enhanced" placeholder="🔍 Search..." style="min-width: 150px;">
                    </div>
                </div>
                <div class="card-body p-0">
                    @if(isset($progressReports) && count($progressReports) > 0)
                        <div class="table-responsive">
                            <table class="table table-enhanced" id="progressTable">
                                <thead>
                                    <tr>
                                        <th>College</th>
                                        <th>Category</th>
                                        <th>Bill No.</th>
                                        <th>Bill Date</th>
                                        <th>Completion %</th>
                                        <th>Status</th>
                                        <th>Bill Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($progressReports as $report)
                                        <tr class="progress-row" data-status="{{ $report->progress_status }}">
                                            <td><strong>{{ $report->college->college_name }}</strong></td>
                                            <td><span class="badge bg-secondary">{{ $report->category->category_name }}</span></td>
                                            <td><strong>{{ $report->bill->bill_no }}</strong></td>
                                            <td>{{ \Carbon\Carbon::parse($report->bill->bill_date)->format('d M Y') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress progress-enhanced flex-grow-1 me-2">
                                                        <div class="progress-bar 
                                                            @if($report->completion_percent >= 90) bg-success 
                                                            @elseif($report->completion_percent >= 50) progress-bar-rusa 
                                                            @elseif($report->completion_percent >= 20) bg-info 
                                                            @else bg-warning @endif" 
                                                             role="progressbar" style="width: {{ $report->completion_percent }}%"></div>
                                                    </div>
                                                    <small class="fw-bold">{{ $report->completion_percent }}%</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($report->progress_status == 'not_started')
                                                    <span class="badge bg-warning text-dark">
                                                        <i class="bi bi-hourglass-top me-1"></i>Not Started
                                                    </span>
                                                @elseif($report->progress_status == 'in_progress')
                                                    <span class="badge bg-primary">
                                                        <i class="bi bi-gear-wide-connected me-1"></i>In Progress
                                                    </span>
                                                @elseif($report->progress_status == 'completed')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Completed
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($report->bill->bill_status == 'approved')
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle-fill me-1"></i>Approved
                                                    </span>
                                                @elseif($report->bill->bill_status == 'paid')
                                                    <span class="badge bg-info">
                                                        <i class="bi bi-credit-card me-1"></i>Paid
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center p-3">
                            {{ $progressReports->links() }}
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-clipboard-x"></i>
                            <p class="lead mt-3">No bill progress reports available</p>
                            <p class="text-muted">Progress reports will appear here once bills are submitted and tracked.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Enhanced table search functionality
    document.getElementById('searchTable').addEventListener('keyup', function() {
        filterTable();
    });
    
    // Enhanced status filter functionality
    document.getElementById('statusFilter').addEventListener('change', function() {
        filterTable();
    });
    
    function filterTable() {
        const searchTerm = document.getElementById('searchTable').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const rows = document.getElementsByClassName('progress-row');
        let visibleCount = 0;
        
        for (let i = 0; i < rows.length; i++) {
            const rowText = rows[i].textContent.toLowerCase();
            const rowStatus = rows[i].getAttribute('data-status');
            
            let showRow = rowText.includes(searchTerm);
            
            if (statusFilter !== 'all') {
                showRow = showRow && rowStatus === statusFilter;
            }
            
            if (showRow) {
                rows[i].style.display = '';
                rows[i].style.animation = 'fadeIn 0.3s ease-in';
                visibleCount++;
            } else {
                rows[i].style.display = 'none';
            }
        }
        
        // Show/hide empty message based on results
        const tbody = document.querySelector('#progressTable tbody');
        const existingEmptyRow = document.querySelector('.empty-filter-row');
        
        if (visibleCount === 0 && !existingEmptyRow) {
            const emptyRow = document.createElement('tr');
            emptyRow.className = 'empty-filter-row';
            emptyRow.innerHTML = `
                <td colspan="7" class="text-center py-4">
                    <i class="bi bi-search text-muted" style="font-size: 2rem;"></i>
                    <p class="text-muted mt-2 mb-0">No results found for current filters</p>
                </td>
            `;
            tbody.appendChild(emptyRow);
        } else if (visibleCount > 0 && existingEmptyRow) {
            existingEmptyRow.remove();
        }
    }
    
    // Add fade-in animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
    `;
    document.head.appendChild(style);
    
    // Initialize filter on page load
    document.addEventListener('DOMContentLoaded', function() {
        filterTable();
    });
</script>
@endsection 