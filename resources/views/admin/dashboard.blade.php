@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Dashboard</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-primary">Export</button>
                <button type="button" class="btn btn-sm btn-outline-secondary">Print</button>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
                <i class="bi bi-calendar3"></i>
                This week
            </button>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Admins</h6>
                            <div class="h2 mb-0">{{ $adminCount ?? 0 }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-people-fill"></i>
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
            <div class="card bg-success text-white mb-4 h-100">
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
                <div class="card-footer d-flex align-items-center justify-content-between bg-success bg-opacity-75">
                    <a class="small text-white stretched-link" href="{{ route('admin.colleges.index') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Users</h6>
                            <div class="h2 mb-0">{{ $userCount ?? 0 }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-danger bg-opacity-75">
                    <a class="small text-white stretched-link" href="{{ route('admin.users.index') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-uppercase mb-1 opacity-75">Bills</h6>
                            <div class="h2 mb-0">{{ $billCount ?? 0 }}</div>
                            <div class="small mt-2">
                                <span class="badge bg-warning text-dark">{{ $pendingBillCount ?? 0 }} Pending</span>
                                <span class="badge bg-success">{{ $approvedBillCount ?? 0 }} Approved</span>
                            </div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-receipt"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between bg-warning bg-opacity-75">
                    <a class="small text-white stretched-link" href="{{ route('admin.bills.index') }}">View Details</a>
                    <div class="small text-white"><i class="bi bi-arrow-right"></i></div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Funding Overview Cards -->
    <div class="row mb-4">
        <!-- <div class="col-lg-6 mb-4">
            <div class="card h-100 bg-success text-white shadow">
                <div class="card-header bg-success border-0 py-3">
                    <h5 class="mb-0 fw-bold text-white"><i class="bi bi-graph-up me-2"></i> Fund Utilization</h5>
                </div>
                <div class="card-body px-4 py-4">
                    <div class="display-3 mb-3 fw-bold text-center">{{ $utilizationPercent ?? 0 }}%</div>
                    <div class="progress mb-4 bg-light bg-opacity-25" style="height: 12px; border-radius: 6px;">
                        <div class="progress-bar bg-white" role="progressbar" style="width: {{ $utilizationPercent ?? 0 }}%; border-radius: 6px;" aria-valuenow="{{ $utilizationPercent ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <div class="text-center p-2">
                            <div class="text-uppercase opacity-75 mb-1 small">Released:</div>
                            <div class="fs-4 fw-bold">₹{{ number_format($releasedAmount ?? 0, 2) }} Cr</div>
                        </div>
                        <div class="text-center p-2">
                            <div class="text-uppercase opacity-75 mb-1 small">Utilized:</div>
                            <div class="fs-4 fw-bold">₹{{ number_format($utilizedAmount ?? 0, 2) }} Cr</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->
        
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lightning-charge me-1"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('admin.bills.index') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <i class="bi bi-receipt me-2 text-primary"></i>
                            <div>
                                <div class="fw-bold">Pending Bills</div>
                                <div class="small text-muted">Review and approve college bills</div>
                            </div>
                            <span class="badge bg-warning text-dark ms-auto">{{ $pendingBillCount ?? 0 }}</span>
                        </a>
                        <a href="{{ route('admin.colleges.index') }}" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <i class="bi bi-building me-2 text-success"></i>
                            <div>
                                <div class="fw-bold">Manage Colleges</div>
                                <div class="small text-muted">View and manage college records</div>
                            </div>
                        </a>
                        <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                            <i class="bi bi-file-earmark-bar-graph me-2 text-danger"></i>
                            <div>
                                <div class="fw-bold">Generate Reports</div>
                                <div class="small text-muted">Create utilization reports</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fund Utilization Trends Chart -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-graph-up me-1"></i>
                        Fund Utilization Trends
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#">Last 6 Months</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                            <li><a class="dropdown-item" href="#">All Time</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="utilizationChart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-pie-chart me-1"></i>
                    Funding Distribution
                </div>
                <div class="card-body">
                    <canvas id="fundingTypeChart" height="260"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- College-wise Fund Utilization -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-list-columns me-1"></i>
                        College-wise Fund Utilization
                    </div>
                    <a href="{{ route('admin.colleges.index') }}" class="btn btn-sm btn-outline-primary">
                        View All Colleges
                    </a>
                </div>
                <div class="card-body">
                    @if(isset($collegeUtilization) && count($collegeUtilization) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>College</th>
                                        <th>Type</th>
                                        <th>Approved (₹ Cr)</th>
                                        <th>Released (₹ Cr)</th>
                                        <th>Utilized (₹ Cr)</th>
                                        <th>Release %</th>
                                        <th>Utilization %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($collegeUtilization as $college)
                                        <tr>
                                            <td>{{ $college->college_name }}</td>
                                            <td>
                                                <span class="badge {{ $college->type == 'professional' ? 'bg-primary' : 'bg-success' }}">
                                                    {{ ucfirst($college->type) }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($college->total_approved, 2) }}</td>
                                            <td>{{ number_format($college->total_released, 2) }}</td>
                                            <td>{{ number_format($college->total_utilized, 2) }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                        <div class="progress-bar bg-primary" role="progressbar" 
                                                             style="width: {{ $college->release_percent }}%"></div>
                                                    </div>
                                                    <span>{{ $college->release_percent }}%</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                        <div class="progress-bar {{ $college->utilization_percent >= 90 ? 'bg-success' : 'bg-info' }}" 
                                                             role="progressbar" style="width: {{ $college->utilization_percent }}%"></div>
                                                    </div>
                                                    <span>{{ $college->utilization_percent }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-building display-4 text-muted"></i>
                            <p class="lead mt-3">No college utilization data available</p>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Utilization Chart
        const utilizationCtx = document.getElementById('utilizationChart').getContext('2d');
        new Chart(utilizationCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['labels'] ?? []) !!},
                datasets: [{
                    label: 'Monthly Fund Utilization (₹ Cr)',
                    data: {!! json_encode($chartData['data'] ?? []) !!},
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
        
        // Funding Type Distribution Chart
        @if(isset($fundingTypeData) && count($fundingTypeData) > 0)
        const fundingTypeCtx = document.getElementById('fundingTypeChart').getContext('2d');
        new Chart(fundingTypeCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($fundingTypeData->pluck('funding_type')->toArray()) !!},
                datasets: [{
                    data: {!! json_encode($fundingTypeData->pluck('total_amount')->toArray()) !!},
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.7)',
                        'rgba(0, 123, 255, 0.7)',
                        'rgba(255, 193, 7, 0.7)',
                        'rgba(220, 53, 69, 0.7)',
                        'rgba(108, 117, 125, 0.7)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Funding Distribution by Type'
                    }
                }
            }
        });
        @endif
    });
</script>
@endsection 