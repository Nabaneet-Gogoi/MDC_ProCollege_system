@extends('rusa.layouts.app')

@section('title', 'RUSA Dashboard')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">RUSA Monitoring Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-file-earmark-excel"></i> Export
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
            <div class="dropdown">
                <button id="periodFilter" type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1" data-bs-toggle="dropdown" aria-expanded="false">
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

    <!-- Overview Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 bg-primary text-white stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Colleges</h6>
                            <div class="h2 mb-0">{{ $collegeCount ?? 0 }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-building-fill"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-opacity-75" style="background-color: rgba(255,255,255,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('rusa.colleges') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 bg-success text-white stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Approved Funding</h6>
                            <div class="h2 mb-0">₹ {{ number_format($fundingStats->total_approved ?? 0, 2) }} Cr</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-opacity-75" style="background-color: rgba(255,255,255,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('rusa.utilization') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 bg-warning text-dark stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Bills Submitted</h6>
                            <div class="h2 mb-0">{{ $billCount ?? 0 }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-opacity-75" style="background-color: rgba(0,0,0,0.1);">
                    <a class="small text-dark stretched-link" href="{{ route('rusa.bills') }}">View Details</a>
                    <div class="small text-dark"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-0 bg-info text-white stat-card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Payments</h6>
                            <div class="h2 mb-0">{{ $paymentCount ?? 0 }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-credit-card"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-opacity-75" style="background-color: rgba(255,255,255,0.1);">
                    <a class="small text-white stretched-link" href="{{ route('rusa.payments') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Fund Utilization Progress -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between bg-white">
                    <h5 class="mb-0"><i class="bi bi-bar-chart-fill me-2"></i>Overall Fund Utilization</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="d-flex flex-column">
                                <span class="text-muted">Total Approved</span>
                                <h3 class="mb-0">₹ {{ number_format($fundingStats->total_approved ?? 0, 2) }} Cr</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column">
                                <span class="text-muted">Total Released</span>
                                <h3 class="mb-0">₹ {{ number_format($releasedAmount ?? 0, 2) }} Cr</h3>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="d-flex flex-column">
                                <span class="text-muted">Total Utilized</span>
                                <h3 class="mb-0">₹ {{ number_format($utilizedAmount ?? 0, 2) }} Cr</h3>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>Fund Release Progress</span>
                            <span class="text-primary">
                                @if(isset($fundingStats->total_approved) && $fundingStats->total_approved > 0)
                                    {{ number_format(($releasedAmount / $fundingStats->total_approved) * 100, 2) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                        <div class="progress mb-3">
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
                            <span>Fund Utilization Progress</span>
                            <span class="text-success">
                                @if(isset($fundingStats->total_approved) && $fundingStats->total_approved > 0)
                                    {{ number_format(($utilizedAmount / $fundingStats->total_approved) * 100, 2) }}%
                                @else
                                    0%
                                @endif
                            </span>
                        </div>
                        <div class="progress">
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
    
    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between bg-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Fund Utilization Trends</h5>
                </div>
                <div class="card-body">
                    <canvas id="utilizationChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between bg-white">
                    <h5 class="mb-0"><i class="bi bi-pie-chart-fill me-2"></i>Funding Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="fundingTypeChart" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Activity -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between bg-white">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Recent Bills</h5>
                    <a href="{{ route('rusa.bills') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if(isset($recentBills) && count($recentBills) > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bill No</th>
                                        <th>College</th>
                                        <th>Amount (₹ Cr)</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBills as $bill)
                                        <tr>
                                            <td>{{ $bill->bill_no }}</td>
                                            <td>{{ $bill->college->college_name }}</td>
                                            <td>{{ number_format($bill->bill_amt, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</td>
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
        
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header d-flex justify-content-between bg-white">
                    <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Recent Payments</h5>
                    <a href="{{ route('rusa.payments') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if(isset($recentPayments) && count($recentPayments) > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bill</th>
                                        <th>College</th>
                                        <th>Amount (₹ Cr)</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPayments as $payment)
                                        <tr>
                                            <td>{{ $payment->bill->bill_no }}</td>
                                            <td>{{ $payment->bill->college->college_name }}</td>
                                            <td>{{ number_format($payment->payment_amt, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
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
    // Handle filter selection
    document.addEventListener('DOMContentLoaded', function() {
        const periodOptions = document.querySelectorAll('.period-option');
        const selectedPeriod = document.getElementById('selectedPeriod');
        
        // Highlight current selection
        periodOptions.forEach(option => {
            if (option.textContent === selectedPeriod.textContent) {
                option.classList.add('active');
            }
        });
    });

    // Mock data for demonstration - in production this would come from the backend
    const ctx1 = document.getElementById('utilizationChart').getContext('2d');
    const utilizationChart = new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Released Funds',
                data: [12, 19, 25, 35, 42, 50],
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            },
            {
                label: 'Utilized Funds',
                data: [5, 12, 18, 25, 30, 40],
                borderColor: '#198754',
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                borderWidth: 2,
                tension: 0.3,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₹ ' + value + ' Cr';
                        }
                    }
                }
            }
        }
    });
    
    const ctx2 = document.getElementById('fundingTypeChart').getContext('2d');
    const fundingTypeChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['MDC Phase 1', 'MDC Phase 2', 'Professional'],
            datasets: [{
                data: [
                    @foreach($fundingByType as $type)
                        {{ $type->total_funding ?? 0 }},
                    @endforeach
                ],
                backgroundColor: [
                    'rgba(13, 110, 253, 0.8)',
                    'rgba(25, 135, 84, 0.8)',
                    'rgba(255, 193, 7, 0.8)'
                ],
                borderColor: [
                    'rgba(13, 110, 253, 1)',
                    'rgba(25, 135, 84, 1)',
                    'rgba(255, 193, 7, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
</script>
@endsection

@section('styles')
<style>
    .dropdown-item.active, 
    .dropdown-item:active {
        background-color: #0d6efd;
        color: white;
    }
</style>
@endsection 