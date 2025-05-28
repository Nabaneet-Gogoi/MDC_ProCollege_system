@extends('college.layouts.app')

@section('title', 'Manage Bills')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Manage Bills</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.status.manage') }}" class="btn btn-sm btn-info-gradient me-2 transition-hover">
                <i class="bi bi-gear"></i> Manage Bill Status
            </a>
            <a href="{{ route('college.bills.create') }}" class="btn btn-sm btn-success-gradient transition-hover">
                <i class="bi bi-plus-circle"></i> Submit New Bill
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show modern-alert" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show modern-alert" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-card">
        <div class="card-header d-flex align-items-center">
            <i class="bi bi-file-earmark-text me-2 text-primary"></i>
            <span class="fw-bold">Bills List</span>
        </div>
        <div class="card-body">
            @if($bills->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover modern-table">
                        <thead>
                            <tr>
                                <th>Bill Number</th>
                                <th>Amount (₹ Cr)</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Project</th>
                                <th>Physical Progress</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bills as $bill)
                                <tr>
                                    <td class="fw-medium">{{ $bill->bill_no }}</td>
                                    <td>{{ number_format($bill->bill_amt, 2) }}</td>
                                    <td>{{ $bill->bill_date->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge-modern 
                                            @if($bill->bill_status == 'pending') badge-warning
                                            @elseif($bill->bill_status == 'approved') badge-success
                                            @elseif($bill->bill_status == 'rejected') badge-danger
                                            @else badge-info @endif">
                                            {{ ucfirst($bill->bill_status) }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($bill->funding->college->college_name, 20) }}</td>
                                    <td>
                                        @php
                                            // Calculate average progress with proper null handling
                                            $avgProgress = $bill->progress->avg('completion_percent') ?? 0;
                                            $avgProgress = max(0, min(100, $avgProgress)); // Ensure between 0-100
                                        @endphp
                                        <div class="progress" style="height: 8px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                 style="width: {{ $avgProgress }}%;" 
                                                 aria-valuenow="{{ $avgProgress }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted">{{ number_format($avgProgress, 0) }}% Complete</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('college.bills.show', $bill->bill_id) }}" class="btn btn-info-gradient transition-hover" title="View details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            
                                            @if($bill->bill_status === 'pending')
                                                <a href="{{ route('college.bills.edit', $bill->bill_id) }}" class="btn btn-primary-gradient transition-hover" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                
                                                <form action="{{ route('college.bills.destroy', $bill->bill_id) }}" method="POST" 
                                                    class="d-inline" onsubmit="return confirm('Are you sure you want to delete this bill?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger-gradient transition-hover" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $bills->links() }}
                </div>
            @else
                <div class="text-center py-4 empty-state">
                    <i class="bi bi-file-earmark-x display-4 text-muted"></i>
                    <p class="mt-3">No bills found. Create your first bill to get started.</p>
                    <a href="{{ route('college.bills.create') }}" class="btn btn-primary-gradient transition-hover">Submit New Bill</a>
                </div>
            @endif
        </div>
    </div>

    <style>
        /* Educational Theme Gradients */
        :root {
            --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%);
            --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
            --warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
            --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
            --danger-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            --secondary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        }
        
        /* Modern Card Styling */
        .modern-card {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            background: #fff;
            border: none;
        }
        
        .modern-card .card-header {
            background: rgba(240,242,245,0.5);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1rem 1.5rem;
            font-weight: 500;
        }
        
        .modern-card .card-body {
            padding: 1.5rem;
        }
        
        /* Modern Table */
        .modern-table thead th {
            background: rgba(240,242,245,0.5);
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 2px solid rgba(0,0,0,0.05);
            padding: 1rem 1.25rem;
        }
        
        .modern-table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            font-size: 0.85rem;
        }
        
        /* Modern Badges */
        .badge-modern {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 500;
            border-radius: 30px;
            display: inline-block;
            text-align: center;
        }
        
        .badge-success {
            background: var(--success-gradient);
            color: white;
        }
        
        .badge-warning {
            background: var(--warning-gradient);
            color: white;
        }
        
        .badge-danger {
            background: var(--danger-gradient);
            color: white;
        }
        
        .badge-info {
            background: var(--info-gradient);
            color: white;
        }
        
        /* Button Gradients */
        .btn-primary-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
        }
        
        .btn-success-gradient {
            background: var(--success-gradient);
            border: none;
            color: white;
        }
        
        .btn-info-gradient {
            background: var(--info-gradient);
            border: none;
            color: white;
        }
        
        .btn-danger-gradient {
            background: var(--danger-gradient);
            border: none;
            color: white;
        }
        
        /* Transition Effects */
        .transition-hover {
            transition: all 0.3s ease;
        }
        
        .transition-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        /* Modern Alerts */
        .modern-alert {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        /* Empty State */
        .empty-state {
            padding: 2rem;
        }
        
        .empty-state i {
            opacity: 0.5;
            margin-bottom: 1rem;
        }
        
        /* Modern Progress Bar Override */
        .progress {
            background-color: #e5e7eb !important;
            border-radius: 10px !important;
            overflow: hidden !important;
        }
        
        .progress .progress-bar {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%) !important;
            border-radius: 10px !important;
            transition: width 0.6s ease !important;
        }
    </style>
@endsection 