<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College Details - {{ $college->college_name }} - Print</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #ddd;
        }
        .logo {
            max-height: 80px;
            margin-bottom: 15px;
        }
        h1, h2, h3, h4, h5, h6 {
            margin-bottom: 15px;
        }
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .section-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 15px;
            padding-bottom: 5px;
            border-bottom: 1px solid #ddd;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f5f5f5;
        }
        .progress {
            height: 10px;
            background-color: #f5f5f5;
            border-radius: 5px;
            margin-bottom: 5px;
        }
        .progress-bar {
            height: 100%;
            border-radius: 5px;
        }
        .bg-success {
            background-color: #198754 !important;
        }
        .bg-info {
            background-color: #0dcaf0 !important;
        }
        .stats-card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .stats-title {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }
        .stats-value {
            font-size: 20px;
            font-weight: bold;
        }
        .stats-note {
            font-size: 12px;
            color: #888;
        }
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: normal;
        }
        .text-bg-warning { background-color: #ffc107; color: #000; }
        .text-bg-primary { background-color: #0d6efd; color: #fff; }
        .text-bg-success { background-color: #198754; color: #fff; }
        .text-bg-danger { background-color: #dc3545; color: #fff; }
        .text-bg-info { background-color: #0dcaf0; color: #000; }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        @media print {
            body {
                padding: 0;
                font-size: 12px;
            }
            .print-button {
                display: none;
            }
            @page {
                size: A4;
                margin: 1cm;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="header">
            <h2>RUSA - Rashtriya Uchchatar Shiksha Abhiyan</h2>
            <h3>College Details Report</h3>
            <p>Generated on: {{ \Carbon\Carbon::now()->format('d M Y, h:i A') }}</p>
        </div>
        
        <div class="print-button text-end mb-4">
            <button onclick="window.print()" class="btn btn-primary btn-sm">
                <i class="bi bi-printer"></i> Print Report
            </button>
        </div>
        
        <!-- College Information -->
        <div class="section">
            <div class="section-title">College Information</div>
            <div class="row">
                <div class="col-12">
                    <table>
                        <tr>
                            <th width="20%">College Name</th>
                            <td width="30%">{{ $college->college_name }}</td>
                            <th width="20%">Type</th>
                            <td width="30%">{{ $college->type }}</td>
                        </tr>
                        <tr>
                            <th>Phase</th>
                            <td>{{ $college->phase }}</td>
                            <th>State</th>
                            <td>{{ $college->state }}</td>
                        </tr>
                        <tr>
                            <th>District</th>
                            <td>{{ $college->district }}</td>
                            <th>College ID</th>
                            <td>{{ $college->college_id }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Funding Summary -->
        <div class="section">
            <div class="section-title">Funding Summary</div>
            <div class="row">
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-title">Total Approved Amount</div>
                        <div class="stats-value">₹ {{ number_format($fundingStats['total_approved'], 2) }} Crores</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-title">Total Released Amount</div>
                        <div class="stats-value">₹ {{ number_format($fundingStats['total_released'], 2) }} Crores</div>
                        <div class="stats-note">{{ $fundingStats['release_percent'] }}% of approved funding</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="stats-card">
                        <div class="stats-title">Total Utilized Amount</div>
                        <div class="stats-value">₹ {{ number_format($fundingStats['total_utilized'], 2) }} Crores</div>
                        <div class="stats-note">{{ $fundingStats['utilization_percent'] }}% of approved funding</div>
                    </div>
                </div>
            </div>
            
            <!-- Progress Bars -->
            <div class="mt-4 mb-4">
                <p><strong>Fund Release Progress:</strong> {{ $fundingStats['release_percent'] }}%</p>
                <div class="progress">
                    <div class="progress-bar bg-success" style="width: {{ $fundingStats['release_percent'] }}%"></div>
                </div>
                
                <p class="mt-3"><strong>Fund Utilization Progress:</strong> {{ $fundingStats['utilization_percent'] }}%</p>
                <div class="progress">
                    <div class="progress-bar bg-info" style="width: {{ $fundingStats['utilization_percent'] }}%"></div>
                </div>
            </div>
            
            <!-- Funding Details -->
            @if(count($college->fundings) > 0)
                <div class="mt-4">
                    <h5>Funding Details</h5>
                    <table>
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
        
        <!-- Bills Section -->
        <div class="section">
            <div class="section-title">Bills History</div>
            @if(count($bills) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Bill No</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Funding ID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bills as $bill)
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
                                <td>{{ $bill->funding_id }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">
                    No bills found for this college.
                </div>
            @endif
        </div>
        
        <!-- Progress Reports Section -->
        <div class="section">
            <div class="section-title">Physical Progress Reports</div>
            @if(count($progressReports) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Work Category</th>
                            <th>Completion %</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($progressReports as $report)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($report->report_date)->format('d M Y') }}</td>
                                <td>{{ $report->workCategory->category_name ?? 'N/A' }}</td>
                                <td>
                                    <div class="progress">
                                        <div class="progress-bar {{ $report->completion_percent >= 90 ? 'bg-success' : 'bg-info' }}" 
                                             style="width: {{ $report->completion_percent }}%"></div>
                                    </div>
                                    <small>{{ $report->completion_percent }}%</small>
                                </td>
                                <td>{{ $report->remarks ?? 'No remarks' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-info">
                    No progress reports found for this college.
                </div>
            @endif
        </div>
        
        <!-- College Users Section -->
        <div class="section">
            <div class="section-title">College Users</div>
            @if(count($college->users) > 0)
                <table>
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
            @else
                <div class="alert alert-info">
                    No users associated with this college.
                </div>
            @endif
        </div>
        
        <div class="footer">
            <p>This is an official document generated from the RUSA College Monitoring System.</p>
            <p>© {{ date('Y') }} Rashtriya Uchchatar Shiksha Abhiyan (RUSA)</p>
        </div>
    </div>
    
    <script>
        // Auto-print when page loads
        window.onload = function() {
            // Slight delay to ensure everything is loaded
            setTimeout(function() {
                window.print();
            }, 1000);
        };
    </script>
</body>
</html> 