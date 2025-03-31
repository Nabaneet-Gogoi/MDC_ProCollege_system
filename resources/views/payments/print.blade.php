<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment #{{ $payment->payment_id }} - Print</title>
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
        
        .payment-details {
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
        .bg-info { background-color: #17a2b8; }
        .bg-secondary { background-color: #6c757d; }
        
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
        <button class="print-button" onclick="window.print();">Print Payment</button>
        
        <div class="header">
            <h1>Payment Receipt</h1>
            <h3>{{ $payment->bill->college->college_name }}</h3>
            <p>Payment ID: {{ $payment->payment_id }} | Bill #{{ $payment->bill->bill_no }}</p>
        </div>
        
        <div class="payment-details">
            <h3>Payment Information</h3>
            
            <div class="row">
                <div class="label">Payment Amount:</div>
                <div class="value">₹ {{ number_format($payment->payment_amt, 2) }} Crores</div>
            </div>
            
            <div class="row">
                <div class="label">Payment Date:</div>
                <div class="value">{{ $payment->payment_date->format('d-m-Y') }}</div>
            </div>
            
            <div class="row">
                <div class="label">Status:</div>
                <div class="value">
                    <span class="badge 
                        @if($payment->payment_status == 'pending') bg-warning
                        @elseif($payment->payment_status == 'processed') bg-info
                        @elseif($payment->payment_status == 'completed') bg-success
                        @elseif($payment->payment_status == 'rejected') bg-danger
                        @else bg-secondary @endif">
                        {{ ucfirst($payment->payment_status) }}
                    </span>
                </div>
            </div>
            
            @if($payment->transaction_reference)
                <div class="row">
                    <div class="label">Transaction Reference:</div>
                    <div class="value">{{ $payment->transaction_reference }}</div>
                </div>
            @endif
            
            <div class="row">
                <div class="label">Recorded On:</div>
                <div class="value">{{ $payment->created_at->format('d-m-Y H:i') }}</div>
            </div>
            
            @if($payment->remarks)
                <div class="row">
                    <div class="label">Remarks:</div>
                    <div class="value">{{ $payment->remarks }}</div>
                </div>
            @endif
            
            @if($payment->admin_remarks)
                <div class="row">
                    <div class="label">Admin Remarks:</div>
                    <div class="value">{{ $payment->admin_remarks }}</div>
                </div>
            @endif
        </div>
        
        <div class="payment-details">
            <h3>Bill Information</h3>
            
            <div class="row">
                <div class="label">Bill Number:</div>
                <div class="value">{{ $payment->bill->bill_no }}</div>
            </div>
            
            <div class="row">
                <div class="label">Bill Amount:</div>
                <div class="value">₹ {{ number_format($payment->bill->bill_amt, 2) }} Crores</div>
            </div>
            
            <div class="row">
                <div class="label">Bill Date:</div>
                <div class="value">{{ $payment->bill->bill_date->format('d-m-Y') }}</div>
            </div>
            
            <div class="row">
                <div class="label">Bill Status:</div>
                <div class="value">
                    <span class="badge 
                        @if($payment->bill->bill_status == 'pending') bg-warning
                        @elseif($payment->bill->bill_status == 'approved') bg-success
                        @elseif($payment->bill->bill_status == 'rejected') bg-danger
                        @elseif($payment->bill->bill_status == 'paid') bg-primary
                        @else bg-secondary @endif">
                        {{ ucfirst($payment->bill->bill_status) }}
                    </span>
                </div>
            </div>
        </div>
        
        <div class="payment-details">
            <h3>College & Project Information</h3>
            
            <div class="row">
                <div class="label">College:</div>
                <div class="value">{{ $payment->bill->college->college_name }}</div>
            </div>
            
            <div class="row">
                <div class="label">Type:</div>
                <div class="value">
                    @if($payment->bill->college->type === 'professional')
                        Professional College
                    @else
                        Model Degree College (MDC)
                    @endif
                </div>
            </div>
            
            <div class="row">
                <div class="label">District:</div>
                <div class="value">{{ $payment->bill->college->district }}</div>
            </div>
            
            <div class="row">
                <div class="label">State:</div>
                <div class="value">{{ $payment->bill->college->state }}</div>
            </div>
            
            <div class="row">
                <div class="label">Total Funding:</div>
                <div class="value">₹ {{ number_format($payment->bill->funding->approved_amt, 2) }} Crores</div>
            </div>
        </div>
        
        @if($payment->bill->payments->count() > 1)
            <h3>All Payments for This Bill</h3>
            <table>
                <thead>
                    <tr>
                        <th>Payment ID</th>
                        <th>Amount (₹ Cr)</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Transaction Ref</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPaid = 0;
                    @endphp
                    @foreach($payment->bill->payments as $billPayment)
                        <tr @if($billPayment->payment_id == $payment->payment_id) style="background-color: #f8f9fa; font-weight: bold;" @endif>
                            <td>{{ $billPayment->payment_id }}</td>
                            <td>{{ number_format($billPayment->payment_amt, 2) }}</td>
                            <td>{{ $billPayment->payment_date->format('d-m-Y') }}</td>
                            <td>
                                <span class="badge 
                                    @if($billPayment->payment_status == 'pending') bg-warning
                                    @elseif($billPayment->payment_status == 'processed') bg-info
                                    @elseif($billPayment->payment_status == 'completed') bg-success
                                    @elseif($billPayment->payment_status == 'rejected') bg-danger
                                    @else bg-secondary @endif">
                                    {{ ucfirst($billPayment->payment_status) }}
                                </span>
                            </td>
                            <td>{{ $billPayment->transaction_reference ?? 'N/A' }}</td>
                        </tr>
                        @php
                            if ($billPayment->payment_status == 'completed') {
                                $totalPaid += $billPayment->payment_amt;
                            }
                        @endphp
                    @endforeach
                    <tr class="bg-light">
                        <td colspan="1"><strong>Total Paid:</strong></td>
                        <td><strong>{{ number_format($totalPaid, 2) }}</strong></td>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="bg-light">
                        <td colspan="1"><strong>Bill Amount:</strong></td>
                        <td><strong>{{ number_format($payment->bill->bill_amt, 2) }}</strong></td>
                        <td colspan="3"></td>
                    </tr>
                    <tr class="bg-light">
                        <td colspan="1"><strong>Remaining:</strong></td>
                        <td><strong>{{ number_format($payment->bill->bill_amt - $totalPaid, 2) }}</strong></td>
                        <td colspan="3"></td>
                    </tr>
                </tbody>
            </table>
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