@extends('college.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Modern Dashboard Header -->
    <div class="dashboard-header compact mb-3">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <div class="header-content">
                <h1 class="dashboard-title compact mb-1">College Dashboard</h1>
                <p class="dashboard-subtitle compact mb-0">Monitor your institution's financial progress and funding utilization</p>
            </div>
            <div class="header-actions">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-modern btn-success btn-sm">
                        <i class="bi bi-download me-1"></i>Export
                    </button>
                    <button type="button" class="btn btn-modern btn-info btn-sm">
                        <i class="bi bi-printer me-1"></i>Print
                    </button>
                </div>
                <button type="button" class="btn btn-modern btn-warning btn-sm dropdown-toggle">
                    <i class="bi bi-calendar3 me-1"></i>
                    This month
                </button>
            </div>
        </div>
    </div>

    <!-- Modern Stats Cards Row -->
    <div class="row mb-3">
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="modern-stat-card compact stat-card-primary">
                <div class="stat-card-body compact">
                    <div class="stat-content compact">
                        <div class="stat-info">
                            <h6 class="stat-label compact">Total Bills</h6>
                            <div class="stat-value compact">{{ $totalBills ?? 0 }}</div>
                            <div class="stat-trend compact">
                                <i class="bi bi-arrow-up-right"></i>
                                <span>+12% from last month</span>
                        </div>
                        </div>
                        <div class="stat-icon compact">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer compact">
                    <a href="{{ route('college.bills.index') }}" class="stat-link compact">
                        View Details <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="modern-stat-card compact stat-card-success">
                <div class="stat-card-body compact">
                    <div class="stat-content compact">
                        <div class="stat-info">
                            <h6 class="stat-label compact">Total Funding</h6>
                            <div class="stat-value compact">₹{{ $totalFunding ?? '0.00' }} Cr</div>
                            <div class="stat-details compact">
                                <div class="detail-item compact">
                                    <span class="detail-label">Released:</span>
                                    <span class="detail-value">₹{{ $releasedFunding ?? '0.00' }} Cr ({{ $fundingReleasePercent ?? 0 }}%)</span>
                        </div>
                                <div class="detail-item compact">
                                    <span class="detail-label">Utilized:</span>
                                    <span class="detail-value">₹{{ $utilizedFunding ?? '0.00' }} Cr ({{ $fundingUtilizationPercent ?? 0 }}%)</span>
                                </div>
                            </div>
                        </div>
                        <div class="stat-icon compact">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer compact">
                    <a href="#" class="stat-link compact">
                        View Details <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="modern-stat-card compact stat-card-warning">
                <div class="stat-card-body compact">
                    <div class="stat-content compact">
                        <div class="stat-info">
                            <h6 class="stat-label compact">Pending Bills</h6>
                            <div class="stat-value compact">{{ $pendingBills ?? 0 }}</div>
                            <div class="stat-trend compact warning">
                                <i class="bi bi-clock"></i>
                                <span>Requires attention</span>
                        </div>
                        </div>
                        <div class="stat-icon compact">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer compact">
                    <a href="#" class="stat-link compact">
                        View Details <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-2">
            <div class="modern-stat-card compact stat-card-info">
                <div class="stat-card-body compact">
                    <div class="stat-content compact">
                        <div class="stat-info">
                            <h6 class="stat-label compact">Pending Payments</h6>
                            <div class="stat-value compact">{{ $billsNeedingPaymentRecords ?? 0 }}</div>
                            <div class="stat-trend compact">
                                <i class="bi bi-credit-card"></i>
                                <span>Ready for processing</span>
                        </div>
                        </div>
                        <div class="stat-icon compact">
                            <i class="bi bi-credit-card"></i>
                        </div>
                    </div>
                </div>
                <div class="stat-card-footer compact">
                    <a href="{{ route('college.payments.create') }}" class="stat-link compact">
                        Record Payment <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row -->
    <div class="row mb-4">
        <!-- Fund Utilization Trends - Made Larger -->
        <div class="col-lg-8 mb-4">
            <div class="modern-card chart-card">
                <div class="modern-card-header">
                    <div class="card-header-content">
                        <i class="bi bi-graph-up me-2"></i>
                        <h5 class="card-title mb-0">Fund Utilization Trends</h5>
                </div>
                    <div class="card-header-actions">
                        <button class="btn btn-sm btn-outline-light">
                            <i class="bi bi-three-dots"></i>
                        </button>
                </div>
                    </div>
                <div class="modern-card-body chart-body-large">
                    <div class="chart-container extra-large">
                        <canvas id="utilizationChart" height="350"></canvas>
                    </div>
                </div>
                <div class="modern-card-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="footer-stat">
                            <span class="stat-label">Total Approved:</span>
                            <span class="stat-value">₹{{ number_format($totalFunding, 2) }} Cr</span>
                        </div>
                        <div class="footer-stat">
                            <span class="stat-label">Total Utilized:</span>
                            <span class="stat-value">₹{{ number_format($utilizedFunding, 2) }} Cr</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar with Overview and Actions -->
        <div class="col-lg-4 mb-4">
            <!-- Fund Utilization Overview -->
            <div class="modern-card overview-card mb-3">
                <div class="modern-card-header">
                    <div class="card-header-content">
                        <i class="bi bi-pie-chart me-2"></i>
                        <h5 class="card-title mb-0">Fund Overview</h5>
                </div>
                </div>
                <div class="modern-card-body ultra-compact">
                    <div class="row">
                        <div class="col-6">
                            <div class="progress-section mini">
                                <h6 class="progress-title-mini">Released vs. Approved</h6>
                                <div class="modern-progress-circle mini" style="--progress: {{ $fundingReleasePercent }}%">
                                    <div class="progress-value-mini">{{ $fundingReleasePercent }}%</div>
                                </div>
                                <p class="progress-details-mini">₹{{ number_format($releasedFunding, 2) }} / ₹{{ number_format($totalFunding, 2) }} Cr</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="progress-section mini">
                                <h6 class="progress-title-mini">Utilized vs. Released</h6>
                                <div class="modern-progress-circle mini" style="--progress: {{ $fundingUtilizationPercent }}%">
                                    <div class="progress-value-mini">{{ $fundingUtilizationPercent }}%</div>
                                </div>
                                <p class="progress-details-mini">₹{{ number_format($utilizedFunding, 2) }} / ₹{{ number_format($releasedFunding, 2) }} Cr</p>
                            </div>
                        </div>
                    </div>
                    <div class="info-alert mini">
                        <i class="bi bi-info-circle me-1"></i>
                        <span>Updates automatically when bills are approved</span>
                </div>
            </div>
        </div>
        
            <!-- Quick Links Card -->
            <div class="modern-card quick-links-card mb-3">
                <div class="modern-card-header">
                    <div class="card-header-content">
                        <i class="bi bi-lightning-charge me-2"></i>
                        <h5 class="card-title mb-0">Quick Actions</h5>
                </div>
                </div>
                <div class="modern-card-body ultra-compact">
                    <div class="quick-links-list compact">
                        <a href="{{ route('college.bills.create') }}" class="quick-link-item enhanced compact">
                            <div class="link-icon success enhanced compact">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <span class="link-text compact">Create New Bill</span>
                            <i class="bi bi-arrow-right link-arrow"></i>
                        </a>
                        <a href="{{ route('college.bills.index') }}" class="quick-link-item enhanced compact">
                            <div class="link-icon info enhanced compact">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <span class="link-text compact">Manage Bills</span>
                            <i class="bi bi-arrow-right link-arrow"></i>
                        </a>
                        <a href="{{ route('college.bills.status.manage') }}" class="quick-link-item enhanced compact">
                            <div class="link-icon warning enhanced compact">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <span class="link-text compact">Manage Bill Status</span>
                            <i class="bi bi-arrow-right link-arrow"></i>
                        </a>
                        <a href="#" class="quick-link-item enhanced compact">
                            <div class="link-icon primary enhanced compact">
                                <i class="bi bi-cash-coin"></i>
                            </div>
                            <span class="link-text compact">View Fundings</span>
                            <i class="bi bi-arrow-right link-arrow"></i>
                        </a>
                        <a href="#" class="quick-link-item enhanced compact">
                            <div class="link-icon secondary enhanced compact">
                                <i class="bi bi-building"></i>
                            </div>
                            <span class="link-text compact">College Profile</span>
                            <i class="bi bi-arrow-right link-arrow"></i>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Funding Status Card -->
            <div class="modern-card funding-status-card">
                <div class="modern-card-header enhanced">
                    <div class="card-header-content">
                        <i class="bi bi-graph-up me-2"></i>
                        <h5 class="card-title mb-0">Funding Status</h5>
                </div>
                        </div>
                <div class="modern-card-body ultra-compact">
                    <div class="funding-progress-section mini">
                        <h6 class="progress-label mini">Utilization Progress</h6>
                        <div class="modern-progress-bar enhanced mini">
                            <div class="progress-fill utilization enhanced" style="width: {{ $fundingUtilizationPercent ?? 0 }}%;">
                                <span class="progress-text mini">{{ $fundingUtilizationPercent ?? 0 }}%</span>
                    </div>
                        </div>
                    </div>
                    
                    <div class="funding-progress-section mini">
                        <h6 class="progress-label mini">Fund Release Progress</h6>
                        <div class="modern-progress-bar enhanced mini">
                            <div class="progress-fill release enhanced" style="width: {{ $fundingReleasePercent ?? 0 }}%;">
                                <span class="progress-text mini">{{ $fundingReleasePercent ?? 0 }}%</span>
                    </div>
                    </div>
                </div>
                    
                    <div class="funding-summary mini">
                        <div class="summary-row mini">
                            <span class="summary-label mini">Approved:</span>
                            <span class="summary-value mini">₹{{ $totalFunding ?? '0.00' }} Cr</span>
            </div>
                        <div class="summary-row mini">
                            <span class="summary-label mini">Released:</span>
                            <span class="summary-value mini">₹{{ $releasedFunding ?? '0.00' }} Cr</span>
                        </div>
                        <div class="summary-row mini">
                            <span class="summary-label mini">Utilized:</span>
                            <span class="summary-value mini">₹{{ $utilizedFunding ?? '0.00' }} Cr</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bills and Payments Row -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="modern-card bills-card">
                <div class="modern-card-header">
                    <div class="card-header-content">
                        <i class="bi bi-receipt me-2"></i>
                        <h5 class="card-title mb-0">Recent Bills</h5>
                    </div>
                    <div class="card-header-actions">
                        <a href="{{ route('college.bills.create') }}" class="btn btn-modern btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Create New Bill
                    </a>
                </div>
                </div>
                <div class="modern-card-body">
                    @if(isset($recentBills) && count($recentBills) > 0)
                        <div class="modern-table-container">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Bill No</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBills as $bill)
                                        <tr>
                                            <td>
                                                <div class="bill-number">{{ $bill->bill_no }}</div>
                                            </td>
                                            <td>
                                                <div class="amount-display">₹{{ number_format($bill->bill_amt, 2) }}</div>
                                            </td>
                                            <td>
                                                <div class="date-display">{{ $bill->bill_date->format('d M Y') }}</div>
                                            </td>
                                            <td>
                                                @if($bill->bill_status == 'approved')
                                                    <span class="modern-badge success">Approved</span>
                                                @elseif($bill->bill_status == 'rejected')
                                                    <span class="modern-badge danger">Rejected</span>
                                                @elseif($bill->bill_status == 'paid')
                                                    <span class="modern-badge info">Paid</span>
                                                @else
                                                    <span class="modern-badge warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('college.bills.show', $bill->bill_id) }}" class="btn btn-modern btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <h6 class="empty-title">No bills submitted yet</h6>
                            <p class="empty-description">Start by creating your first bill to track funding utilization</p>
                            <a href="{{ route('college.bills.create') }}" class="btn btn-modern btn-success">
                                <i class="bi bi-plus-circle me-1"></i> Create Your First Bill
                            </a>
                        </div>
                    @endif
                </div>
                <div class="modern-card-footer">
                    <a href="{{ route('college.bills.index') }}" class="btn btn-modern btn-outline-secondary">
                        View All Bills
                    </a>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="modern-card payments-card">
                <div class="modern-card-header">
                    <div class="card-header-content">
                        <i class="bi bi-credit-card me-2"></i>
                        <h5 class="card-title mb-0">Recent Payments</h5>
                    </div>
                    <div class="card-header-actions">
                        <a href="{{ route('college.payments.create') }}" class="btn btn-modern btn-sm btn-info">
                            <i class="bi bi-plus-circle me-1"></i> Record Payment
                    </a>
                </div>
                </div>
                <div class="modern-card-body">
                    @if(isset($recentPayments) && count($recentPayments) > 0)
                        <div class="payments-list">
                                    @foreach($recentPayments as $payment)
                                <div class="payment-item">
                                    <div class="payment-header">
                                        <div class="payment-id">Payment #{{ $payment->payment_id }}</div>
                                        <div class="payment-amount">₹{{ number_format($payment->payment_amt, 2) }} Cr</div>
                                    </div>
                                    <div class="payment-details">
                                        <div class="detail-row">
                                            <span class="detail-label">Bill:</span>
                                            <span class="detail-value">{{ $payment->bill_no }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Date:</span>
                                            <span class="detail-value">{{ date('d M Y', strtotime($payment->payment_date)) }}</span>
                                        </div>
                                        <div class="detail-row">
                                            <span class="detail-label">Status:</span>
                                                @if($payment->payment_status == 'pending')
                                                <span class="modern-badge warning">Pending</span>
                                                @elseif($payment->payment_status == 'completed')
                                                <span class="modern-badge success">Completed</span>
                                                @else
                                                <span class="modern-badge secondary">{{ ucfirst($payment->payment_status) }}</span>
                                                @endif
                                        </div>
                                    </div>
                                    <div class="payment-actions">
                                        <a href="{{ route('college.payments.show', $payment->payment_id) }}" class="btn btn-modern btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i> View
                                        </a>
                                    </div>
                                </div>
                                    @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-credit-card"></i>
                            </div>
                            <h6 class="empty-title">No payment records found</h6>
                            <p class="empty-description">Record payments to track fund utilization</p>
                            <a href="{{ route('college.payments.create') }}" class="btn btn-modern btn-info">
                                <i class="bi bi-plus-circle me-1"></i> Record Your First Payment
                            </a>
                        </div>
                    @endif
                </div>
                <div class="modern-card-footer">
                    <a href="{{ route('college.payments.index') }}" class="btn btn-modern btn-outline-secondary">
                        View All Payments
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Detailed Funding Breakdown -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="modern-card funding-breakdown-card">
                <div class="modern-card-header">
                    <div class="card-header-content">
                        <i class="bi bi-list-columns me-2"></i>
                        <h5 class="card-title mb-0">Detailed Funding Breakdown</h5>
                </div>
                    <div class="card-header-actions">
                        <button class="btn btn-modern btn-outline-secondary btn-sm">
                            <i class="bi bi-download me-1"></i> Export
                        </button>
                    </div>
                </div>
                <div class="modern-card-body">
                    @if(count($fundingBreakdown) > 0)
                        <div class="modern-table-container">
                            <table class="modern-table funding-table">
                                <thead>
                                    <tr>
                                        <th>Funding Source</th>
                                        <th>Approved</th>
                                        <th>Released</th>
                                        <th>Utilized</th>
                                        <th>Remaining</th>
                                        <th>Utilization Progress</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fundingBreakdown as $funding)
                                        <tr>
                                            <td>
                                                <div class="funding-source">
                                                    <div class="source-name">{{ $funding['funding_name'] }}</div>
                                                    </div>
                                            </td>
                                            <td>
                                                <div class="amount-cell">₹{{ number_format($funding['approved_amt'], 2) }} Cr</div>
                                            </td>
                                            <td>
                                                <div class="amount-cell">₹{{ number_format($funding['released_amt'], 2) }} Cr</div>
                                            </td>
                                            <td>
                                                <div class="amount-cell">₹{{ number_format($funding['utilized_amt'], 2) }} Cr</div>
                                            </td>
                                            <td>
                                                <div class="amount-cell">₹{{ number_format($funding['remaining_amt'], 2) }} Cr</div>
                                            </td>
                                            <td>
                                                <div class="progress-cell">
                                                    <div class="modern-progress-bar small">
                                                        <div class="progress-fill {{ $funding['utilization_percent'] >= 90 ? 'success' : 'primary' }}" 
                                                             style="width: {{ $funding['utilization_percent'] }}%;">
                                                </div>
                                                    </div>
                                                    <span class="progress-percentage">{{ $funding['utilization_percent'] }}%</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($funding['utilization_status'] == 'completed')
                                                    <span class="modern-badge success">Completed</span>
                                                @elseif($funding['utilization_status'] == 'in_progress')
                                                    <span class="modern-badge primary">In Progress</span>
                                                @else
                                                    <span class="modern-badge secondary">Not Started</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-wallet2"></i>
                            </div>
                            <h6 class="empty-title">No funding data available</h6>
                            <p class="empty-description">Funding information will appear here once data is available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    /* Educational Theme - Primary Gradient for College System */
    :root {
        --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%);
        --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
        --warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
        --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
        --danger-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
        --secondary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        
        /* Educational Colors */
        --academic-blue: #1e3c72;
        --knowledge-blue: #2a5298;
        --wisdom-blue: #3b82f6;
        --text-primary: #1f2937;
        --text-secondary: #6b7280;
        --background: #f8fafc;
        --surface: #ffffff;
        
        /* Spacing */
        --spacing-xs: 4px;
        --spacing-sm: 8px;
        --spacing-md: 12px;
        --spacing-lg: 16px;
        --spacing-xl: 20px;
        --spacing-2xl: 24px;
        --spacing-3xl: 32px;
        
        /* Border Radius */
        --radius-sm: 8px;
        --radius-md: 12px;
        --radius-lg: 16px;
        --radius-xl: 20px;
        
        /* Shadows */
        --shadow-sm: 0 4px 12px rgba(30, 60, 114, 0.08);
        --shadow-md: 0 8px 25px rgba(30, 60, 114, 0.12);
        --shadow-lg: 0 12px 40px rgba(30, 60, 114, 0.15);
        --shadow-xl: 0 20px 60px rgba(30, 60, 114, 0.2);
    }

    /* Dashboard Header */
    .dashboard-header {
        background: var(--primary-gradient);
        border-radius: var(--radius-xl);
        padding: var(--spacing-2xl);
        color: white;
        box-shadow: var(--shadow-lg);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 30px 30px;
        opacity: 0.3;
    }

    .dashboard-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .dashboard-subtitle {
        font-size: 0.875rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    .header-actions {
        position: relative;
        z-index: 1;
    }

    /* Modern Cards */
    .modern-card {
        background: var(--surface);
        border-radius: var(--radius-xl);
        border: none;
        box-shadow: var(--shadow-md);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
    }

    .modern-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-lg);
    }

    .modern-card-header {
        background: var(--primary-gradient);
        color: white;
        padding: var(--spacing-lg) var(--spacing-xl);
        display: flex;
        justify-content: between;
        align-items: center;
        border: none;
    }

    .card-header-content {
        display: flex;
        align-items: center;
        flex: 1;
    }

    .card-title {
        font-size: 0.875rem;
        font-weight: 600;
        margin: 0;
    }

    .modern-card-body {
        padding: var(--spacing-xl);
    }

    .modern-card-footer {
        background: rgba(30, 60, 114, 0.02);
        padding: var(--spacing-md) var(--spacing-xl);
        border-top: 1px solid rgba(30, 60, 114, 0.1);
    }

    /* Stat Cards */
    .modern-stat-card {
        background: var(--surface);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        overflow: hidden;
        position: relative;
        height: 100%;
    }

    .modern-stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-card-primary { border-left: 4px solid #1e3c72; }
    .stat-card-success { border-left: 4px solid #059669; }
    .stat-card-warning { border-left: 4px solid #d97706; }
    .stat-card-info { border-left: 4px solid #0891b2; }

    .stat-card-body {
        padding: var(--spacing-lg);
    }

    .stat-content {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-secondary);
        margin-bottom: var(--spacing-sm);
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--spacing-sm);
    }

    .stat-trend {
        font-size: 0.75rem;
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        color: var(--text-secondary);
    }

    .stat-trend.warning {
        color: #d97706;
    }

    .stat-icon {
        font-size: 2rem;
        opacity: 0.3;
        color: var(--academic-blue);
    }

    .stat-details {
        margin-top: var(--spacing-sm);
    }

    .detail-item {
        font-size: 0.75rem;
        margin-bottom: var(--spacing-xs);
    }

    .detail-label {
        color: var(--text-secondary);
    }

    .detail-value {
        color: var(--text-primary);
        font-weight: 500;
    }

    .stat-card-footer {
        background: rgba(30, 60, 114, 0.02);
        padding: var(--spacing-sm) var(--spacing-lg);
    }

    .stat-link {
        color: var(--academic-blue);
        text-decoration: none;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
    }

    .stat-link:hover {
        color: var(--knowledge-blue);
        transform: translateX(2px);
    }

    /* Modern Buttons */
    .btn-modern {
        padding: 10px 20px;
        border-radius: var(--radius-md);
        font-weight: 600;
        border: none;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s ease;
        font-size: 0.8125rem;
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .btn-modern.btn-success {
        background: var(--success-gradient);
        color: white;
    }

    .btn-modern.btn-info {
        background: var(--info-gradient);
        color: white;
    }

    .btn-modern.btn-primary {
        background: var(--primary-gradient);
        color: white;
    }

    .btn-modern.btn-outline-primary {
        border: 2px solid var(--academic-blue);
        color: var(--academic-blue);
        background: transparent;
    }

    .btn-modern.btn-outline-secondary {
        border: 2px solid var(--text-secondary);
        color: var(--text-secondary);
        background: transparent;
    }

    /* Progress Elements */
    .modern-progress-circle {
        position: relative;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: conic-gradient(var(--academic-blue) calc(var(--progress) * 1%), #e5e7eb 0);
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 0 auto;
    }
    
    .modern-progress-circle::before {
        content: '';
        position: absolute;
        width: 75%;
        height: 75%;
        border-radius: 50%;
        background: white;
    }
    
    .progress-value {
        position: relative;
        font-size: 14px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .progress-section {
        text-align: center;
    }

    .progress-title {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: var(--spacing-md);
    }

    .progress-details {
        font-size: 0.75rem;
        color: var(--text-secondary);
        margin-top: var(--spacing-sm);
    }

    .modern-progress-bar {
        height: 20px;
        background: rgba(30, 60, 114, 0.1);
        border-radius: var(--radius-md);
        overflow: hidden;
        position: relative;
        margin-bottom: var(--spacing-sm);
    }

    .modern-progress-bar.small {
        height: 8px;
        margin-bottom: var(--spacing-xs);
    }

    .progress-fill {
        height: 100%;
        border-radius: var(--radius-md);
        transition: width 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    .progress-fill.utilization {
        background: var(--success-gradient);
    }

    .progress-fill.release {
        background: var(--primary-gradient);
    }

    .progress-fill.success {
        background: var(--success-gradient);
    }

    .progress-fill.primary {
        background: var(--primary-gradient);
    }
    
    .progress-text {
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
    }

    .progress-percentage {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Quick Links */
    .quick-links-list {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xs);
    }

    .quick-link-item {
        display: flex;
        align-items: center;
        padding: var(--spacing-md);
        border-radius: var(--radius-md);
        text-decoration: none;
        color: var(--text-primary);
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .quick-link-item:hover {
        background: rgba(30, 60, 114, 0.05);
        border-color: rgba(30, 60, 114, 0.1);
        transform: translateX(4px);
        color: var(--text-primary);
    }

    .link-icon {
        width: 32px;
        height: 32px;
        border-radius: var(--radius-sm);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: var(--spacing-md);
        font-size: 14px;
    }

    .link-icon.success { background: var(--success-gradient); color: white; }
    .link-icon.info { background: var(--info-gradient); color: white; }
    .link-icon.warning { background: var(--warning-gradient); color: white; }
    .link-icon.primary { background: var(--primary-gradient); color: white; }
    .link-icon.secondary { background: var(--secondary-gradient); color: white; }

    .link-text {
        flex: 1;
        font-size: 0.8125rem;
        font-weight: 500;
    }

    .link-arrow {
        opacity: 0;
        transition: all 0.3s ease;
        color: var(--academic-blue);
    }

    .quick-link-item:hover .link-arrow {
        opacity: 1;
        transform: translateX(2px);
    }

    /* Funding Status */
    .funding-progress-section {
        margin-bottom: var(--spacing-lg);
    }

    .progress-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: var(--spacing-sm);
    }

    .funding-summary {
        margin-top: var(--spacing-lg);
        padding-top: var(--spacing-lg);
        border-top: 1px solid rgba(30, 60, 114, 0.1);
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-sm);
    }

    .summary-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .summary-value {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Info Alert */
    .info-alert {
        background: rgba(30, 60, 114, 0.05);
        border: 1px solid rgba(30, 60, 114, 0.1);
        border-radius: var(--radius-md);
        padding: var(--spacing-md);
        margin-top: var(--spacing-lg);
        font-size: 0.75rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
    }

    /* Modern Tables */
    .modern-table-container {
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid rgba(30, 60, 114, 0.1);
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.8125rem;
    }

    .modern-table th {
        background: var(--primary-gradient);
        color: white;
        padding: var(--spacing-md) var(--spacing-lg);
        font-weight: 600;
        text-align: left;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .modern-table td {
        padding: var(--spacing-md) var(--spacing-lg);
        border-bottom: 1px solid rgba(30, 60, 114, 0.05);
        vertical-align: middle;
    }

    .modern-table tr:hover {
        background: rgba(30, 60, 114, 0.02);
    }

    .bill-number, .amount-display, .date-display {
        font-weight: 500;
        color: var(--text-primary);
    }

    .amount-cell {
        font-weight: 600;
        color: var(--text-primary);
    }

    .funding-source .source-name {
        font-weight: 600;
        color: var(--text-primary);
    }

    .progress-cell {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    /* Modern Badges */
    .modern-badge {
        padding: 4px 12px;
        border-radius: var(--radius-sm);
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
    }

    .modern-badge.success {
        background: var(--success-gradient);
        color: white;
    }

    .modern-badge.warning {
        background: var(--warning-gradient);
        color: white;
    }

    .modern-badge.info {
        background: var(--info-gradient);
        color: white;
    }

    .modern-badge.danger {
        background: var(--danger-gradient);
        color: white;
    }

    .modern-badge.primary {
        background: var(--primary-gradient);
        color: white;
    }

    .modern-badge.secondary {
        background: var(--secondary-gradient);
        color: white;
    }

    /* Payments List */
    .payments-list {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .payment-item {
        background: rgba(30, 60, 114, 0.02);
        border: 1px solid rgba(30, 60, 114, 0.1);
        border-radius: var(--radius-md);
        padding: var(--spacing-md);
        transition: all 0.3s ease;
    }

    .payment-item:hover {
        background: rgba(30, 60, 114, 0.05);
        border-color: rgba(30, 60, 114, 0.2);
    }

    .payment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-sm);
    }

    .payment-id {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    .payment-amount {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--academic-blue);
    }

    .payment-details {
        margin-bottom: var(--spacing-md);
    }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: var(--spacing-xs);
        font-size: 0.75rem;
    }

    .payment-actions {
        display: flex;
        justify-content: flex-end;
    }

    /* Empty States */
    .empty-state {
        text-align: center;
        padding: var(--spacing-3xl);
    }

    .empty-icon {
        font-size: 3rem;
        color: var(--text-secondary);
        opacity: 0.5;
        margin-bottom: var(--spacing-lg);
    }

    .empty-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: var(--spacing-sm);
    }

    .empty-description {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin-bottom: var(--spacing-lg);
    }

    /* Chart Container */
    .chart-container {
        background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);
        border-radius: var(--radius-md);
        border: 1px solid rgba(30, 60, 114, 0.1);
        padding: var(--spacing-md);
    }

    .footer-stat {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xs);
    }

    .footer-stat .stat-label {
        font-size: 0.75rem;
        color: rgba(255, 255, 255, 0.8);
    }

    .footer-stat .stat-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .dashboard-header {
            padding: var(--spacing-lg);
        }
        
        .dashboard-title {
            font-size: 1.5rem;
        }
        
        .modern-card-body {
            padding: var(--spacing-lg);
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
        
        .modern-progress-circle {
            width: 80px;
            height: 80px;
        }
        
        .header-actions {
            margin-top: var(--spacing-md);
        }
        
        .card-header-actions {
            display: none;
        }
    }

    @media (max-width: 992px) {
        .modern-table-container {
            overflow-x: auto;
        }
        
        .payments-list .payment-item {
            padding: var(--spacing-sm);
        }
    }

    /* Enhanced Components for Better Visibility */
    .modern-card-header.enhanced {
        background: var(--success-gradient);
        box-shadow: var(--shadow-md);
    }

    .modern-card-body.compact {
        padding: var(--spacing-lg);
    }

    .modern-card-body.chart-body {
        padding: var(--spacing-lg);
        min-height: 350px;
    }

    /* Enhanced Progress Circles - Smaller for Compact Layout */
    .modern-progress-circle.small {
        width: 80px;
        height: 80px;
    }

    .modern-progress-circle.small .progress-value {
        font-size: 12px;
        font-weight: 700;
    }

    /* Enhanced Quick Link Items for Better Visibility */
    .quick-link-item.enhanced {
        background: rgba(30, 60, 114, 0.03);
        border: 1px solid rgba(30, 60, 114, 0.1);
        margin-bottom: var(--spacing-xs);
        transition: all 0.3s ease;
    }

    .quick-link-item.enhanced:hover {
        background: rgba(30, 60, 114, 0.08);
        border-color: rgba(30, 60, 114, 0.2);
        transform: translateX(6px);
        box-shadow: 0 4px 12px rgba(30, 60, 114, 0.15);
    }

    /* Enhanced Link Icons with Better Contrast */
    .link-icon.enhanced {
        width: 36px;
        height: 36px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
        border: 2px solid rgba(255, 255, 255, 0.2);
    }

    .link-icon.success.enhanced { 
        background: var(--success-gradient);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }
    
    .link-icon.info.enhanced { 
        background: var(--info-gradient);
        box-shadow: 0 4px 12px rgba(8, 145, 178, 0.3);
    }
    
    .link-icon.warning.enhanced { 
        background: var(--warning-gradient);
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    }
    
    .link-icon.primary.enhanced { 
        background: var(--primary-gradient);
        box-shadow: 0 4px 12px rgba(30, 60, 114, 0.3);
    }
    
    .link-icon.secondary.enhanced { 
        background: var(--secondary-gradient);
        box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
    }

    /* Enhanced Progress Bars with Better Visibility */
    .modern-progress-bar.enhanced {
        height: 24px;
        background: rgba(30, 60, 114, 0.08);
        border: 1px solid rgba(30, 60, 114, 0.1);
        box-shadow: inset 0 2px 4px rgba(30, 60, 114, 0.05);
    }

    .progress-fill.enhanced {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .progress-fill.utilization.enhanced {
        background: var(--success-gradient);
        box-shadow: 0 2px 8px rgba(5, 150, 105, 0.3);
    }

    .progress-fill.release.enhanced {
        background: var(--primary-gradient);
        box-shadow: 0 2px 8px rgba(30, 60, 114, 0.3);
    }

    .progress-fill.enhanced::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.2) 50%, transparent 100%);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    /* Chart Container Enhancements */
    .chart-container.large {
        background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);
        border-radius: var(--radius-lg);
        border: 1px solid rgba(30, 60, 114, 0.08);
        padding: var(--spacing-lg);
        min-height: 300px;
        box-shadow: inset 0 2px 4px rgba(30, 60, 114, 0.02);
    }

    /* Compact Info Alert */
    .info-alert.compact {
        background: rgba(30, 60, 114, 0.06);
        border: 1px solid rgba(30, 60, 114, 0.12);
        border-radius: var(--radius-sm);
        padding: var(--spacing-sm) var(--spacing-md);
        margin-top: var(--spacing-md);
        font-size: 0.7rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
    }

    /* Enhanced Button Styles for Better Visibility */
    .btn-modern.btn-success {
        background: var(--success-gradient);
        color: white;
        border: 2px solid rgba(5, 150, 105, 0.3);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
    }

    .btn-modern.btn-success:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.35);
        border-color: rgba(5, 150, 105, 0.5);
    }

    .btn-modern.btn-info {
        background: var(--info-gradient);
        color: white;
        border: 2px solid rgba(8, 145, 178, 0.3);
        box-shadow: 0 4px 12px rgba(8, 145, 178, 0.25);
    }

    .btn-modern.btn-info:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(8, 145, 178, 0.35);
        border-color: rgba(8, 145, 178, 0.5);
    }

    .btn-modern.btn-primary {
        background: var(--primary-gradient);
        color: white;
        border: 2px solid rgba(30, 60, 114, 0.3);
        box-shadow: 0 4px 12px rgba(30, 60, 114, 0.25);
    }

    .btn-modern.btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(30, 60, 114, 0.35);
        border-color: rgba(30, 60, 114, 0.5);
    }

    .btn-modern.btn-outline-primary {
        border: 2px solid var(--academic-blue);
        color: var(--academic-blue);
        background: rgba(30, 60, 114, 0.05);
        box-shadow: 0 2px 8px rgba(30, 60, 114, 0.1);
    }

    .btn-modern.btn-outline-primary:hover {
        background: var(--primary-gradient);
        color: white;
        border-color: var(--academic-blue);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 60, 114, 0.25);
    }

    .btn-modern.btn-outline-secondary {
        border: 2px solid var(--text-secondary);
        color: var(--text-secondary);
        background: rgba(107, 114, 128, 0.05);
        box-shadow: 0 2px 8px rgba(107, 114, 128, 0.1);
    }

    .btn-modern.btn-outline-secondary:hover {
        background: var(--secondary-gradient);
        color: white;
        border-color: var(--text-secondary);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(107, 114, 128, 0.25);
    }

    /* Viewport Optimization */
    .container-fluid {
        padding-left: var(--spacing-lg);
        padding-right: var(--spacing-lg);
    }

    .row {
        margin-left: calc(-1 * var(--spacing-sm));
        margin-right: calc(-1 * var(--spacing-sm));
    }

    .row > * {
        padding-left: var(--spacing-sm);
        padding-right: var(--spacing-sm);
    }

    /* Enhanced Spacing for Better Viewport Usage */
    .funding-progress-section {
        margin-bottom: var(--spacing-md);
    }

    .funding-summary {
        margin-top: var(--spacing-md);
        padding-top: var(--spacing-md);
        border-top: 1px solid rgba(30, 60, 114, 0.1);
    }

    .summary-row {
        margin-bottom: var(--spacing-xs);
    }

    /* Enhanced Card Spacing */
    .modern-card + .modern-card {
        margin-top: 0;
    }

    /* Responsive Viewport Optimizations */
    @media (max-width: 1200px) {
        .modern-card-body.chart-body {
            min-height: 280px;
        }
        
        .chart-container.large {
            min-height: 250px;
        }
    }

    @media (max-width: 992px) {
        .col-lg-7, .col-lg-5 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .modern-card-body.chart-body {
            min-height: 300px;
            padding: var(--spacing-md);
        }
        
        .chart-container.large {
            min-height: 280px;
            padding: var(--spacing-md);
        }
    }

    @media (max-width: 768px) {
        .dashboard-header {
            padding: var(--spacing-lg);
        }
        
        .dashboard-title {
            font-size: 1.5rem;
        }
        
        .modern-card-body.compact {
            padding: var(--spacing-md);
        }
        
        .modern-card-body.chart-body {
            padding: var(--spacing-md);
            min-height: 250px;
        }
        
        .stat-value {
            font-size: 1.5rem;
        }
        
        .modern-progress-circle.small {
            width: 70px;
            height: 70px;
        }
        
        .header-actions {
            margin-top: var(--spacing-md);
        }
        
        .card-header-actions {
            display: none;
        }
        
        .link-icon.enhanced {
            width: 32px;
            height: 32px;
        }
    }

    /* Ultra Compact Layouts */
    .modern-card-body.ultra-compact {
        padding: var(--spacing-md);
    }

    .modern-card-body.chart-body-large {
        padding: var(--spacing-lg);
        min-height: 400px;
    }

    /* Mini Progress Circles */
    .modern-progress-circle.mini {
        width: 60px;
        height: 60px;
    }

    .progress-value-mini {
        position: relative;
        font-size: 10px;
        font-weight: 700;
        color: var(--text-primary);
    }

    .progress-section.mini {
        text-align: center;
        margin-bottom: var(--spacing-sm);
    }

    .progress-title-mini {
        font-size: 0.65rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: var(--spacing-xs);
    }

    .progress-details-mini {
        font-size: 0.65rem;
        color: var(--text-secondary);
        margin-top: var(--spacing-xs);
        margin-bottom: 0;
    }

    /* Compact Quick Links */
    .quick-links-list.compact {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .quick-link-item.compact {
        padding: var(--spacing-xs) var(--spacing-sm);
        margin-bottom: 0;
    }

    .link-icon.compact {
        width: 28px;
        height: 28px;
        margin-right: var(--spacing-sm);
        font-size: 12px;
    }

    .link-text.compact {
        font-size: 0.75rem;
        font-weight: 500;
    }

    /* Mini Progress Bars */
    .modern-progress-bar.mini {
        height: 18px;
        margin-bottom: var(--spacing-xs);
    }

    .progress-text.mini {
        font-size: 0.65rem;
        font-weight: 600;
    }

    /* Mini Funding Sections */
    .funding-progress-section.mini {
        margin-bottom: var(--spacing-sm);
    }

    .progress-label.mini {
        font-size: 0.65rem;
        font-weight: 600;
        color: var(--text-secondary);
        margin-bottom: var(--spacing-xs);
    }

    .funding-summary.mini {
        margin-top: var(--spacing-sm);
        padding-top: var(--spacing-sm);
        border-top: 1px solid rgba(30, 60, 114, 0.1);
    }

    .summary-row.mini {
        margin-bottom: 2px;
    }

    .summary-label.mini {
        font-size: 0.65rem;
        color: var(--text-secondary);
    }

    .summary-value.mini {
        font-size: 0.65rem;
        font-weight: 600;
        color: var(--text-primary);
    }

    /* Mini Info Alert */
    .info-alert.mini {
        background: rgba(30, 60, 114, 0.06);
        border: 1px solid rgba(30, 60, 114, 0.12);
        border-radius: var(--radius-sm);
        padding: var(--spacing-xs) var(--spacing-sm);
        margin-top: var(--spacing-sm);
        font-size: 0.65rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
    }

    /* Extra Large Chart Container */
    .chart-container.extra-large {
        background: linear-gradient(135deg, #f8faff 0%, #ffffff 100%);
        border-radius: var(--radius-lg);
        border: 1px solid rgba(30, 60, 114, 0.08);
        padding: var(--spacing-lg);
        min-height: 350px;
        box-shadow: inset 0 2px 4px rgba(30, 60, 114, 0.02);
    }

    /* Improved Card Spacing */
    .modern-card {
        margin-bottom: var(--spacing-md);
    }

    .modern-card.chart-card {
        height: fit-content;
    }

    /* Better Sidebar Organization */
    .col-lg-4 .modern-card {
        height: auto;
    }

    .col-lg-4 .modern-card:last-child {
        margin-bottom: 0;
    }

    /* Enhanced Responsive Design */
    @media (max-width: 1400px) {
        .modern-card-body.chart-body-large {
            min-height: 360px;
        }
        
        .chart-container.extra-large {
            min-height: 320px;
            padding: var(--spacing-md);
        }
    }

    @media (max-width: 1200px) {
        .col-lg-8, .col-lg-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .modern-card-body.chart-body-large {
            min-height: 300px;
        }
        
        .chart-container.extra-large {
            min-height: 280px;
        }
        
        .modern-progress-circle.mini {
            width: 70px;
            height: 70px;
        }
        
        .progress-value-mini {
            font-size: 11px;
        }
    }

    @media (max-width: 992px) {
        .modern-card-body.ultra-compact {
            padding: var(--spacing-sm);
        }
        
        .modern-card-body.chart-body-large {
            padding: var(--spacing-md);
            min-height: 280px;
        }
        
        .chart-container.extra-large {
            padding: var(--spacing-sm);
            min-height: 250px;
        }
    }

    @media (max-width: 768px) {
        .modern-card-body.chart-body-large {
            padding: var(--spacing-sm);
            min-height: 250px;
        }
        
        .modern-progress-circle.mini {
            width: 50px;
            height: 50px;
        }
        
        .progress-value-mini {
            font-size: 9px;
        }
        
        .progress-title-mini {
            font-size: 0.6rem;
        }
        
        .progress-details-mini {
            font-size: 0.6rem;
        }
        
        .link-icon.compact {
            width: 24px;
            height: 24px;
            font-size: 11px;
            margin-right: var(--spacing-xs);
        }
        
        .link-text.compact {
            font-size: 0.7rem;
        }
        
        .quick-link-item.compact {
            padding: var(--spacing-xs);
        }
    }

    /* Compact Dashboard Header */
    .dashboard-header.compact {
        padding: var(--spacing-lg);
    }

    .dashboard-title.compact {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        position: relative;
        z-index: 1;
    }

    .dashboard-subtitle.compact {
        font-size: 0.8rem;
        opacity: 0.9;
        position: relative;
        z-index: 1;
    }

    /* Compact Stat Cards */
    .modern-stat-card.compact {
        border-radius: var(--radius-md);
        box-shadow: 0 2px 8px rgba(30, 60, 114, 0.06);
    }

    .stat-card-body.compact {
        padding: var(--spacing-md);
    }

    .stat-content.compact {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: var(--spacing-sm);
    }

    .stat-label.compact {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        color: var(--text-secondary);
        margin-bottom: var(--spacing-xs);
        letter-spacing: 0.5px;
    }

    .stat-value.compact {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--spacing-xs);
        line-height: 1.2;
    }

    .stat-trend.compact {
        font-size: 0.65rem;
        display: flex;
        align-items: center;
        gap: 2px;
        color: var(--text-secondary);
    }

    .stat-icon.compact {
        font-size: 1.5rem;
        opacity: 0.3;
        color: var(--academic-blue);
        flex-shrink: 0;
    }

    .stat-details.compact {
        margin-top: var(--spacing-xs);
    }

    .detail-item.compact {
        font-size: 0.65rem;
        margin-bottom: 2px;
        line-height: 1.3;
    }

    .stat-card-footer.compact {
        background: rgba(30, 60, 114, 0.02);
        padding: var(--spacing-xs) var(--spacing-md);
    }

    .stat-link.compact {
        color: var(--academic-blue);
        text-decoration: none;
        font-size: 0.7rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s ease;
    }

    /* Compact Button Styles */
    .btn-modern.btn-sm {
        padding: 6px 12px;
        border-radius: var(--radius-sm);
        font-weight: 600;
        border: none;
        box-shadow: 0 2px 6px rgba(30, 60, 114, 0.08);
        transition: all 0.3s ease;
        font-size: 0.75rem;
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
    }

    .btn-modern.btn-sm:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(30, 60, 114, 0.15);
    }

    /* Enhanced Responsive Design for Compact Layout */
    @media (max-width: 1200px) {
        .dashboard-title.compact {
            font-size: 1.3rem;
        }
        
        .dashboard-subtitle.compact {
            font-size: 0.75rem;
        }
        
        .stat-value.compact {
            font-size: 1.2rem;
        }
        
        .stat-icon.compact {
            font-size: 1.3rem;
        }
    }

    @media (max-width: 768px) {
        .dashboard-header.compact {
            padding: var(--spacing-md);
        }
        
        .dashboard-title.compact {
            font-size: 1.2rem;
        }
        
        .dashboard-subtitle.compact {
            font-size: 0.7rem;
        }
        
        .stat-card-body.compact {
            padding: var(--spacing-sm);
        }
        
        .stat-value.compact {
            font-size: 1.1rem;
        }
        
        .stat-icon.compact {
            font-size: 1.2rem;
        }
        
        .stat-label.compact {
            font-size: 0.65rem;
        }
        
        .stat-trend.compact {
            font-size: 0.6rem;
        }
        
        .detail-item.compact {
            font-size: 0.6rem;
        }
        
        .btn-modern.btn-sm {
            padding: 4px 8px;
            font-size: 0.7rem;
        }
        
        .header-actions {
            margin-top: var(--spacing-sm);
        }
        
        .header-actions .btn-group {
            margin-bottom: var(--spacing-xs);
        }
    }

    /* Enhanced Header Button Styles for Better Visibility */
    .btn-modern.btn-sm.btn-success {
        background: var(--success-gradient);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
    }

    .btn-modern.btn-sm.btn-success:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.4);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .btn-modern.btn-sm.btn-info {
        background: var(--info-gradient);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 12px rgba(8, 145, 178, 0.3);
    }

    .btn-modern.btn-sm.btn-info:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(8, 145, 178, 0.4);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .btn-modern.btn-sm.btn-warning {
        background: var(--warning-gradient);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 4px 12px rgba(217, 119, 6, 0.3);
    }

    .btn-modern.btn-sm.btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(217, 119, 6, 0.4);
        border-color: rgba(255, 255, 255, 0.3);
    }

    /* Enhanced Button Group Styling */
    .header-actions .btn-group .btn-modern {
        border-radius: var(--radius-sm);
        margin-right: 2px;
    }

    .header-actions .btn-group .btn-modern:first-child {
        border-top-right-radius: var(--radius-sm);
        border-bottom-right-radius: var(--radius-sm);
    }

    .header-actions .btn-group .btn-modern:last-child {
        border-top-left-radius: var(--radius-sm);
        border-bottom-left-radius: var(--radius-sm);
        margin-right: 0;
    }

    /* Dropdown Toggle Styling */
    .btn-modern.dropdown-toggle::after {
        border-top: 0.3em solid;
        border-right: 0.3em solid transparent;
        border-left: 0.3em solid transparent;
        margin-left: 0.255em;
        vertical-align: 0.255em;
    }

    /* Enhanced Visibility on Different Backgrounds */
    .dashboard-header .btn-modern {
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
    }

    /* Mobile Responsive Header Buttons */
    @media (max-width: 768px) {
        .header-actions {
            width: 100%;
            justify-content: center;
            margin-top: var(--spacing-sm);
        }
        
        .header-actions .btn-group {
            margin-right: var(--spacing-sm);
            margin-bottom: 0;
        }
        
        .btn-modern.btn-sm {
            padding: 6px 10px;
            font-size: 0.7rem;
        }
        
        .header-actions .btn-modern {
            white-space: nowrap;
        }
    }

    @media (max-width: 576px) {
        .header-actions {
            flex-direction: column;
            align-items: center;
            gap: var(--spacing-xs);
        }
        
        .header-actions .btn-group {
            margin-right: 0;
            margin-bottom: var(--spacing-xs);
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Educational Theme Colors
        const primaryGradient = 'linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%)';
        const academicBlue = '#1e3c72';
        const knowledgeBlue = '#2a5298';
        const wisdomBlue = '#3b82f6';
        
        // Utilization Chart with Educational Theme
        const utilizationCtx = document.getElementById('utilizationChart').getContext('2d');
        
        // Create gradient for chart
        const gradient = utilizationCtx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, academicBlue);
        gradient.addColorStop(0.5, knowledgeBlue);
        gradient.addColorStop(1, wisdomBlue);
        
        const utilizationChart = new Chart(utilizationCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($utilizationChartData['labels'] ?? []) !!},
                datasets: [{
                    label: 'Monthly Fund Utilization (₹ Cr)',
                    data: {!! json_encode($utilizationChartData['data'] ?? []) !!},
                    backgroundColor: gradient,
                    borderColor: academicBlue,
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 12,
                                weight: '600'
                            },
                            color: '#1f2937',
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    title: {
                        display: true,
                        text: 'Fund Utilization Trend (Last 6 Months)',
                        font: {
                            size: 14,
                            weight: '700'
                        },
                        color: '#1f2937',
                        padding: {
                            top: 10,
                            bottom: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(30, 60, 114, 0.9)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: academicBlue,
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false,
                        titleFont: {
                            size: 13,
                            weight: '600'
                        },
                        bodyFont: {
                            size: 12
                        },
                        callbacks: {
                            label: function(context) {
                                return 'Utilization: ₹' + context.parsed.y.toFixed(2) + ' Cr';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (₹ Cr)',
                            font: {
                                size: 12,
                                weight: '600'
                            },
                            color: '#6b7280'
                        },
                        grid: {
                            color: 'rgba(30, 60, 114, 0.1)',
                            lineWidth: 1
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#6b7280',
                            callback: function(value) {
                                return '₹' + value;
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month',
                            font: {
                                size: 12,
                                weight: '600'
                            },
                            color: '#6b7280'
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 11
                            },
                            color: '#6b7280'
                        }
                    }
                },
                animation: {
                    duration: 1000,
                    easing: 'easeInOutQuart'
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                }
            }
        });

        // Add hover effects to stat cards
        document.querySelectorAll('.modern-stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });

        // Add smooth scroll to quick links
        document.querySelectorAll('.quick-link-item').forEach(link => {
            link.addEventListener('click', function(e) {
                // Add ripple effect
                const ripple = document.createElement('span');
                ripple.classList.add('ripple');
                this.appendChild(ripple);
                
                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });

        // Animate progress circles on load
        document.querySelectorAll('.modern-progress-circle').forEach(circle => {
            const progress = circle.style.getPropertyValue('--progress');
            circle.style.setProperty('--progress', '0%');
            
            setTimeout(() => {
                circle.style.transition = 'all 1s ease-in-out';
                circle.style.setProperty('--progress', progress);
            }, 500);
        });

        // Animate progress bars on load
        document.querySelectorAll('.progress-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            
            setTimeout(() => {
                bar.style.transition = 'width 1s ease-in-out';
                bar.style.width = width;
            }, 700);
        });
    });
</script>
@endsection 