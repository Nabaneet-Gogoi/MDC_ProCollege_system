@extends('rusa.layouts.app')

@section('title', 'College Details')

@section('content')
<style>
:root {
    --rusa-primary: #FFE03B;
    --rusa-secondary: #FDB813;
    --rusa-tertiary: #F7941D;
    --rusa-accent: #D1322D;
    --rusa-gradient: linear-gradient(135deg, #FFE03B 0%, #FDB813 30%, #F7941D 70%, #D1322D 100%);
    --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
    --warning-gradient: linear-gradient(135deg, #FFE03B 0%, #FDB813 50%, #F7941D 100%);
    --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
    --danger-gradient: linear-gradient(135deg, #D1322D 0%, #ef4444 50%, #f87171 100%);
    --secondary-gradient: linear-gradient(135deg, #F7941D 0%, #FDB813 50%, #FFE03B 100%);
}

.rusa-header {
    background: var(--rusa-gradient);
    color: white;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 16px;
    box-shadow: 0 8px 25px rgba(253, 184, 19, 0.3);
}

.rusa-header h1 {
    font-size: 1.5rem;
    margin: 0;
    font-weight: 600;
}

.btn-rusa-primary {
    background: var(--rusa-gradient);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    font-weight: 500;
    transition: all 0.3s ease;
    backdrop-filter: blur(2px);
}

.btn-rusa-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(253, 184, 19, 0.4);
    color: white;
}

.btn-rusa-secondary {
    background: var(--secondary-gradient);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-rusa-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(247, 148, 29, 0.4);
    color: white;
}

.rusa-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    border: none;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.rusa-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
}

.rusa-card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 3px solid var(--rusa-tertiary);
    padding: 12px 20px;
    font-weight: 600;
    color: #333;
}

.rusa-info-card {
    background: linear-gradient(145deg, #f8f9fa 0%, #e9ecef 100%);
    border: none;
    border-radius: 12px;
    padding: 12px 16px;
    margin-bottom: 16px;
    border-left: 4px solid var(--rusa-gradient);
    transition: all 0.3s ease;
}

.rusa-info-card:hover {
    transform: translateX(4px);
    box-shadow: 0 4px 15px rgba(253, 184, 19, 0.2);
}

.rusa-info-card h6 {
    color: #6c757d;
    font-size: 0.7rem;
    margin-bottom: 4px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.rusa-info-card h5 {
    color: #333;
    font-size: 1.1rem;
    margin: 0;
    font-weight: 600;
}

.funding-card-primary {
    background: var(--rusa-gradient);
    border: none;
    border-radius: 12px;
    color: white;
    transition: all 0.3s ease;
}

.funding-card-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(253, 184, 19, 0.4);
}

.funding-card-success {
    background: var(--success-gradient);
    border: none;
    border-radius: 12px;
    color: white;
    transition: all 0.3s ease;
}

.funding-card-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4);
}

.funding-card-info {
    background: var(--info-gradient);
    border: none;
    border-radius: 12px;
    color: white;
    transition: all 0.3s ease;
}

.funding-card-info:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(8, 145, 178, 0.4);
}

