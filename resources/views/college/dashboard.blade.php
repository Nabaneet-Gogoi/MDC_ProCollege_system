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
        <div class="col-xl-4 col-md-6">
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
        
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Total Funding</h6>
                            <div class="h2 mb-0">₹{{ $totalFunding ?? '0.00' }} Cr</div>
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
        
        <div class="col-xl-4 col-md-6">
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
                        <div class="d-flex justify-content-between">
                            <small>Total Approved: ₹{{ $totalFunding ?? '0.00' }} Cr</small>
                            <small>Used: ₹{{ $utilizedFunding ?? '0.00' }} Cr</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 