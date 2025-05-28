@extends('rusa.layouts.app')

@section('title', 'RUSA Dashboard')

@section('content')
    <!-- Compact Dashboard Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-3 border-bottom animate-fade-in">
        <h1 class="h3 gradient-text mb-0">RUSA Monitoring Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-rusa">
                    <i class="bi bi-file-earmark-excel"></i> Export
                </button>
                <button type="button" class="btn btn-sm btn-rusa-secondary">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
            <div class="dropdown">
                <button id="periodFilter" type="button" class="btn btn-sm btn-outline-rusa dropdown-toggle d-flex align-items-center gap-1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-calendar3"></i>
                    <span id="selectedPeriod">{{ request('period', 'This month') }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item period-option" href="{{ route('rusa.dashboard', ['period' => 'This month']) }}">This month</a></li>
                    <li><a class="dropdown-item period-option" href="{{ route('rusa.dashboard', ['period' => 'Last month']) }}">Last month</a></li>
                    <li><a class="dropdown-item period-option" href="{{ route('rusa.dashboard', ['period' => 'Last 3 months']) }}">Last 3 months</a></li>
                    <li><a class="dropdown-item period-option" href="{{ route('rusa.dashboard', ['period' => 'Last 6 months']) }}">Last 6 months</a></li>
                    <li><a class="dropdown-item period-option" href="{{ route('rusa.dashboard', ['period' => 'This year']) }}">This year</a></li>
                    <li><a class="dropdown-item period-option" href="{{ route('rusa.dashboard', ['period' => 'All time']) }}">All time</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Enhanced Compact Stats Cards -->
    <div class="row mb-3">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card rusa-stat-card bg-primary text-white h-100">
                <div class="card-body ultra-compact">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75 compact-text">Colleges</h6>
                            <div class="h4 mb-0 fw-bold">{{ $collegeCount ?? 0 }}</div>
                            <small class="opacity-75">+2.5% from last month</small>
                        </div>
                        <div class="fs-3 opacity-50">
                            <i class="bi bi-building-fill"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-opacity-75 ultra-compact" style="background-color: rgba(255,255,255,0.1);">
                    <a class="small text-white stretched-link text-decoration-none" href="{{ route('rusa.colleges') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card rusa-stat-card bg-success text-white h-100">
                <div class="card-body ultra-compact">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75 compact-text">Approved Funding</h6>
                            <div class="h4 mb-0 fw-bold">₹ {{ number_format($fundingStats->total_approved ?? 0, 2) }} Cr</div>
                            <small class="opacity-75">85% release rate</small>
                        </div>
                        <div class="fs-3 opacity-50">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-opacity-75 ultra-compact" style="background-color: rgba(255,255,255,0.1);">
                    <a class="small text-white stretched-link text-decoration-none" href="{{ route('rusa.utilization') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card rusa-stat-card bg-warning text-dark h-100">
                <div class="card-body ultra-compact">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75 compact-text">Bills Submitted</h6>
                            <div class="h4 mb-0 fw-bold">{{ $billCount ?? 0 }}</div>
                            <small class="opacity-75">92% approval rate</small>
                        </div>
                        <div class="fs-3 opacity-50">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-opacity-75 ultra-compact" style="background-color: rgba(0,0,0,0.1);">
                    <a class="small text-dark stretched-link text-decoration-none" href="{{ route('rusa.bills') }}">View Details</a>
                    <div class="small text-dark"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card rusa-stat-card bg-info text-white h-100">
                <div class="card-body ultra-compact">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75 compact-text">Payments</h6>
                            <div class="h4 mb-0 fw-bold">{{ $paymentCount ?? 0 }}</div>
                            <small class="opacity-75">Avg. 5 days processing</small>
                        </div>
                        <div class="fs-3 opacity-50">
                            <i class="bi bi-credit-card"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-opacity-75 ultra-compact" style="background-color: rgba(255,255,255,0.1);">
                    <a class="small text-white stretched-link text-decoration-none" href="{{ route('rusa.payments') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fund Utilization Progress -->
    <div class="row mb-3">
        <div class="col-lg-12">
            <div class="card rusa-card h-100">
                <div class="card-header d-flex justify-content-between bg-white border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-bar-chart-fill me-2 text-warning"></i>Overall Fund Utilization</h5>
                    <span class="badge bg-success-gradient text-white">Real-time</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <div class="d-flex flex-column">
                                <span class="text-muted compact-text">Total Approved</span>
                                <h4 class="mb-0 gradient-text">₹ {{ number_format($fundingStats->total_approved ?? 0, 2) }} Cr</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column">
                                <span class="text-muted compact-text">Total Released</span>
                                <h4 class="mb-0 text-primary">₹ {{ number_format($releasedAmount ?? 0, 2) }} Cr</h4>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column">
                                <span class="text-muted compact-text">Total Utilized</span>
                                <h4 class="mb-0 text-success">₹ {{ number_format($utilizedAmount ?? 0, 2) }} Cr</h4>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="compact-text">Fund Release Progress</span>
                            <span class="text-primary fw-bold">
                                @if(isset($fundingStats->total_approved) && $fundingStats->total_approved > 0)
                                    {{ number_format(($releasedAmount / $fundingStats->total_approved) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                        <div class="progress mb-2" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 
                                @if(isset($fundingStats->total_approved) && $fundingStats->total_approved > 0)
                                    {{ ($releasedAmount / $fundingStats->total_approved) * 100 }}%
                                @else
                                    0%
                                @endif
                            "></div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <span class="compact-text">Fund Utilization Progress</span>
                            <span class="text-success fw-bold">
                                @if(isset($fundingStats->total_approved) && $fundingStats->total_approved > 0)
                                    {{ number_format(($utilizedAmount / $fundingStats->total_approved) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 
                                @if(isset($fundingStats->total_approved) && $fundingStats->total_approved > 0)
                                    {{ ($utilizedAmount / $fundingStats->total_approved) * 100 }}%
                                @else
                                    0%
                                @endif
                            "></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Charts Layout -->
    <div class="row mb-3">
        <div class="col-lg-6 mb-3">
            <div class="card rusa-card h-100">
                <div class="card-header d-flex justify-content-between bg-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-graph-up me-2 text-success"></i>Fund Utilization Trends
                        <small class="text-muted ms-2 compact-text">({{ request('period', 'This month') }})</small>
                    </h5>
                    <span class="badge" style="background: var(--success-gradient); color: white;">Live Data</span>
                </div>
                <div class="card-body">
                    @if(isset($monthlyTrendData) && count($monthlyTrendData['labels']) > 0)
                        <div class="chart-container" style="position: relative; height: 280px; width: 100%; overflow: hidden;">
                            <canvas id="utilizationChart" style="max-height: 280px; max-width: 100%;"></canvas>
                        </div>
                        <div class="row mt-3 pt-3 border-top">
                            <div class="col-md-6">
                                <small class="text-muted">Total Released ({{ request('period', 'This month') }})</small>
                                <h6 class="mb-0 text-primary fw-bold">₹ {{ number_format(array_sum($monthlyTrendData['released']), 2) }} Cr</h6>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Total Utilized ({{ request('period', 'This month') }})</small>
                                <h6 class="mb-0 text-success fw-bold">₹ {{ number_format(array_sum($monthlyTrendData['utilized']), 2) }} Cr</h6>
                            </div>
                        </div>
                        @if(array_sum($monthlyTrendData['released']) <= 1.5 && array_sum($monthlyTrendData['utilized']) <= 0.8)
                            <div class="alert alert-info mt-2 border-0" style="background: var(--info-gradient); color: white;">
                                <small><i class="bi bi-info-circle me-2"></i>Showing sample data - actual data will appear when fund releases and payments are recorded.</small>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-graph-up display-4 text-muted"></i>
                            <p class="lead mt-3">Unable to load chart data</p>
                            <p class="text-muted">Please try refreshing the page.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 mb-3">
            <div class="card rusa-card h-100">
                <div class="card-header d-flex justify-content-between bg-white border-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-bar-chart-fill me-2 text-primary"></i>Monthly Bills
                        <small class="text-muted ms-2 compact-text">(Last 6 months)</small>
                    </h5>
                    <span class="badge" style="background: var(--primary-gradient); color: white;">Bills</span>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 280px; width: 100%; overflow: hidden;">
                        <canvas id="monthlyBillsChart" style="max-height: 280px; max-width: 100%;"></canvas>
                    </div>
                    <div class="mt-3 pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="compact-text">Current Month Bills</span>
                            <span class="fw-bold text-primary">{{ $billCount ?? 0 }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="compact-text">Total Value</span>
                            <span class="fw-bold text-success">₹ {{ number_format($totalBillAmount ?? 0, 2) }} Cr</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 mb-3">
            <div class="card rusa-card h-100">
                <div class="card-header d-flex justify-content-between bg-white border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-pie-chart-fill me-2 text-warning"></i>Funding Distribution</h5>
                    <span class="badge" style="background: var(--warning-gradient); color: white;">By Type</span>
                </div>
                <div class="card-body ultra-compact">
                    <div class="chart-container" style="position: relative; height: 180px; width: 100%; overflow: hidden;">
                        <canvas id="fundingTypeChart" style="max-height: 180px; max-width: 100%;"></canvas>
                    </div>
                    <div class="row mt-3 pt-2">
                        <div class="col-12">
                            <div class="funding-breakdown">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="compact-text">Total Allocation</span>
                                    <span class="fw-bold text-primary">₹ {{ number_format($fundingStats->total_approved ?? 0, 2) }} Cr</span>
                                </div>
                                @if(isset($fundingByType) && count($fundingByType) > 0)
                                    <div class="funding-types">
                                        @foreach($fundingByType as $type)
                                            @if($type->total_funding > 0)
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <span class="funding-dot" style="background: 
                                                            @if($type->type == 'government') #FFE03B
                                                            @elseif($type->type == 'autonomous') #FDB813
                                                            @elseif($type->type == 'professional') #F7941D
                                                            @else #D1322D @endif;"></span>
                                                        <small class="text-muted">{{ ucfirst($type->type) }}</small>
                                                    </div>
                                                    <small class="fw-bold">₹{{ number_format($type->total_funding, 1) }}Cr</small>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="progress mt-2" style="height: 6px;">
                                <div class="progress-bar" style="background: var(--warning-gradient); width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Enhanced Recent Activity -->
    <div class="row">
        <div class="col-lg-6 mb-3">
            <div class="card rusa-card h-100">
                <div class="card-header d-flex justify-content-between bg-white border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-receipt me-2 text-primary"></i>Recent Bills</h5>
                    <a href="{{ route('rusa.bills') }}" class="btn btn-sm btn-outline-rusa">View All</a>
                </div>
                <div class="card-body ultra-compact">
                    @if(isset($recentBills) && count($recentBills) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th class="compact-text">Bill No</th>
                                        <th class="compact-text">College</th>
                                        <th class="compact-text">Amount (₹ Cr)</th>
                                        <th class="compact-text">Date</th>
                                        <th class="compact-text">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBills as $bill)
                                        <tr>
                                            <td class="compact-text">{{ $bill->bill_no }}</td>
                                            <td class="compact-text">{{ Str::limit($bill->college->college_name, 15) }}</td>
                                            <td class="compact-text fw-bold">{{ number_format($bill->bill_amt, 2) }}</td>
                                            <td class="compact-text">{{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</td>
                                            <td>
                                                @if($bill->bill_status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($bill->bill_status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($bill->bill_status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @elseif($bill->bill_status == 'paid')
                                                    <span class="badge bg-info">Paid</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-receipt-cutoff display-4 text-muted"></i>
                            <p class="lead mt-3">No recent bills</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-lg-6 mb-3">
            <div class="card rusa-card h-100">
                <div class="card-header d-flex justify-content-between bg-white border-0">
                    <h5 class="mb-0 fw-bold"><i class="bi bi-credit-card me-2 text-success"></i>Recent Payments</h5>
                    <a href="{{ route('rusa.payments') }}" class="btn btn-sm btn-outline-rusa">View All</a>
                </div>
                <div class="card-body ultra-compact">
                    @if(isset($recentPayments) && count($recentPayments) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th class="compact-text">Bill</th>
                                        <th class="compact-text">College</th>
                                        <th class="compact-text">Amount (₹ Cr)</th>
                                        <th class="compact-text">Date</th>
                                        <th class="compact-text">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPayments as $payment)
                                        <tr>
                                            <td class="compact-text">{{ $payment->bill->bill_no }}</td>
                                            <td class="compact-text">{{ Str::limit($payment->bill->college->college_name, 15) }}</td>
                                            <td class="compact-text fw-bold">{{ number_format($payment->payment_amt, 2) }}</td>
                                            <td class="compact-text">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                            <td>
                                                @if($payment->payment_status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($payment->payment_status == 'processed')
                                                    <span class="badge bg-primary">Processed</span>
                                                @elseif($payment->payment_status == 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($payment->payment_status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-credit-card-2-front display-4 text-muted"></i>
                            <p class="lead mt-3">No recent payments</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Handle filter selection with enhanced styling
    document.addEventListener('DOMContentLoaded', function() {
        const periodOptions = document.querySelectorAll('.period-option');
        const selectedPeriod = document.getElementById('selectedPeriod');
        
        // Highlight current selection
        periodOptions.forEach(option => {
            if (option.textContent === selectedPeriod.textContent) {
                option.classList.add('active');
            }
        });

        // Add smooth animations to cards
        const cards = document.querySelectorAll('.rusa-card, .rusa-stat-card');
        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
            card.classList.add('animate-fade-in');
        });
    });

    // Enhanced Fund Utilization Trend Chart
    const ctx1 = document.getElementById('utilizationChart');
    if (ctx1) {
        // Validate and prepare data
        const chartLabels = @json($monthlyTrendData['labels'] ?? []);
        const releasedData = @json($monthlyTrendData['released'] ?? []);
        const utilizedData = @json($monthlyTrendData['utilized'] ?? []);
        
        // Only create chart if we have valid data
        if (chartLabels.length > 0 && releasedData.length > 0) {
            const utilizationChart = new Chart(ctx1.getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Released Funds',
                        data: releasedData,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#0d6efd',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    },
                    {
                        label: 'Utilized Funds',
                        data: utilizedData,
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        borderWidth: 3,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#198754',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10,
                            left: 10,
                            right: 10
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                font: {
                                    size: 12,
                                    weight: '500'
                                },
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                        title: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '₹ ' + value + ' Cr';
                                },
                                font: {
                                    size: 11
                                },
                                maxTicksLimit: 6
                            },
                            title: {
                                display: true,
                                text: 'Amount (₹ Crores)',
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Time Period',
                                font: {
                                    size: 12,
                                    weight: '500'
                                }
                            },
                            ticks: {
                                font: {
                                    size: 11
                                },
                                maxTicksLimit: 8
                            },
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                                drawBorder: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    elements: {
                        point: {
                            hoverRadius: 8
                        }
                    }
                }
            });
        }
    }
    
    // Monthly Bills Bar Chart
    const ctx3 = document.getElementById('monthlyBillsChart');
    if (ctx3) {
        // Prepare monthly bills data
        const monthlyBillsData = @json($monthlyBillsData ?? []);
        console.log('Monthly Bills Data:', monthlyBillsData);
        
        let billLabels = [];
        let billAmounts = [];
        let hasMonthlyData = false;
        
        if (monthlyBillsData && monthlyBillsData.labels && monthlyBillsData.data) {
            billLabels = monthlyBillsData.labels;
            billAmounts = monthlyBillsData.data;
            hasMonthlyData = billAmounts.some(amount => amount > 0);
        }
        
        // If no real data, create sample data
        if (!hasMonthlyData) {
            billLabels = ['Jul 24', 'Aug 24', 'Sep 24', 'Oct 24', 'Nov 24', 'Dec 24'];
            billAmounts = [12.5, 18.3, 15.7, 22.1, 19.8, 16.2];
            console.log('Using sample data for monthly bills chart');
        }
        
        if (billLabels.length > 0) {
            const monthlyBillsChart = new Chart(ctx3.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: billLabels,
                    datasets: [{
                        label: 'Monthly Bills (₹ Cr)',
                        data: billAmounts,
                        backgroundColor: function(context) {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return '#0d6efd';
                            
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, 'rgba(13, 110, 253, 0.1)');
                            gradient.addColorStop(0.5, 'rgba(13, 110, 253, 0.6)');
                            gradient.addColorStop(1, 'rgba(13, 110, 253, 0.9)');
                            return gradient;
                        },
                        borderColor: '#0d6efd',
                        borderWidth: 2,
                        borderRadius: 6,
                        borderSkipped: false,
                        hoverBackgroundColor: function(context) {
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return '#0056b3';
                            
                            const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                            gradient.addColorStop(0, 'rgba(0, 86, 179, 0.2)');
                            gradient.addColorStop(1, 'rgba(0, 86, 179, 1)');
                            return gradient;
                        },
                        hoverBorderColor: '#0056b3',
                        hoverBorderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 10,
                            bottom: 10,
                            left: 5,
                            right: 5
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#2C3E50',
                            bodyColor: '#0d6efd',
                            borderColor: '#0d6efd',
                            borderWidth: 2,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                label: function(context) {
                                    return `Bills: ₹${context.formattedValue} Cr`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(13, 110, 253, 0.1)',
                                drawBorder: false
                            },
                            ticks: {
                                color: '#6C757D',
                                font: {
                                    size: 10,
                                    family: "'Inter', sans-serif"
                                },
                                maxTicksLimit: 5,
                                callback: function(value) {
                                    return '₹' + value + 'Cr';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Amount (₹ Cr)',
                                font: {
                                    size: 11,
                                    weight: '500'
                                },
                                color: '#6C757D'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#6C757D',
                                font: {
                                    size: 10,
                                    family: "'Inter', sans-serif"
                                },
                                maxRotation: 45
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    animation: {
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    },
                    elements: {
                        bar: {
                            borderWidth: 2
                        }
                    }
                }
            });
        } else {
            // Show message when no data is available
            const ctx = ctx3.getContext('2d');
            ctx.clearRect(0, 0, ctx3.width, ctx3.height);
            
            ctx.font = '12px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#6c757d';
            
            ctx.fillText('No bills data', ctx3.width / 2, ctx3.height / 2 - 8);
            ctx.fillText('available', ctx3.width / 2, ctx3.height / 2 + 8);
        }
    }
    
    // Enhanced Funding Type Chart
    const ctx2 = document.getElementById('fundingTypeChart');
    if (ctx2) {
        // Prepare funding data with proper validation
        const fundingByTypeRaw = @json($fundingByType ?? []);
        console.log('Funding By Type Data:', fundingByTypeRaw);
        
        // Process the data to ensure we have proper structure
        let chartLabels = [];
        let chartData = [];
        let hasData = false;
        
        if (fundingByTypeRaw && fundingByTypeRaw.length > 0) {
            fundingByTypeRaw.forEach(function(item) {
                if (item.total_funding && item.total_funding > 0) {
                    // Map college types to more user-friendly labels
                    let label = 'Unknown';
                    switch(item.type) {
                        case 'government':
                            label = 'Government Colleges';
                            break;
                        case 'autonomous':
                            label = 'Autonomous Colleges';
                            break;
                        case 'private':
                            label = 'Private Colleges';
                            break;
                        case 'professional':
                            label = 'Professional Colleges';
                            break;
                        default:
                            label = item.type ? item.type.charAt(0).toUpperCase() + item.type.slice(1) + ' Colleges' : 'Other Colleges';
                    }
                    
                    chartLabels.push(label);
                    chartData.push(parseFloat(item.total_funding));
                    hasData = true;
                }
            });
        }
        
        // If no real data, create sample data for demonstration
        if (!hasData) {
            chartLabels = ['Government Colleges', 'Autonomous Colleges', 'Professional Colleges'];
            chartData = [45.5, 32.8, 21.7]; // Sample funding amounts in Crores
            console.log('Using sample data for pie chart');
        }
        
        // Only create chart if we have data to display
        if (chartLabels.length > 0 && chartData.length > 0) {
            const fundingTypeChart = new Chart(ctx2.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: chartLabels,
                    datasets: [{
                        data: chartData,
                        backgroundColor: [
                            '#FFE03B', // RUSA Yellow
                            '#FDB813', // RUSA Golden
                            '#F7941D', // RUSA Orange
                            '#D1322D', // RUSA Red
                            '#667eea'  // Additional color if needed
                        ],
                        borderColor: '#fff',
                        borderWidth: 3,
                        hoverOffset: 6,
                        hoverBorderWidth: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: 15
                    },
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 11,
                                    weight: '500',
                                    family: "'Inter', sans-serif"
                                },
                                padding: 15,
                                usePointStyle: true,
                                pointStyle: 'circle',
                                color: '#2C3E50'
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.95)',
                            titleColor: '#2C3E50',
                            bodyColor: '#667eea',
                            borderColor: '#FFE03B',
                            borderWidth: 2,
                            cornerRadius: 12,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.formattedValue;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = ((context.raw / total) * 100).toFixed(1);
                                    return `${label}: ₹${value} Cr (${percentage}%)`;
                                }
                            }
                        }
                    },
                    cutout: '65%',
                    elements: {
                        arc: {
                            borderWidth: 3,
                            hoverBorderWidth: 4
                        }
                    },
                    animation: {
                        animateRotate: true,
                        animateScale: true,
                        duration: 1500,
                        easing: 'easeInOutQuart'
                    }
                }
            });
            
            // Add center text showing total funding
            const centerTextPlugin = {
                id: 'centerText',
                beforeDraw: function(chart) {
                    const ctx = chart.ctx;
                    const width = chart.width;
                    const height = chart.height;
                    const total = chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                    
                    ctx.restore();
                    ctx.save();
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    
                    // Total amount
                    ctx.font = 'bold 14px Inter, sans-serif';
                    ctx.fillStyle = '#2C3E50';
                    ctx.fillText('₹' + total.toFixed(1) + ' Cr', width / 2, height / 2 - 8);
                    
                    // Label
                    ctx.font = '11px Inter, sans-serif';
                    ctx.fillStyle = '#6C757D';
                    ctx.fillText('Total Funding', width / 2, height / 2 + 12);
                    
                    ctx.save();
                }
            };
            
            // Register the plugin
            Chart.register(centerTextPlugin);
            
        } else {
            // Show a message when no data is available
            const ctx = ctx2.getContext('2d');
            ctx.clearRect(0, 0, ctx2.width, ctx2.height);
            
            // Set styles
            ctx.font = '14px Inter, sans-serif';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            ctx.fillStyle = '#6c757d';
            
            // Draw message
            ctx.fillText('No funding data', ctx2.width / 2, ctx2.height / 2 - 10);
            ctx.font = '12px Inter, sans-serif';
            ctx.fillText('available', ctx2.width / 2, ctx2.height / 2 + 10);
        }
    }
</script>
@endsection

@section('styles')
<style>
    /* Enhanced Dropdown Styling */
    .dropdown-item.active, 
    .dropdown-item:active {
        background: var(--rusa-gradient) !important;
        color: white !important;
    }
    
    /* RUSA Gradient Backgrounds */
    .bg-success-gradient {
        background: var(--success-gradient) !important;
    }
    
    /* Enhanced Table Styling */
    .table-sm th,
    .table-sm td {
        padding: 0.5rem;
        vertical-align: middle;
    }
    
    /* Compact Badge Styling */
    .badge {
        font-size: 0.65rem;
        padding: 0.35em 0.65em;
    }
    
    /* Enhanced Card Headers */
    .card-header {
        padding: 0.75rem 1rem;
        background: rgba(255, 255, 255, 0.9) !important;
        backdrop-filter: blur(10px);
    }
    
    /* Improved Button Spacing */
    .btn-group .btn {
        margin-right: 0;
    }
    
    /* Progress Bar Enhancement */
    .progress-bar {
        background: var(--rusa-gradient) !important;
    }
    
    /* Chart Container Styling */
    .chart-container {
        position: relative !important;
        overflow: hidden !important;
        border-radius: var(--radius-md);
    }
    
    .chart-container canvas {
        border-radius: var(--radius-md);
        max-width: 100% !important;
        height: auto !important;
    }
    
    /* Ensure charts don't overflow */
    #utilizationChart {
        max-height: 300px !important;
        width: 100% !important;
    }
    
    #fundingTypeChart {
        max-height: 200px !important;
        width: 100% !important;
    }
    
    /* Enhanced stat cards */
    .stat-card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
    
    /* Prevent chart container from growing beyond bounds */
    .card-body .chart-container {
        max-width: 100%;
        max-height: 400px;
        overflow: hidden;
    }
    
    /* Responsive chart adjustments */
    @media (max-width: 768px) {
        .chart-container {
            height: 250px !important;
        }
        
        #utilizationChart {
            max-height: 250px !important;
        }
        
        #fundingTypeChart {
            max-height: 180px !important;
        }
    }
    
    /* Funding breakdown styling */
    .funding-breakdown {
        background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
        border-radius: 12px;
        padding: 12px;
        border: 1px solid rgba(255, 224, 59, 0.2);
    }
    
    .funding-types {
        margin-top: 8px;
    }
    
    .funding-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }
    
    .funding-types .d-flex:hover {
        background: rgba(255, 224, 59, 0.1);
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    /* Enhanced warning gradient */
    :root {
        --warning-gradient: linear-gradient(135deg, #FFE03B 0%, #FDB813 100%);
        --primary-gradient: linear-gradient(135deg, #0d6efd 0%, #0056b3 100%);
    }
    
    /* Chart spacing optimization for three-column layout */
    @media (max-width: 992px) {
        .col-lg-6, .col-lg-3 {
            margin-bottom: 1rem;
        }
        
        .chart-container {
            height: 220px !important;
        }
        
        #utilizationChart, #monthlyBillsChart {
            max-height: 220px !important;
        }
        
        #fundingTypeChart {
            max-height: 160px !important;
        }
    }
</style>
@endsection 