.rusa-progress {
    height: 12px;
    border-radius: 8px;
    background: linear-gradient(90deg, #e9ecef 0%, #f8f9fa 100%);
    overflow: hidden;
    box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
}

.rusa-progress-bar {
    background: var(--rusa-gradient);
    border-radius: 8px;
    transition: width 1s ease-in-out;
    position: relative;
    overflow: hidden;
}

.rusa-progress-bar::after {
    content: '';
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

.table-rusa {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.table-rusa thead th {
    background: var(--warning-gradient);
    color: white;
    border: none;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 12px;
}

.table-rusa tbody tr {
    transition: all 0.3s ease;
}

.table-rusa tbody tr:hover {
    background: linear-gradient(135deg, #fff9e6 0%, #fff3d3 100%);
    transform: translateX(2px);
}

.rusa-badge {
    font-size: 0.75rem;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.compact-section {
    margin-bottom: 20px;
}

.compact-table {
    font-size: 0.85rem;
}

.compact-table th,
.compact-table td {
    padding: 8px 12px;
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 16px;
    opacity: 0.5;
}

.empty-state .lead {
    font-size: 1rem;
    margin: 0;
}

@media (max-width: 768px) {
    .rusa-header {
        padding: 12px 16px;
    }
    
    .rusa-header h1 {
        font-size: 1.25rem;
    }
    
    .rusa-info-card {
        padding: 10px 12px;
    }
    
    .rusa-info-card h5 {
        font-size: 1rem;
    }
}
</style>

    <div class="rusa-header d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-building me-2"></i>College Details</h1>
        <div class="btn-toolbar">
            <a href="{{ route('rusa.colleges') }}" class="btn btn-rusa-secondary btn-sm me-2">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="{{ route('rusa.colleges.print', $college->college_id) }}" target="_blank" class="btn btn-rusa-primary btn-sm">
                <i class="bi bi-printer"></i> Print
            </a>
        </div>
    </div>

    <!-- College Information Card -->
    <div class="compact-section">
        <div class="rusa-card">
            <div class="rusa-card-header">
                <i class="bi bi-building me-2"></i>College Information
            </div>
            <div class="card-body p-3">
                <div class="row">
                    <div class="col-md-4">
                        <div class="rusa-info-card">
                            <h6>College Name</h6>
                            <h5>{{ $college->college_name }}</h5>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="rusa-info-card">
                            <h6>Type</h6>
                            <h5>{{ $college->type }}</h5>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="rusa-info-card">
                            <h6>Phase</h6>
                            <h5>{{ $college->phase }}</h5>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="rusa-info-card">
                            <h6>State</h6>
                            <h5>{{ $college->state }}</h5>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="rusa-info-card">
                            <h6>District</h6>
                            <h5>{{ $college->district }}</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Funding Summary -->
    <div class="compact-section">
        <div class="rusa-card">
            <div class="rusa-card-header">
                <i class="bi bi-cash-stack me-2"></i>Funding Summary
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card funding-card-primary mb-3">
                            <div class="card-header bg-transparent border-0 pb-1">
                                <small class="opacity-75">Total Approved Amount</small>
                            </div>
                            <div class="card-body pt-0">
                                <h4 class="mb-0">₹ {{ number_format($fundingStats['total_approved'], 2) }} Cr</h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card funding-card-success mb-3">
                            <div class="card-header bg-transparent border-0 pb-1">
                                <small class="opacity-75">Total Released Amount</small>
                            </div>
                            <div class="card-body pt-0">
                                <h4 class="mb-1">₹ {{ number_format($fundingStats['total_released'], 2) }} Cr</h4>
                                <small class="opacity-75">{{ $fundingStats['release_percent'] }}% of approved</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card funding-card-info mb-3">
                            <div class="card-header bg-transparent border-0 pb-1">
                                <small class="opacity-75">Total Utilized Amount</small>
                            </div>
                            <div class="card-body pt-0">
                                <h4 class="mb-1">₹ {{ number_format($fundingStats['total_utilized'], 2) }} Cr</h4>
                                <small class="opacity-75">{{ $fundingStats['utilization_percent'] }}% of approved</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Progress Bars -->
                <div class="mb-3">
                    <h6 class="mb-2"><i class="bi bi-graph-up me-2"></i>Fund Release Progress</h6>
                    <div class="rusa-progress mb-3">
                        <div class="rusa-progress-bar" style="width: {{ $fundingStats['release_percent'] }}%"></div>
                    </div>
                    
                    <h6 class="mb-2"><i class="bi bi-speedometer2 me-2"></i>Fund Utilization Progress</h6>
                    <div class="rusa-progress">
                        <div class="rusa-progress-bar" style="width: {{ $fundingStats['utilization_percent'] }}%"></div>
                    </div>
                </div>
                
                <!-- Funding Details -->
                @if(count($college->fundings) > 0)
                    <h6 class="mb-3"><i class="bi bi-table me-2"></i>Funding Details</h6>
                    <div class="table-responsive">
                        <table class="table table-rusa compact-table mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Approved Amount</th>
                                    <th>Central Share</th>
                                    <th>State Share</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($college->fundings as $funding)
                                    <tr>
                                        <td>{{ $funding->funding_id }}</td>
                                        <td>₹ {{ number_format($funding->approved_amt, 2) }}</td>
                                        <td>₹ {{ number_format($funding->central_share, 2) }}</td>
                                        <td>₹ {{ number_format($funding->state_share, 2) }}</td>
                                        <td>
                                            @if($funding->utilization_status == 'not_started')
                                                <span class="rusa-badge text-bg-warning">Not Started</span>
                                            @elseif($funding->utilization_status == 'in_progress')
                                                <span class="rusa-badge text-bg-primary">In Progress</span>
                                            @elseif($funding->utilization_status == 'completed')
                                                <span class="rusa-badge text-bg-success">Completed</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info border-0" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <i class="bi bi-info-circle me-2"></i>No funding records found for this college.
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Bills and Progress Reports -->
    <div class="row">
        <!-- Recent Bills -->
        <div class="col-lg-6 mb-4">
            <div class="rusa-card h-100">
                <div class="rusa-card-header">
                    <i class="bi bi-receipt me-2"></i>Recent Bills
                </div>
                <div class="card-body p-3">
                    @if(count($recentBills) > 0)
                        <div class="table-responsive">
                            <table class="table table-rusa compact-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Bill No</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBills as $bill)
                                        <tr>
                                            <td>{{ $bill->bill_no }}</td>
                                            <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</td>
                                            <td>₹ {{ number_format($bill->bill_amt, 2) }}</td>
                                            <td>
                                                @if($bill->bill_status == 'pending')
                                                    <span class="rusa-badge text-bg-warning">Pending</span>
                                                @elseif($bill->bill_status == 'approved')
                                                    <span class="rusa-badge text-bg-success">Approved</span>
                                                @elseif($bill->bill_status == 'paid')
                                                    <span class="rusa-badge text-bg-primary">Paid</span>
                                                @elseif($bill->bill_status == 'rejected')
                                                    <span class="rusa-badge text-bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-receipt"></i>
                            <p class="lead">No recent bills found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Progress Reports -->
        <div class="col-lg-6 mb-4">
            <div class="rusa-card h-100">
                <div class="rusa-card-header">
                    <i class="bi bi-bar-chart-line me-2"></i>Recent Progress Reports
                </div>
                <div class="card-body p-3">
                    @if(count($progressReports) > 0)
                        <div class="table-responsive">
                            <table class="table table-rusa compact-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Work Category</th>
                                        <th>Completion %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($progressReports as $report)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($report->report_date)->format('d M Y') }}</td>
                                            <td>{{ $report->workCategory->category_name ?? 'N/A' }}</td>
                                            <td>
                                                <div class="rusa-progress mb-1" style="height: 8px;">
                                                    <div class="rusa-progress-bar" style="width: {{ $report->completion_percent }}%"></div>
                                                </div>
                                                <small>{{ $report->completion_percent }}%</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-bar-chart-line"></i>
                            <p class="lead">No progress reports found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- College Users -->
    <div class="compact-section">
        <div class="rusa-card">
            <div class="rusa-card-header">
                <i class="bi bi-people me-2"></i>College Users
            </div>
            <div class="card-body p-3">
                @if(count($college->users) > 0)
                    <div class="table-responsive">
                        <table class="table table-rusa compact-table mb-0">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Last Login</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($college->users as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->role }}</td>
                                        <td>{{ $user->last_login_at ? \Carbon\Carbon::parse($user->last_login_at)->format('d M Y, h:i A') : 'Never logged in' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info border-0" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                        <i class="bi bi-info-circle me-2"></i>No users associated with this college.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Enhanced animations and interactions
    document.addEventListener('DOMContentLoaded', function() {
        // Animate progress bars on load
        const progressBars = document.querySelectorAll('.rusa-progress-bar');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 500);
        });
        
        // Add smooth hover effects
        const cards = document.querySelectorAll('.rusa-card, .rusa-info-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = this.classList.contains('rusa-info-card') ? 'translateX(4px)' : 'translateY(-4px)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'none';
            });
        });
    });
</script>
@endsection 