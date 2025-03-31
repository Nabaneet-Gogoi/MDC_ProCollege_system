<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bill #{{ $bill->bill_no }} - Print</title>
    <style>
        /* Reset and basic styling */
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: white;
            margin: 0;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        
        .bill-details {
            margin-bottom: 30px;
        }
        
        .row {
            display: flex;
            margin-bottom: 8px;
        }
        
        .label {
            font-weight: bold;
            width: 200px;
        }
        
        .value {
            flex: 1;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        table th, 
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        
        table th {
            background-color: #f2f2f2;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.8em;
            font-weight: bold;
            color: white;
        }
        
        .bg-warning { background-color: #ffc107; }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
        .bg-primary { background-color: #007bff; }
        .bg-secondary { background-color: #6c757d; }
        
        .progress {
            height: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
            margin-bottom: 5px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            background-color: #007bff;
        }
        
        .print-button {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        @media print {
            .print-button {
                display: none;
            }
            
            body {
                padding: 0;
                margin: 0;
            }
            
            @page {
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <button class="print-button" onclick="window.print();">Print Bill</button>
        
        <div class="header">
            <h1>Bill #{{ $bill->bill_no }}</h1>
            <h3>{{ $bill->college->college_name }}</h3>
        </div>
        
        <div class="bill-details">
            <h3>Bill Information</h3>
            
            <div class="row">
                <div class="label">Bill Number:</div>
                <div class="value">{{ $bill->bill_no }}</div>
            </div>
            
            <div class="row">
                <div class="label">Bill Amount:</div>
                <div class="value">₹ {{ number_format($bill->bill_amt, 2) }} Crores</div>
            </div>
            
            <div class="row">
                <div class="label">Bill Date:</div>
                <div class="value">{{ $bill->bill_date->format('d-m-Y') }}</div>
            </div>
            
            <div class="row">
                <div class="label">Status:</div>
                <div class="value">
                    <span class="badge 
                        @if($bill->bill_status == 'pending') bg-warning
                        @elseif($bill->bill_status == 'approved') bg-success
                        @elseif($bill->bill_status == 'rejected') bg-danger
                        @else bg-primary @endif">
                        {{ ucfirst($bill->bill_status) }}
                    </span>
                </div>
            </div>
            
            <div class="row">
                <div class="label">Submission Date:</div>
                <div class="value">{{ $bill->created_at->format('d-m-Y H:i') }}</div>
            </div>
            
            <div class="row">
                <div class="label">Submitted By:</div>
                <div class="value">{{ $bill->user->username }}</div>
            </div>
            
            @if($bill->description)
                <div class="row">
                    <div class="label">Description:</div>
                    <div class="value">{{ $bill->description }}</div>
                </div>
            @endif
            
            @if($bill->admin_remarks)
                <div class="row">
                    <div class="label">Admin Remarks:</div>
                    <div class="value">{{ $bill->admin_remarks }}</div>
                </div>
            @endif
        </div>
        
        <div class="bill-details">
            <h3>College & Project Information</h3>
            
            <div class="row">
                <div class="label">College:</div>
                <div class="value">{{ $bill->college->college_name }}</div>
            </div>
            
            <div class="row">
                <div class="label">Type:</div>
                <div class="value">
                    @if($bill->college->type === 'professional')
                        Professional College
                    @else
                        Model Degree College (MDC)
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="label">Phase:</div>
                <div class="value">Phase {{ $bill->college->phase }}</div>
            </div>
            
            <div class="row">
                <div class="label">District:</div>
                <div class="value">{{ $bill->college->district }}</div>
            </div>
            
            <div class="row">
                <div class="label">State:</div>
                <div class="value">{{ $bill->college->state }}</div>
            </div>
            
            <div class="row">
                <div class="label">Total Funding:</div>
                <div class="value">₹ {{ number_format($bill->funding->approved_amt, 2) }} Crores</div>
            </div>
        </div>
        
        @if(count($bill->progress) > 0)
            <h3>Progress Information</h3>
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Completion %</th>
                        <th>Status</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bill->progress as $progress)
                        <tr>
                            <td>{{ $progress->category->category_name }}</td>
                            <td>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{ $progress->completion_percent }}%;"></div>
                                </div>
                                {{ $progress->completion_percent }}%
                            </td>
                            <td>
                                <span class="badge
                                    @if($progress->progress_status == 'not_started') bg-secondary
                                    @elseif($progress->progress_status == 'in_progress') bg-primary
                                    @elseif($progress->progress_status == 'completed') bg-success
                                    @endif">
                                    {{ str_replace('_', ' ', ucfirst($progress->progress_status)) }}
                                </span>
                            </td>
                            <td>{{ $progress->description ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Overall Progress Summary -->
            <h3>Overall Progress Summary</h3>
            @php
                $avgProgress = $bill->progress->avg('completion_percent');
                $completedItems = $bill->progress->where('progress_status', 'completed')->count();
                $inProgressItems = $bill->progress->where('progress_status', 'in_progress')->count();
                $notStartedItems = $bill->progress->where('progress_status', 'not_started')->count();
                $totalItems = $bill->progress->count();
            @endphp
            
            <div class="row">
                <div class="label">Average Completion:</div>
                <div class="value">
                    <div class="progress">
                        <div class="progress-bar" style="width: {{ $avgProgress }}%;"></div>
                    </div>
                    {{ number_format($avgProgress, 0) }}%
                </div>
            </div>
            
            <div class="row">
                <div class="label">Completed Tasks:</div>
                <div class="value">{{ $completedItems }} of {{ $totalItems }}</div>
            </div>
            
            <div class="row">
                <div class="label">In Progress Tasks:</div>
                <div class="value">{{ $inProgressItems }} of {{ $totalItems }}</div>
            </div>
            
            <div class="row">
                <div class="label">Not Started Tasks:</div>
                <div class="value">{{ $notStartedItems }} of {{ $totalItems }}</div>
            </div>
        @endif
        
        <div class="footer">
            <p>This is a computer-generated document. No signature is required.</p>
            <p>Generated on: {{ now()->format('d-m-Y H:i:s') }}</p>
        </div>
    </div>
    
    <script>
        // Auto-print when the page loads (optional - uncomment if you want auto-print)
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html> 