@extends('college.layouts.app')

@section('title', 'Fund Utilization')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Fund Utilization Statistics</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-success" id="export-pdf">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-success h-100">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-currency-rupee me-1"></i> Total Funding
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="display-6 fw-bold">₹{{ number_format($totalFunding, 2) }} Cr</div>
                        <div class="fs-1 text-success opacity-25">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Released:</span>
                            <span class="fw-bold">₹{{ number_format($releasedFunding, 2) }} Cr</span>
                        </div>
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $fundingReleasePercent }}%;" 
                                aria-valuenow="{{ $fundingReleasePercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Release Progress:</span>
                            <span class="fw-bold">{{ $fundingReleasePercent }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card border-primary h-100">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-graph-up me-1"></i> Fund Utilization
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="display-6 fw-bold">₹{{ number_format($utilizedFunding, 2) }} Cr</div>
                        <div class="fs-1 text-primary opacity-25">
                            <i class="bi bi-bar-chart"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Released Funds:</span>
                            <span class="fw-bold">₹{{ number_format($releasedFunding, 2) }} Cr</span>
                        </div>
                        <div class="progress mb-3" style="height: 10px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $fundingUtilizationPercent }}%;" 
                                aria-valuenow="{{ $fundingUtilizationPercent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span>Utilization Progress:</span>
                            <span class="fw-bold">{{ $fundingUtilizationPercent }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-4 col-md-12 mb-4">
            <div class="card border-warning h-100">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-arrow-left-right me-1"></i> Available vs Utilized
                </div>
                <div class="card-body text-center">
                    <div class="position-relative mx-auto" style="max-width: 200px; height: 200px;">
                        <div class="progress-circle" style="--progress: {{ $fundingUtilizationPercent }}%">
                            <div class="progress-text text-center">
                                <div class="fs-1 fw-bold">{{ $fundingUtilizationPercent }}%</div>
                                <div class="small">Utilized</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mt-2">
                            <div>
                                <div class="small text-muted">Available Funds</div>
                                <div class="fs-5">₹{{ number_format($releasedFunding - $utilizedFunding, 2) }} Cr</div>
                            </div>
                            <div>
                                <div class="small text-muted">Utilized Funds</div>
                                <div class="fs-5">₹{{ number_format($utilizedFunding, 2) }} Cr</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mb-4">
        <!-- Monthly Utilization Chart -->
        <div class="col-lg-10 mx-auto mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-graph-up me-1"></i>
                    Monthly Fund Utilization Trend
                </div>
                <div class="card-body py-3">
                    <canvas id="monthlyUtilizationChart" height="180"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Quarterly Utilization Stats -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-calendar-range me-1"></i>
                    Quarterly Utilization Analysis
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($quarterlyData as $index => $quarter)
                            @if($quarter['amount'] > 0)
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 {{ $index % 2 == 0 ? 'border-primary' : 'border-success' }}">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">{{ $quarter['period'] }}</h5>
                                            <div class="display-6 fw-bold mb-2">₹{{ number_format($quarter['amount'], 2) }}</div>
                                            <div class="text-muted">Funds Utilized</div>
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
    
    <!-- Detailed Funding Breakdown -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-list-columns me-1"></i>
                        Detailed Funding Breakdown
                    </div>
                </div>
                <div class="card-body">
                    @if(count($fundingBreakdown) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Type</th>
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
                                            <td>{{ $funding['funding_type'] }}</td>
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
    
    <!-- Bills Utilization History -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-receipt me-1"></i>
                        Bills Utilization History
                    </div>
                </div>
                <div class="card-body">
                    @if(count($bills) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Bill No</th>
                                        <th>Funding Source</th>
                                        <th>Date</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bills as $bill)
                                        <tr>
                                            <td>{{ $bill->bill_no }}</td>
                                            <td>{{ $bill->funding->funding_name }}</td>
                                            <td>{{ $bill->bill_date->format('d M Y') }}</td>
                                            <td>₹{{ number_format($bill->bill_amt, 2) }} Cr</td>
                                            <td>
                                                @if($bill->bill_status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($bill->bill_status == 'paid')
                                                    <span class="badge bg-info">Paid</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('college.bills.show', $bill->bill_id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i> View
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
                            <p class="lead mt-3">No bills utilization history available</p>
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
        width: 70%;
        height: 70%;
        border-radius: 50%;
        background: white;
    }
    
    .progress-text {
        position: relative;
        z-index: 1;
    }
    
    @media print {
        .sidebar, .navbar, .btn-toolbar {
            display: none !important;
        }
        
        .content {
            margin-left: 0 !important;
            padding: 0 !important;
        }
        
        .card {
            break-inside: avoid;
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
        // Monthly Utilization Chart
        const monthlyCtx = document.getElementById('monthlyUtilizationChart').getContext('2d');
        new Chart(monthlyCtx, {
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
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `₹${context.raw.toFixed(2)} Cr`;
                            }
                        }
                    }
                }
            }
        });
        
        // PDF Export Functionality
        document.getElementById('export-pdf').addEventListener('click', function() {
            window.scrollTo(0, 0);
            const { jsPDF } = window.jspdf;
            
            const doc = new jsPDF('p', 'mm', 'a4');
            const content = document.querySelector('.content');
            
            // First page - title
            doc.setFontSize(22);
            doc.text('Fund Utilization Report', 105, 20, { align: 'center' });
            doc.setFontSize(12);
            doc.text('Generated on: ' + new Date().toLocaleDateString(), 105, 30, { align: 'center' });
            
            html2canvas(content, {
                scale: 0.58, // Lower scale for better quality
                useCORS: true,
                logging: false,
                letterRendering: true,
                allowTaint: true,
                backgroundColor: '#fff'
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                
                // Calculate number of pages needed
                const imgHeight = canvas.height * 210 / canvas.width;
                let heightLeft = imgHeight;
                let position = 40; // Start after title
                let pageOffset = 0;
                
                // Add first page content
                doc.addImage(imgData, 'PNG', 0, position, 210, imgHeight, '', 'FAST');
                heightLeft -= (297 - position);
                pageOffset += (297 - position);
                
                // Add additional pages as needed
                while (heightLeft > 0) {
                    doc.addPage();
                    doc.addImage(imgData, 'PNG', 0, -(pageOffset), 210, imgHeight, '', 'FAST');
                    heightLeft -= 297;
                    pageOffset += 297;
                }
                
                doc.save('fund-utilization-report.pdf');
            });
        });
    });
</script>
@endsection 