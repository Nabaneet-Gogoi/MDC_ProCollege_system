@extends('rusa.layouts.app')

@section('title', 'College Details')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">College Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('rusa.colleges') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Colleges
            </a>
            <div class="btn-group ms-2">
                <a href="{{ route('rusa.colleges.print', $college->college_id) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer"></i> Print
                </a>
            </div>
        </div>
    </div>

    <!-- College Information Card -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>College Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-muted">College Name</h6>
                                    <h5>{{ $college->college_name }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-muted">Type</h6>
                                    <h5>{{ $college->type }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-muted">Phase</h6>
                                    <h5>{{ $college->phase }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-muted">State</h6>
                                    <h5>{{ $college->state }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="card border-0 bg-light mb-3">
                                <div class="card-body">
                                    <h6 class="text-muted">District</h6>
                                    <h5>{{ $college->district }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Funding Summary -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Funding Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-bg-primary mb-3">
                                <div class="card-header">Total Approved Amount</div>
                                <div class="card-body">
                                    <h5 class="card-title">₹ {{ number_format($fundingStats['total_approved'], 2) }} Crores</h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-bg-success mb-3">
                                <div class="card-header">Total Released Amount</div>
                                <div class="card-body">
                                    <h5 class="card-title">₹ {{ number_format($fundingStats['total_released'], 2) }} Crores</h5>
                                    <p class="card-text">{{ $fundingStats['release_percent'] }}% of approved funding</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-bg-info mb-3">
                                <div class="card-header">Total Utilized Amount</div>
                                <div class="card-body">
                                    <h5 class="card-title">₹ {{ number_format($fundingStats['total_utilized'], 2) }} Crores</h5>
                                    <p class="card-text">{{ $fundingStats['utilization_percent'] }}% of approved funding</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progress Bars -->
                    <div class="mb-4">
                        <h6>Fund Release Progress</h6>
                        <div class="progress mb-2" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar"
                                 style="width: {{ $fundingStats['release_percent'] }}%"
                                 aria-valuenow="{{ $fundingStats['release_percent'] }}" 
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        
                        <h6>Fund Utilization Progress</h6>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar bg-info" role="progressbar"
                                 style="width: {{ $fundingStats['utilization_percent'] }}%"
                                 aria-valuenow="{{ $fundingStats['utilization_percent'] }}" 
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    
                    <!-- Funding Details -->
                    @if(count($college->fundings) > 0)
                        <h6>Funding Details</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
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
                                                    <span class="badge text-bg-warning">Not Started</span>
                                                @elseif($funding->utilization_status == 'in_progress')
                                                    <span class="badge text-bg-primary">In Progress</span>
                                                @elseif($funding->utilization_status == 'completed')
                                                    <span class="badge text-bg-success">Completed</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No funding records found for this college.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Recent Bills and Progress Reports -->
    <div class="row">
        <!-- Recent Bills -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Recent Bills</h5>
                </div>
                <div class="card-body">
                    @if(count($recentBills) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
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
                                                    <span class="badge text-bg-warning">Pending</span>
                                                @elseif($bill->bill_status == 'approved')
                                                    <span class="badge text-bg-success">Approved</span>
                                                @elseif($bill->bill_status == 'paid')
                                                    <span class="badge text-bg-primary">Paid</span>
                                                @elseif($bill->bill_status == 'rejected')
                                                    <span class="badge text-bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-receipt display-4 text-muted"></i>
                            <p class="lead mt-3">No recent bills found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Progress Reports -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-bar-chart-line me-2"></i>Recent Progress Reports</h5>
                </div>
                <div class="card-body">
                    @if(count($progressReports) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
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
                                                <div class="progress" style="height: 8px;">
                                                    <div class="progress-bar {{ $report->completion_percent >= 90 ? 'bg-success' : 'bg-info' }}" 
                                                         role="progressbar" 
                                                         style="width: {{ $report->completion_percent }}%" 
                                                         aria-valuenow="{{ $report->completion_percent }}" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100"></div>
                                                </div>
                                                <small>{{ $report->completion_percent }}%</small>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-bar-chart-line display-4 text-muted"></i>
                            <p class="lead mt-3">No progress reports found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- College Users -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-people me-2"></i>College Users</h5>
                </div>
                <div class="card-body">
                    @if(count($college->users) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
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
                        <div class="alert alert-info">
                            No users associated with this college.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Add any specific scripts needed for this page
</script>
@endsection 