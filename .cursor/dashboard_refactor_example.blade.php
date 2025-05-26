@extends('admin.layouts.app')

@section('title', 'Dashboard Refactor Example')

@section('content')
    <div class="d-flex flex-wrap justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom gap-3">
        <h1 class="h2 mb-0">Dashboard</h1>
        <form method="GET" class="d-flex flex-wrap gap-2 align-items-center">
            <select name="type" class="form-select form-select-sm" style="width: 150px;">
                <option value="">All College Types</option>
                <option value="professional">Professional</option>
                <option value="MDC">MDC</option>
            </select>
            <select name="range" class="form-select form-select-sm" style="width: 150px;">
                <option value="last_6_months">Last 6 Months</option>
                <option value="this_year">This Year</option>
                <option value="all_time">All Time</option>
            </select>
            <button type="submit" class="btn btn-sm btn-outline-primary"><i class="bi bi-funnel"></i> Filter</button>
        </form>
    </div>

    <!-- Fund Utilization Summary -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm bg-light mb-3">
                <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-4">
                    <div>
                        <div class="text-muted">Total Approved</div>
                        <div class="display-6 fw-bold">₹12.34 Cr</div>
                    </div>
                    <div>
                        <div class="text-muted">Total Released</div>
                        <div class="display-6 fw-bold">₹10.00 Cr</div>
                        <div class="progress mt-2" style="height: 8px; width: 180px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: 81%"></div>
                        </div>
                        <div class="small text-primary mt-1">Release: 81%</div>
                    </div>
                    <div>
                        <div class="text-muted">Total Utilized</div>
                        <div class="display-6 fw-bold">₹8.50 Cr</div>
                        <div class="progress mt-2" style="height: 8px; width: 180px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 85%"></div>
                        </div>
                        <div class="small text-success mt-1">Utilization: 85%</div>
                    </div>
                    <div class="d-flex flex-column align-items-end">
                        <a href="#" class="btn btn-warning btn-lg fw-bold shadow-sm">
                            <i class="bi bi-exclamation-circle me-1"></i> Approve Pending Bills
                            <span class="badge bg-danger ms-2">3</span>
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-lg mt-2 fw-bold shadow-sm">
                            <i class="bi bi-building me-1"></i> Manage Colleges
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-graph-up me-1"></i>
                        Fund Utilization Trends
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

    <!-- College-wise Fund Utilization Table -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-list-columns me-1"></i>
                        College-wise Fund Utilization
                    </div>
                    <a href="#" class="btn btn-sm btn-outline-primary">
                        View All Colleges
                    </a>
                </div>
                <div class="card-body">
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
                                <tr>
                                    <td>ABC College</td>
                                    <td><span class="badge bg-primary">Professional</span></td>
                                    <td>5.00</td>
                                    <td>4.00</td>
                                    <td>3.50</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 80%"></div>
                                            </div>
                                            <span>80%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 88%"></div>
                                            </div>
                                            <span>88%</span>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>MDC College</td>
                                    <td><span class="badge bg-success">MDC</span></td>
                                    <td>7.34</td>
                                    <td>6.00</td>
                                    <td>5.00</td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: 82%"></div>
                                            </div>
                                            <span>82%</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                <div class="progress-bar bg-info" role="progressbar" style="width: 83%"></div>
                                            </div>
                                            <span>83%</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Utilization Chart Example
        const utilizationCtx = document.getElementById('utilizationChart');
        if(utilizationCtx) {
            new Chart(utilizationCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: ['Jan 2024', 'Feb 2024', 'Mar 2024', 'Apr 2024', 'May 2024', 'Jun 2024'],
                    datasets: [{
                        label: 'Monthly Fund Utilization (₹ Cr)',
                        data: [1.2, 1.5, 2.0, 1.8, 1.6, 2.3],
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(context) {
                                    return '₹ ' + context.parsed.y.toLocaleString('en-IN', {minimumFractionDigits: 2});
                                }
                            }
                        },
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Fund Utilization Trend (Last 6 Months)'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Amount (₹ Cr)' }
                        },
                        x: {
                            title: { display: true, text: 'Month' }
                        }
                    }
                }
            });
        }
        // Funding Type Distribution Chart Example
        const fundingTypeCtx = document.getElementById('fundingTypeChart');
        if(fundingTypeCtx) {
            new Chart(fundingTypeCtx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Professional', 'MDC'],
                    datasets: [{
                        data: [7, 5],
                        backgroundColor: [
                            'rgba(40, 167, 69, 0.7)',
                            'rgba(0, 123, 255, 0.7)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            enabled: true,
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ₹ ' + context.parsed.toLocaleString('en-IN', {minimumFractionDigits: 2});
                                }
                            }
                        },
                        legend: { position: 'bottom' },
                        title: {
                            display: true,
                            text: 'Funding Distribution by Type'
                        }
                    }
                }
            });
        }
    });
</script>
@endsection 