@extends('college.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">College Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-success">Export</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <i class="bi bi-calendar3"></i>
                This month
            </button>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Total Bills</h6>
                            <div class="h2 mb-0">{{ $totalBills ?? 0 }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-success bg-opacity-75">
                    <a class="small text-white stretched-link" href="{{ route('college.bills.index') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Total Funding</h6>
                            <div class="h2 mb-0">₹{{ $totalFunding ?? '0.00' }} Cr</div>
                            <div class="small mt-2">Released: ₹{{ $releasedFunding ?? '0.00' }} Cr ({{ $fundingReleasePercent ?? 0 }}%)</div>
                            <div class="small">Utilized: ₹{{ $utilizedFunding ?? '0.00' }} Cr ({{ $fundingUtilizationPercent ?? 0 }}%)</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-cash-coin"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-primary bg-opacity-75">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Pending Bills</h6>
                            <div class="h2 mb-0">{{ $pendingBills ?? 0 }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-warning bg-opacity-75">
                    <a class="small text-white stretched-link" href="#">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-info text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Pending Payments</h6>
                            <div class="h2 mb-0">{{ $billsNeedingPaymentRecords ?? 0 }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-credit-card"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-info bg-opacity-75">
                    <a class="small text-white stretched-link" href="{{ route('college.payments.create') }}">Record Payment</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Bills Card -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-receipt me-1"></i>
                        Recent Bills
                    </div>
                    <a href="{{ route('college.bills.create') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle"></i> Create New Bill
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($recentBills) && count($recentBills) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
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
                                            <td>{{ $bill->bill_no }}</td>
                                            <td>₹{{ number_format($bill->bill_amt, 2) }}</td>
                                            <td>{{ $bill->bill_date->format('d M Y') }}</td>
                                            <td>
                                                @if($bill->bill_status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($bill->bill_status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @elseif($bill->bill_status == 'paid')
                                                    <span class="badge bg-info">Paid</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('college.bills.show', $bill->bill_id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-receipt display-4 text-muted"></i>
                            <p class="lead mt-3">No bills submitted yet</p>
                            <a href="{{ route('college.bills.create') }}" class="btn btn-success">
                                <i class="bi bi-plus-circle"></i> Create Your First Bill
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="{{ route('college.bills.index') }}" class="btn btn-outline-secondary btn-sm">View All Bills</a>
                </div>
            </div>
        </div>
        
        <!-- Quick Links Card -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-lightning-charge me-1"></i>
                    Quick Links
                </div>
                <div class="card-body pb-0">
                    <div class="list-group">
                        <a href="{{ route('college.bills.create') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-plus-circle me-2 text-success"></i>
                            Create New Bill
                        </a>
                        <a href="{{ route('college.bills.index') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-receipt me-2 text-info"></i>
                            Manage Bills
                        </a>
                        <a href="{{ route('college.bills.status.manage') }}" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-pencil-square me-2 text-danger"></i>
                            Manage Bill Status
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-cash-coin me-2 text-primary"></i>
                            View Fundings
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
                            <i class="bi bi-building me-2 text-warning"></i>
                            College Profile
                        </a>
                    </div>
                </div>
                
                <!-- Funding Status Card -->
                <div class="card mx-3 mt-4 mb-3 border-success">
                    <div class="card-header bg-success text-white">
                        <i class="bi bi-graph-up me-1"></i>
                        Funding Status
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Utilization Progress</h5>
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $fundingUtilizationPercent ?? 0 }}%;" 
                                 aria-valuenow="{{ $fundingUtilizationPercent ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $fundingUtilizationPercent ?? 0 }}%
                            </div>
                        </div>
                        <!-- Add Released Amount Progress Bar -->
                        <h5 class="card-title mt-3">Fund Release Progress</h5>
                        <div class="progress mb-3" style="height: 25px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $fundingReleasePercent ?? 0 }}%;" 
                                 aria-valuenow="{{ $fundingReleasePercent ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $fundingReleasePercent ?? 0 }}%
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small>Total Approved: ₹{{ $totalFunding ?? '0.00' }} Cr</small>
                            <small>Released: ₹{{ $releasedFunding ?? '0.00' }} Cr</small>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <small>Total Released: ₹{{ $releasedFunding ?? '0.00' }} Cr</small>
                            <small>Utilized: ₹{{ $utilizedFunding ?? '0.00' }} Cr</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Payments Row -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-credit-card me-1"></i>
                        Recent Payments
                    </div>
                    <a href="{{ route('college.payments.create') }}" class="btn btn-sm btn-info">
                        <i class="bi bi-plus-circle"></i> Record New Payment
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($recentPayments) && count($recentPayments) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Payment ID</th>
                                        <th>Bill Number</th>
                                        <th>Amount (₹ Cr)</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Transaction Ref</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentPayments as $payment)
                                        <tr>
                                            <td>{{ $payment->payment_id }}</td>
                                            <td>{{ $payment->bill_no }}</td>
                                            <td>{{ number_format($payment->payment_amt, 2) }}</td>
                                            <td>{{ date('d M Y', strtotime($payment->payment_date)) }}</td>
                                            <td>
                                                @if($payment->payment_status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($payment->payment_status == 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($payment->payment_status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $payment->transaction_reference ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('college.payments.show', $payment->payment_id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-credit-card display-4 text-muted"></i>
                            <p class="lead mt-3">No payment records found</p>
                            <a href="{{ route('college.payments.create') }}" class="btn btn-info">
                                <i class="bi bi-plus-circle"></i> Record Your First Payment
                            </a>
                        </div>
                    @endif
                </div>
                <div class="card-footer bg-white border-top-0">
                    <a href="{{ route('college.payments.index') }}" class="btn btn-outline-secondary btn-sm">View All Payments</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Funding Utilization Section -->
    <div class="row">
        <!-- Utilization Chart -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-graph-up me-1"></i>
                    Fund Utilization Trends
                </div>
                <div class="card-body">
                    <canvas id="utilizationChart" height="250"></canvas>
                </div>
                <div class="card-footer bg-white">
                    <div class="d-flex justify-content-between">
                        <span>Total Approved: ₹{{ number_format($totalFunding, 2) }} Cr</span>
                        <span>Total Utilized: ₹{{ number_format($utilizedFunding, 2) }} Cr</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Utilization Summary -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-pie-chart me-1"></i>
                    Fund Utilization Overview
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-center">Released vs. Approved</h5>
                            <div class="position-relative mx-auto" style="width: 160px; height: 160px;">
                                <div class="progress-circle" style="--progress: {{ $fundingReleasePercent }}%">
                                    <div class="progress-text">{{ $fundingReleasePercent }}%</div>
                                </div>
                            </div>
                            <p class="text-center mt-2">₹{{ number_format($releasedFunding, 2) }} / ₹{{ number_format($totalFunding, 2) }} Cr</p>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-center">Utilized vs. Released</h5>
                            <div class="position-relative mx-auto" style="width: 160px; height: 160px;">
                                <div class="progress-circle" style="--progress: {{ $fundingUtilizationPercent }}%">
                                    <div class="progress-text">{{ $fundingUtilizationPercent }}%</div>
                                </div>
                            </div>
                            <p class="text-center mt-2">₹{{ number_format($utilizedFunding, 2) }} / ₹{{ number_format($releasedFunding, 2) }} Cr</p>
                        </div>
                    </div>
                    <div class="alert alert-primary" role="alert">
                        <i class="bi bi-info-circle me-1"></i> Your utilization rate updates automatically whenever a bill is approved.
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Detailed Funding Breakdown -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-list-columns me-1"></i>
                    Detailed Funding Breakdown
                </div>
                <div class="card-body">
                    @if(count($fundingBreakdown) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Funding Source</th>
                                        <th>Approved</th>
                                        <th>Released</th>
                                        <th>Utilized</th>
                                        <th>Remaining</th>
                                        <th>Utilization %</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($fundingBreakdown as $funding)
                                        <tr>
                                            <td>{{ $funding['funding_name'] }}</td>
                                            <td>₹{{ number_format($funding['approved_amt'], 2) }} Cr</td>
                                            <td>₹{{ number_format($funding['released_amt'], 2) }} Cr</td>
                                            <td>₹{{ number_format($funding['utilized_amt'], 2) }} Cr</td>
                                            <td>₹{{ number_format($funding['remaining_amt'], 2) }} Cr</td>
                                            <td>
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar {{ $funding['utilization_percent'] >= 90 ? 'bg-success' : 'bg-primary' }}" 
                                                         role="progressbar" style="width: {{ $funding['utilization_percent'] }}%;" 
                                                         aria-valuenow="{{ $funding['utilization_percent'] }}" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <small>{{ $funding['utilization_percent'] }}%</small>
                                            </td>
                                            <td>
                                                @if($funding['utilization_status'] == 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($funding['utilization_status'] == 'in_progress')
                                                    <span class="badge bg-primary">In Progress</span>
                                                @else
                                                    <span class="badge bg-secondary">Not Started</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-wallet2 display-4 text-muted"></i>
                            <p class="lead mt-3">No funding data available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
    .progress-circle {
        position: relative;
        width: 100%;
        height: 100%;
        border-radius: 50%;
        background: conic-gradient(#28a745 calc(var(--progress) * 1%), #e9ecef 0);
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .progress-circle::before {
        content: '';
        position: absolute;
        width: 80%;
        height: 80%;
        border-radius: 50%;
        background: white;
    }
    
    .progress-text {
        position: relative;
        font-size: 22px;
        font-weight: bold;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Utilization Chart
        const utilizationCtx = document.getElementById('utilizationChart').getContext('2d');
        const utilizationChart = new Chart(utilizationCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($utilizationChartData['labels'] ?? []) !!},
                datasets: [{
                    label: 'Monthly Fund Utilization (₹ Cr)',
                    data: {!! json_encode($utilizationChartData['data'] ?? []) !!},
                    backgroundColor: 'rgba(40, 167, 69, 0.7)',
                    borderColor: 'rgba(40, 167, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Amount (₹ Cr)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Fund Utilization Trend (Last 6 Months)'
                    }
                }
            }
        });
    });
</script>
@endsection 