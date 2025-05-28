@extends('college.layouts.app')

@section('title', 'Fund Utilization')

@section('content')
    <!-- Modern Header Section -->
    <div class="modern-header d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4">
        <div>
            <h1 class="h2 fw-bold text-primary mb-1">
                <i class="bi bi-graph-up-arrow me-2"></i>Fund Utilization Statistics
            </h1>
            <p class="text-muted mb-0">Track and analyze funding allocation and utilization patterns</p>
        </div>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-modern btn-success" id="export-pdf">
                    <i class="bi bi-file-earmark-pdf me-1"></i> Export PDF
                </button>
                <button type="button" class="btn btn-modern btn-info" onclick="window.print()">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
                <button type="button" class="btn btn-modern btn-warning" id="refresh-data">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Enhanced Summary Stats Cards -->
    <div class="row mb-4 g-4">
        <div class="col-xl-4 col-md-6">
            <div class="modern-card modern-stat-card h-100" style="--accent-color: var(--success-gradient);">
                <div class="card-header modern-header-gradient">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-success">
                            <i class="bi bi-currency-rupee"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-bold">Total Funding</h6>
                            <small class="text-muted">Approved Amount</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="display-5 fw-bold text-primary">₹{{ number_format($totalFunding, 2) }}</div>
                        <div class="stat-trend">
                            <div class="fs-1 text-success opacity-25">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="funding-details">
                        <div class="detail-row d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Released:</span>
                            <span class="fw-bold">₹{{ number_format($releasedFunding, 2) }} Cr</span>
                        </div>
                        
                        <div class="modern-progress-container mb-3">
                            <div class="modern-progress" style="--progress: {{ $fundingReleasePercent }}%;">
                                <div class="progress-shimmer"></div>
                            </div>
                            <div class="progress-labels d-flex justify-content-between mt-1">
                                <small class="text-muted">0%</small>
                                <small class="fw-bold text-primary">{{ $fundingReleasePercent }}%</small>
                                <small class="text-muted">100%</small>
                            </div>
                        </div>
                        
                        <div class="release-status d-flex align-items-center">
                            <div class="status-indicator bg-success me-2"></div>
                            <small class="text-muted">Release Progress: <span class="fw-bold">{{ $fundingReleasePercent }}%</span></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6">
            <div class="modern-card modern-stat-card h-100" style="--accent-color: var(--primary-gradient);">
                <div class="card-header modern-header-gradient">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-bold">Fund Utilization</h6>
                            <small class="text-muted">Amount Utilized</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="display-5 fw-bold text-primary">₹{{ number_format($utilizedFunding, 2) }}</div>
                        <div class="stat-trend">
                            <div class="fs-1 text-primary opacity-25">
                                <i class="bi bi-bar-chart"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="funding-details">
                        <div class="detail-row d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Available:</span>
                            <span class="fw-bold">₹{{ number_format($releasedFunding, 2) }} Cr</span>
                        </div>
                        
                        <div class="modern-progress-container mb-3">
                            <div class="modern-progress utilization-progress" style="--progress: {{ $fundingUtilizationPercent }}%;">
                                <div class="progress-shimmer"></div>
                            </div>
                            <div class="progress-labels d-flex justify-content-between mt-1">
                                <small class="text-muted">0%</small>
                                <small class="fw-bold text-success">{{ $fundingUtilizationPercent }}%</small>
                                <small class="text-muted">100%</small>
                            </div>
                        </div>
                        
                        <div class="release-status d-flex align-items-center">
                            <div class="status-indicator bg-primary me-2"></div>
                            <small class="text-muted">Utilization: <span class="fw-bold">{{ $fundingUtilizationPercent }}%</span></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-12">
            <div class="modern-card modern-stat-card h-100" style="--accent-color: var(--warning-gradient);">
                <div class="card-header modern-header-gradient">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-warning">
                            <i class="bi bi-pie-chart"></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 fw-bold">Utilization Overview</h6>
                            <small class="text-muted">Available vs Utilized</small>
                        </div>
                    </div>
                </div>
                <div class="card-body text-center">
                    <div class="position-relative mx-auto mb-3" style="max-width: 140px; height: 140px;">
                        <div class="modern-progress-circle" style="--progress: {{ $fundingUtilizationPercent }}%">
                            <div class="progress-circle-content">
                                <div class="display-6 fw-bold text-primary">{{ $fundingUtilizationPercent }}%</div>
                                <div class="small text-muted">Utilized</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="fund-comparison">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="comparison-card">
                                    <div class="small text-muted mb-1">Available</div>
                                    <div class="fw-bold text-warning">₹{{ number_format($releasedFunding - $utilizedFunding, 2) }}</div>
                                    <div class="tiny text-muted">Cr Remaining</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="comparison-card">
                                    <div class="small text-muted mb-1">Utilized</div>
                                    <div class="fw-bold text-success">₹{{ number_format($utilizedFunding, 2) }}</div>
                                    <div class="tiny text-muted">Cr Spent</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Charts Section -->
    <div class="row mb-4">
        <div class="col-lg-10 mx-auto">
            <div class="modern-card chart-card">
                <div class="card-header modern-header-gradient d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info me-3">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Monthly Fund Utilization Trend</h5>
                            <small class="text-muted">Track monthly spending patterns and trends</small>
                        </div>
                    </div>
                    <div class="chart-controls">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary active" data-period="6m">6M</button>
                            <button class="btn btn-outline-primary" data-period="1y">1Y</button>
                            <button class="btn btn-outline-primary" data-period="all">All</button>
                        </div>
                    </div>
                </div>
                <div class="card-body chart-container">
                    <canvas id="monthlyUtilizationChart" height="120"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Quarterly Utilization Stats -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header modern-header-gradient">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-secondary me-3">
                            <i class="bi bi-calendar-range"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Quarterly Utilization Analysis</h5>
                            <small class="text-muted">Breakdown of quarterly fund utilization patterns</small>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($quarterlyData as $index => $quarter)
                            @if($quarter['amount'] > 0)
                                <div class="col-lg-3 col-md-6">
                                    <div class="quarterly-card h-100 {{ $index % 2 == 0 ? 'primary-accent' : 'success-accent' }}">
                                        <div class="quarterly-header">
                                            <div class="quarter-badge">
                                                <i class="bi bi-calendar4-week"></i>
                                            </div>
                                            <div class="quarter-period">{{ $quarter['period'] }}</div>
                                        </div>
                                        <div class="quarterly-content">
                                            <div class="quarterly-amount">₹{{ number_format($quarter['amount'], 2) }}</div>
                                            <div class="quarterly-label">Funds Utilized</div>
                                            <div class="quarterly-progress">
                                                <div class="mini-progress" style="--progress: {{ ($quarter['amount'] / max(array_column($quarterlyData, 'amount'))) * 100 }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Detailed Funding Breakdown -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header modern-header-gradient d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-primary me-3">
                            <i class="bi bi-list-columns"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Detailed Funding Breakdown</h5>
                            <small class="text-muted">Comprehensive view of all funding sources and utilization</small>
                        </div>
                    </div>
                    <div class="table-actions">
                        <button class="btn btn-sm btn-outline-primary me-2" id="export-table">
                            <i class="bi bi-download me-1"></i>Export
                        </button>
                        <button class="btn btn-sm btn-outline-secondary" id="filter-table">
                            <i class="bi bi-funnel me-1"></i>Filter
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($fundingBreakdown) > 0)
                        <div class="modern-table-container">
                            <table class="table modern-table table-hover">
                                <thead>
                                    <tr>
                                        <th class="sortable" data-sort="type">
                                            <i class="bi bi-tag me-1"></i>Type
                                            <i class="bi bi-chevron-expand sort-icon"></i>
                                        </th>
                                        <th class="sortable" data-sort="approved">
                                            <i class="bi bi-check-circle me-1"></i>Approved
                                            <i class="bi bi-chevron-expand sort-icon"></i>
                                        </th>
                                        <th class="sortable" data-sort="released">
                                            <i class="bi bi-arrow-down-circle me-1"></i>Released
                                            <i class="bi bi-chevron-expand sort-icon"></i>
                                        </th>
                                        <th class="sortable" data-sort="utilized">
                                            <i class="bi bi-graph-up me-1"></i>Utilized
                                            <i class="bi bi-chevron-expand sort-icon"></i>
                                        </th>
                                        <th class="sortable" data-sort="remaining">
                                            <i class="bi bi-wallet2 me-1"></i>Remaining
                                            <i class="bi bi-chevron-expand sort-icon"></i>
                                        </th>
                                        <th>
                                            <i class="bi bi-percent me-1"></i>Utilization
                                        </th>
                                        <th>
                                            <i class="bi bi-flag me-1"></i>Status
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fundingBreakdown as $funding)
                                        <tr class="table-row-hover">
                                            <td>
                                                <div class="funding-type">
                                                    <div class="type-badge">
                                                        <i class="bi bi-building"></i>
                                                    </div>
                                                    <span class="fw-semibold">{{ $funding['funding_type'] }}</span>
                                                </div>
                                            </td>
                                            <td class="amount-cell">
                                                <span class="amount-value">₹{{ number_format($funding['approved_amt'], 2) }}</span>
                                                <span class="amount-unit">Cr</span>
                                            </td>
                                            <td class="amount-cell">
                                                <span class="amount-value">₹{{ number_format($funding['released_amt'], 2) }}</span>
                                                <span class="amount-unit">Cr</span>
                                            </td>
                                            <td class="amount-cell">
                                                <span class="amount-value">₹{{ number_format($funding['utilized_amt'], 2) }}</span>
                                                <span class="amount-unit">Cr</span>
                                            </td>
                                            <td class="amount-cell">
                                                <span class="amount-value">₹{{ number_format($funding['remaining_amt'], 2) }}</span>
                                                <span class="amount-unit">Cr</span>
                                            </td>
                                            <td>
                                                <div class="utilization-cell">
                                                    <div class="table-progress-container">
                                                        <div class="table-progress {{ $funding['utilization_percent'] >= 90 ? 'high-utilization' : 'normal-utilization' }}" 
                                                             style="--progress: {{ $funding['utilization_percent'] }}%;">
                                                            <div class="progress-shimmer"></div>
                                                        </div>
                                                    </div>
                                                    <span class="utilization-percent">{{ $funding['utilization_percent'] }}%</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($funding['utilization_status'] == 'completed')
                                                    <span class="modern-badge success-badge">
                                                        <i class="bi bi-check-circle me-1"></i>Completed
                                                    </span>
                                                @elseif($funding['utilization_status'] == 'in_progress')
                                                    <span class="modern-badge primary-badge">
                                                        <i class="bi bi-clock me-1"></i>In Progress
                                                    </span>
                                                @else
                                                    <span class="modern-badge secondary-badge">
                                                        <i class="bi bi-pause-circle me-1"></i>Not Started
                                                    </span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state text-center py-5">
                            <div class="empty-icon">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <h5 class="mt-3 text-muted">No funding data available</h5>
                            <p class="text-muted">Funding information will appear here once data is available.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Bills Utilization History -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="modern-card">
                <div class="card-header modern-header-gradient d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-info me-3">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-bold">Bills Utilization History</h5>
                            <small class="text-muted">Recent bills and payment history tracking</small>
                        </div>
                    </div>
                    <div class="bills-controls">
                        <div class="input-group input-group-sm me-3" style="width: 200px;">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" placeholder="Search bills..." id="bills-search">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($bills) > 0)
                        <div class="modern-table-container">
                            <table class="table modern-table table-hover" id="bills-table">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bi bi-hash me-1"></i>Bill No
                                        </th>
                                        <th>
                                            <i class="bi bi-bank me-1"></i>Funding Source
                                        </th>
                                        <th>
                                            <i class="bi bi-calendar me-1"></i>Date
                                        </th>
                                        <th>
                                            <i class="bi bi-currency-rupee me-1"></i>Amount
                                        </th>
                                        <th>
                                            <i class="bi bi-flag me-1"></i>Status
                                        </th>
                                        <th>
                                            <i class="bi bi-gear me-1"></i>Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bills as $bill)
                                        <tr class="table-row-hover">
                                            <td>
                                                <div class="bill-number">
                                                    <span class="fw-semibold">{{ $bill->bill_no }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="funding-source">
                                                    <i class="bi bi-building text-primary me-2"></i>
                                                    <span>{{ $bill->funding->funding_name }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="bill-date">
                                                    <i class="bi bi-calendar-event text-muted me-2"></i>
                                                    <span>{{ $bill->bill_date->format('d M Y') }}</span>
                                                </div>
                                            </td>
                                            <td class="amount-cell">
                                                <span class="amount-value">₹{{ number_format($bill->bill_amt, 2) }}</span>
                                                <span class="amount-unit">Cr</span>
                                            </td>
                                            <td>
                                                @if($bill->bill_status == 'approved')
                                                    <span class="modern-badge success-badge">
                                                        <i class="bi bi-check-circle me-1"></i>Approved
                                                    </span>
                                                @elseif($bill->bill_status == 'paid')
                                                    <span class="modern-badge info-badge">
                                                        <i class="bi bi-credit-card me-1"></i>Paid
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="action-buttons">
                                                    <a href="{{ route('college.bills.show', $bill->bill_id) }}" 
                                                       class="btn btn-sm btn-modern btn-primary">
                                                        <i class="bi bi-eye me-1"></i>View
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state text-center py-5">
                            <div class="empty-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <h5 class="mt-3 text-muted">No bills utilization history available</h5>
                            <p class="text-muted">Bill utilization data will appear here once bills are processed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    /* Modern Header Styling */
    .modern-header {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(248, 250, 252, 0.95) 100%);
        backdrop-filter: blur(10px);
        border-radius: var(--radius-lg);
        padding: var(--spacing-lg) var(--spacing-xl);
        box-shadow: var(--shadow-sm);
        border: 1px solid rgba(0, 0, 0, 0.05);
        margin-bottom: var(--spacing-xl);
    }

    .modern-header h1 {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 1.75rem;
    }

    /* Enhanced Button Styling */
    .btn-modern {
        background: var(--success-gradient);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        font-weight: 600;
        padding: var(--spacing-sm) var(--spacing-lg);
        border-radius: var(--radius-sm);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .btn-modern.btn-success {
        background: var(--success-gradient);
        box-shadow: 0 4px 8px rgba(5, 150, 105, 0.3);
    }

    .btn-modern.btn-info {
        background: var(--info-gradient);
        box-shadow: 0 4px 8px rgba(8, 145, 178, 0.3);
    }

    .btn-modern.btn-warning {
        background: var(--warning-gradient);
        box-shadow: 0 4px 8px rgba(217, 119, 6, 0.3);
    }

    .btn-modern.btn-primary {
        background: var(--primary-gradient);
        box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
    }

    /* Modern Card Styling */
    .modern-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-md);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }

    .modern-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--primary-gradient);
    }

    .modern-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-xl);
    }

    /* Enhanced Stat Cards */
    .modern-stat-card {
        /* Removed border-left and border-image properties */
    }

    .modern-stat-card::before {
        background: var(--accent-color);
    }

    .modern-header-gradient {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: var(--spacing-lg);
        border-radius: var(--radius-lg) var(--radius-lg) 0 0;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: var(--radius-md);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        box-shadow: var(--shadow-sm);
    }

    .stat-trend {
        opacity: 0.1;
        transition: opacity 0.3s ease;
    }

    .modern-stat-card:hover .stat-trend {
        opacity: 0.3;
    }

    /* Enhanced Progress Bars */
    .modern-progress-container {
        position: relative;
    }

    .modern-progress {
        height: 12px;
        background: rgba(0, 0, 0, 0.05);
        border-radius: 6px;
        overflow: hidden;
        position: relative;
    }

    .modern-progress::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: var(--progress);
        background: var(--success-gradient);
        border-radius: 6px;
        transition: width 1s ease-in-out;
    }

    .modern-progress.utilization-progress::before {
        background: var(--primary-gradient);
    }

    .progress-shimmer {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    .progress-labels {
        font-size: 0.75rem;
    }

    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    /* Enhanced Progress Circle */
    .modern-progress-circle {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: conic-gradient(
            var(--primary-gradient) calc(var(--progress) * 1%), 
            rgba(0, 0, 0, 0.05) 0
        );
        display: flex;
        justify-content: center;
        align-items: center;
        animation: progressLoad 2s ease-in-out;
    }

    @keyframes progressLoad {
        from { background: conic-gradient(rgba(0, 0, 0, 0.05) 0%, rgba(0, 0, 0, 0.05) 100%); }
        to { background: conic-gradient(var(--primary-gradient) calc(var(--progress) * 1%), rgba(0, 0, 0, 0.05) 0); }
    }
    
    .modern-progress-circle::before {
        content: '';
        position: absolute;
        width: 75%;
        height: 75%;
        border-radius: 50%;
        background: white;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    .progress-circle-content {
        position: relative;
        z-index: 1;
        text-align: center;
    }

    /* Fund Comparison Cards */
    .comparison-card {
        background: rgba(255, 255, 255, 0.8);
        border-radius: var(--radius-sm);
        padding: var(--spacing-sm);
        text-align: center;
        transition: all 0.3s ease;
    }

    .comparison-card:hover {
        background: rgba(255, 255, 255, 1);
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }

    /* Chart Container */
    .chart-card {
        min-height: 450px;
    }

    .chart-container {
        padding: var(--spacing-xl);
        position: relative;
        height: 400px;
    }

    .chart-controls .btn-group-sm .btn {
        padding: var(--spacing-xs) var(--spacing-md);
        font-size: 0.75rem;
        border-radius: var(--radius-sm);
        border: 1px solid #e5e7eb;
        background: white;
        color: #374151;
        transition: all 0.3s ease;
    }

    .chart-controls .btn-group-sm .btn.active {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
    }

    .chart-controls .btn-group-sm .btn:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: transparent;
    }

    /* Quarterly Cards */
    .quarterly-card {
        background: rgba(255, 255, 255, 0.9);
        border-radius: var(--radius-md);
        padding: var(--spacing-lg);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .quarterly-card.primary-accent {
        /* Removed border-left-color */
    }

    .quarterly-card.success-accent {
        /* Removed border-left-color */
    }

    .quarterly-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .quarterly-header {
        display: flex;
        align-items: center;
        margin-bottom: var(--spacing-md);
    }

    .quarter-badge {
        width: 32px;
        height: 32px;
        background: var(--primary-gradient);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: var(--spacing-md);
    }

    .quarter-period {
        font-weight: 600;
        color: #374151;
    }

    .quarterly-amount {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1e3c72;
        margin-bottom: var(--spacing-xs);
    }

    .quarterly-label {
        font-size: 0.8rem;
        color: #6b7280;
        margin-bottom: var(--spacing-md);
    }

    .mini-progress {
        height: 4px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 2px;
        position: relative;
        overflow: hidden;
    }

    .mini-progress::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: var(--progress);
        background: var(--success-gradient);
        border-radius: 2px;
        transition: width 1s ease-in-out;
    }

    /* Enhanced Table Styling */
    .modern-table-container {
        border-radius: var(--radius-md);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .modern-table {
        margin-bottom: 0;
        background: white;
    }

    .modern-table thead th {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border-bottom: 2px solid #e5e7eb;
        font-weight: 600;
        color: #374151;
        padding: var(--spacing-lg);
        border: none;
        position: relative;
    }

    .modern-table thead th.sortable {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modern-table thead th.sortable:hover {
        background: linear-gradient(135deg, #e2e8f0 0%, #d1d5db 100%);
    }

    .sort-icon {
        font-size: 0.7rem;
        margin-left: var(--spacing-xs);
        opacity: 0.5;
        transition: all 0.3s ease;
    }

    .sortable:hover .sort-icon {
        opacity: 1;
    }

    .modern-table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f3f4f6;
    }

    .table-row-hover:hover {
        background: rgba(59, 130, 246, 0.05);
        transform: translateX(4px);
    }

    .modern-table td {
        padding: var(--spacing-lg);
        vertical-align: middle;
        border: none;
    }

    /* Table Cell Styling */
    .funding-type {
        display: flex;
        align-items: center;
    }

    .type-badge {
        width: 32px;
        height: 32px;
        background: var(--primary-gradient);
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        margin-right: var(--spacing-md);
        font-size: 0.9rem;
    }

    .amount-cell {
        font-family: 'SF Mono', Monaco, 'Cascadia Code', monospace;
    }

    .amount-value {
        font-weight: 600;
        color: #1e3c72;
    }

    .amount-unit {
        font-size: 0.8rem;
        color: #6b7280;
        margin-left: var(--spacing-xs);
    }

    .utilization-cell {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xs);
    }

    .table-progress-container {
        width: 80px;
    }

    .table-progress {
        height: 8px;
        background: rgba(0, 0, 0, 0.1);
        border-radius: 4px;
        position: relative;
        overflow: hidden;
    }

    .table-progress::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: var(--progress);
        border-radius: 4px;
        transition: width 1s ease-in-out;
    }

    .table-progress.high-utilization::before {
        background: var(--success-gradient);
    }

    .table-progress.normal-utilization::before {
        background: var(--primary-gradient);
    }

    .utilization-percent {
        font-size: 0.75rem;
        font-weight: 600;
        color: #374151;
    }

    /* Modern Badges */
    .modern-badge {
        padding: var(--spacing-xs) var(--spacing-md);
        border-radius: var(--radius-sm);
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        transition: all 0.3s ease;
    }

    .success-badge {
        background: var(--success-gradient);
        color: white;
        box-shadow: 0 2px 4px rgba(5, 150, 105, 0.3);
    }

    .primary-badge {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3);
    }

    .info-badge {
        background: var(--info-gradient);
        color: white;
        box-shadow: 0 2px 4px rgba(8, 145, 178, 0.3);
    }

    .secondary-badge {
        background: var(--secondary-gradient);
        color: white;
        box-shadow: 0 2px 4px rgba(99, 102, 241, 0.3);
    }

    .modern-badge:hover {
        transform: translateY(-1px);
    }

    /* Empty State Styling */
    .empty-state {
        color: #9ca3af;
    }

    .empty-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: var(--spacing-lg);
    }

    /* Search and Filter Controls */
    .bills-controls .input-group-text {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid #e5e7eb;
        color: #6b7280;
    }

    .bills-controls .form-control {
        border: 1px solid #e5e7eb;
        transition: all 0.3s ease;
    }

    .bills-controls .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: var(--spacing-xs);
    }

    .table-actions {
        display: flex;
        align-items: center;
    }

    /* Responsive Enhancements */
    @media (max-width: 768px) {
        .modern-header {
            padding: var(--spacing-md);
            text-align: center;
        }

        .modern-header .btn-toolbar {
            justify-content: center;
            margin-top: var(--spacing-md);
        }

        .quarterly-card {
            margin-bottom: var(--spacing-md);
        }

        .chart-container {
            padding: var(--spacing-md);
        }

        .comparison-card {
            margin-bottom: var(--spacing-sm);
        }

        .modern-table-container {
            font-size: 0.9rem;
        }

        .modern-table td,
        .modern-table thead th {
            padding: var(--spacing-md);
        }
    }

    /* Print Styles */
    @media print {
        .sidebar, .navbar, .btn-toolbar, .chart-controls, .table-actions, .bills-controls {
            display: none !important;
        }
        
        .content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        
        .modern-card {
            break-inside: avoid;
            box-shadow: none;
            border: 1px solid #ddd;
        }

        .modern-header {
            background: none;
            border: 1px solid #ddd;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Enhanced Chart with Modern Styling
        const monthlyCtx = document.getElementById('monthlyUtilizationChart').getContext('2d');
        const chartData = {!! json_encode($utilizationChartData['data'] ?? []) !!};
        const chartLabels = {!! json_encode($utilizationChartData['labels'] ?? []) !!};
        
        const monthlyChart = new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Monthly Fund Utilization (₹ Cr)',
                    data: chartData,
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return 'rgba(59, 130, 246, 0.7)';
                        
                        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, 'rgba(30, 60, 114, 0.7)');
                        gradient.addColorStop(0.5, 'rgba(42, 82, 152, 0.8)');
                        gradient.addColorStop(1, 'rgba(59, 130, 246, 0.9)');
                        return gradient;
                    },
                    borderColor: 'rgba(59, 130, 246, 1)',
                    borderWidth: 2,
                    borderRadius: 6,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: {
                    duration: 1500,
                    easing: 'easeInOutCubic'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                layout: {
                    padding: {
                        top: 20,
                        bottom: 20,
                        left: 10,
                        right: 10
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (₹ Cr)',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            color: '#374151'
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            lineWidth: 1
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            callback: function(value) {
                                return '₹' + value.toFixed(2);
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month',
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            color: '#374151'
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6b7280',
                            font: {
                                size: 12
                            },
                            maxRotation: 45
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            usePointStyle: true,
                            font: {
                                size: 13,
                                weight: 'bold'
                            },
                            color: '#374151',
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(59, 130, 246, 0.8)',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            title: function(context) {
                                return `Month: ${context[0].label}`;
                            },
                            label: function(context) {
                                return `Fund Utilization: ₹${context.raw.toFixed(2)} Cr`;
                            }
                        }
                    }
                }
            }
        });

        // Chart Period Controls
        const chartControls = document.querySelectorAll('.chart-controls .btn');
        chartControls.forEach(btn => {
            btn.addEventListener('click', function() {
                chartControls.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                // Add loading animation
                const chartContainer = document.querySelector('.chart-container');
                chartContainer.style.opacity = '0.6';
                
                // Simulate data reload (replace with actual AJAX call)
                setTimeout(() => {
                    chartContainer.style.opacity = '1';
                    monthlyChart.update('resize');
                }, 500);
            });
        });

        // Enhanced Progress Circle Animation
        const progressCircles = document.querySelectorAll('.modern-progress-circle');
        progressCircles.forEach(circle => {
            const progress = circle.style.getPropertyValue('--progress');
            circle.style.setProperty('--progress', '0%');
            
            setTimeout(() => {
                circle.style.setProperty('--progress', progress);
            }, 500);
        });

        // Enhanced Progress Bars Animation
        const progressBars = document.querySelectorAll('.modern-progress, .table-progress, .mini-progress');
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const progressObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const progress = entry.target;
                    const progressValue = progress.style.getPropertyValue('--progress');
                    progress.style.setProperty('--progress', '0%');
                    
                    setTimeout(() => {
                        progress.style.setProperty('--progress', progressValue);
                    }, 200);
                    
                    progressObserver.unobserve(progress);
                }
            });
        }, observerOptions);

        progressBars.forEach(bar => {
            progressObserver.observe(bar);
        });

        // Enhanced Search Functionality
        const billsSearch = document.getElementById('bills-search');
        if (billsSearch) {
            billsSearch.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const tableRows = document.querySelectorAll('#bills-table tbody tr');
                
                tableRows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    const shouldShow = text.includes(searchTerm);
                    
                    if (shouldShow) {
                        row.style.display = '';
                        row.style.animation = 'fadeIn 0.3s ease';
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                // Update empty state
                const visibleRows = Array.from(tableRows).filter(row => row.style.display !== 'none');
                const emptyState = document.querySelector('.empty-state');
                if (visibleRows.length === 0 && searchTerm) {
                    if (!emptyState) {
                        const tbody = document.querySelector('#bills-table tbody');
                        const emptyRow = document.createElement('tr');
                        emptyRow.innerHTML = `
                            <td colspan="6" class="text-center py-4 search-empty">
                                <i class="bi bi-search display-4 text-muted"></i>
                                <p class="lead mt-3">No bills found matching "${searchTerm}"</p>
                            </td>
                        `;
                        emptyRow.classList.add('search-empty-row');
                        tbody.appendChild(emptyRow);
                    }
                } else {
                    const searchEmpty = document.querySelector('.search-empty-row');
                    if (searchEmpty) {
                        searchEmpty.remove();
                    }
                }
            });
        }

        // Enhanced Table Sorting
        const sortableHeaders = document.querySelectorAll('.sortable');
        let currentSort = { column: null, direction: 'asc' };

        sortableHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const column = this.dataset.sort;
                const table = this.closest('table');
                const tbody = table.querySelector('tbody');
                const rows = Array.from(tbody.querySelectorAll('tr'));

                // Update sort direction
                if (currentSort.column === column) {
                    currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
                } else {
                    currentSort.direction = 'asc';
                }
                currentSort.column = column;

                // Update sort icons
                sortableHeaders.forEach(h => {
                    const icon = h.querySelector('.sort-icon');
                    icon.className = 'bi bi-chevron-expand sort-icon';
                });

                const activeIcon = this.querySelector('.sort-icon');
                activeIcon.className = currentSort.direction === 'asc' 
                    ? 'bi bi-chevron-up sort-icon' 
                    : 'bi bi-chevron-down sort-icon';

                // Sort rows
                rows.sort((a, b) => {
                    let aVal, bVal;
                    const columnIndex = Array.from(this.parentNode.children).indexOf(this);
                    
                    aVal = a.children[columnIndex].textContent.trim();
                    bVal = b.children[columnIndex].textContent.trim();

                    // Handle numeric values
                    if (column === 'approved' || column === 'released' || column === 'utilized' || column === 'remaining') {
                        aVal = parseFloat(aVal.replace(/[₹,\s]/g, '')) || 0;
                        bVal = parseFloat(bVal.replace(/[₹,\s]/g, '')) || 0;
                    }

                    if (currentSort.direction === 'asc') {
                        return aVal > bVal ? 1 : -1;
                    } else {
                        return aVal < bVal ? 1 : -1;
                    }
                });

                // Reorder rows with animation
                tbody.style.opacity = '0.6';
                setTimeout(() => {
                    rows.forEach(row => tbody.appendChild(row));
                    tbody.style.opacity = '1';
                }, 150);
            });
        });

        // Enhanced PDF Export with Modern Styling
        document.getElementById('export-pdf').addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            
            // Add loading state
            btn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Generating...';
            btn.disabled = true;

            window.scrollTo(0, 0);
            const { jsPDF } = window.jspdf;
            
            const doc = new jsPDF('p', 'mm', 'a4');
            const content = document.querySelector('.content');
            
            // Enhanced PDF header
            doc.setFontSize(24);
            doc.setTextColor(30, 60, 114);
            doc.text('MDC ProCollege System', 105, 20, { align: 'center' });
            
            doc.setFontSize(18);
            doc.setTextColor(42, 82, 152);
            doc.text('Fund Utilization Report', 105, 35, { align: 'center' });
            
            doc.setFontSize(12);
            doc.setTextColor(107, 114, 128);
            doc.text('Generated on: ' + new Date().toLocaleDateString('en-US', { 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            }), 105, 45, { align: 'center' });

            // Add separator line
            doc.setDrawColor(59, 130, 246);
            doc.setLineWidth(0.5);
            doc.line(20, 50, 190, 50);
            
            html2canvas(content, {
                scale: 0.6,
                useCORS: true,
                logging: false,
                letterRendering: true,
                allowTaint: true,
                backgroundColor: '#fff',
                onclone: function(clonedDoc) {
                    // Hide elements that shouldn't be in PDF
                    const elementsToHide = clonedDoc.querySelectorAll('.btn-toolbar, .chart-controls, .table-actions, .bills-controls');
                    elementsToHide.forEach(el => el.style.display = 'none');
                }
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                
                const imgHeight = canvas.height * 210 / canvas.width;
                let heightLeft = imgHeight;
                let position = 55;
                let pageOffset = 0;
                
                doc.addImage(imgData, 'PNG', 0, position, 210, imgHeight, '', 'FAST');
                heightLeft -= (297 - position);
                pageOffset += (297 - position);
                
                while (heightLeft > 0) {
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 0, -(pageOffset), 210, imgHeight, '', 'FAST');
                    heightLeft -= 297;
                    pageOffset += 297;
                }
                
                // Add footer to each page
                const totalPages = doc.internal.getNumberOfPages();
                for (let i = 1; i <= totalPages; i++) {
                    doc.setPage(i);
                    doc.setFontSize(10);
                    doc.setTextColor(107, 114, 128);
                    doc.text(`Page ${i} of ${totalPages}`, 195, 285, { align: 'right' });
                    doc.text('MDC ProCollege System - Fund Utilization Report', 15, 285);
                }
                
                doc.save(`fund-utilization-report-${new Date().toISOString().slice(0, 10)}.pdf`);
                
                // Restore button
                btn.innerHTML = originalText;
                btn.disabled = false;
                
                // Show success notification
                showNotification('PDF exported successfully!', 'success');
            }).catch(error => {
                console.error('Error generating PDF:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;
                showNotification('Error generating PDF. Please try again.', 'error');
            });
        });

        // Refresh Data Functionality
        document.getElementById('refresh-data').addEventListener('click', function() {
            const btn = this;
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<i class="bi bi-arrow-repeat me-1 fa-spin"></i> Refreshing...';
            btn.disabled = true;
            
            // Add loading animation to cards
            const cards = document.querySelectorAll('.modern-stat-card');
            cards.forEach(card => {
                card.style.opacity = '0.6';
                card.style.transform = 'scale(0.98)';
            });
            
            // Simulate data refresh (replace with actual AJAX call)
            setTimeout(() => {
                cards.forEach(card => {
                    card.style.opacity = '1';
                    card.style.transform = 'scale(1)';
                });
                
                btn.innerHTML = originalText;
                btn.disabled = false;
                
                showNotification('Data refreshed successfully!', 'success');
                
                // Re-trigger animations
                progressBars.forEach(bar => {
                    const progressValue = bar.style.getPropertyValue('--progress');
                    bar.style.setProperty('--progress', '0%');
                    setTimeout(() => {
                        bar.style.setProperty('--progress', progressValue);
                    }, 100);
                });
            }, 2000);
        });

        // Enhanced Card Hover Effects
        const cards = document.querySelectorAll('.modern-card, .quarterly-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-6px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Notification System
        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show position-fixed`;
            notification.style.cssText = `
                top: 80px;
                right: 20px;
                z-index: 9999;
                min-width: 300px;
                box-shadow: var(--shadow-lg);
                border: none;
                border-radius: var(--radius-md);
            `;
            
            notification.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-triangle'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 5000);
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }
            
            .fa-spin {
                animation: fa-spin 1s infinite linear;
            }
            
            @keyframes fa-spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection 