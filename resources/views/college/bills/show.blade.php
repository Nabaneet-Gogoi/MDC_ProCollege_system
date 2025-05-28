@extends('college.layouts.app')

@section('title', 'View Bill Details')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="bi bi-file-earmark-text me-2 text-primary"></i>Bill Details: {{ $bill->bill_no }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.index') }}" class="btn btn-sm btn-secondary-gradient me-2 transition-hover">
                <i class="bi bi-arrow-left"></i> Back to Bills
            </a>
            
            <a href="{{ route('bills.print', $bill->bill_id) }}" class="btn btn-sm btn-info-gradient me-2 transition-hover" target="_blank">
                <i class="bi bi-printer"></i> Print Bill
            </a>
            
            @if($bill->bill_status === 'pending')
                <a href="{{ route('college.bills.edit', $bill->bill_id) }}" class="btn btn-sm btn-primary-gradient me-2 transition-hover">
                    <i class="bi bi-pencil"></i> Edit Bill
                </a>
                
                <form action="{{ route('college.bills.destroy', $bill->bill_id) }}" method="POST" 
                    class="d-inline" onsubmit="return confirm('Are you sure you want to delete this bill?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger-gradient transition-hover">
                        <i class="bi bi-trash"></i> Delete Bill
                    </button>
                </form>
            @endif
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

    <div class="row">
        <!-- Bill Information Card -->
        <div class="col-md-6 mb-4">
            <div class="modern-card h-100">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                    <span class="fw-bold">Bill Information</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Bill Number:</div>
                        <div class="col-md-8">{{ $bill->bill_no }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Bill Amount:</div>
                        <div class="col-md-8">₹ {{ number_format($bill->bill_amt, 2) }} Crores</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Bill Date:</div>
                        <div class="col-md-8">{{ $bill->bill_date->format('d-m-Y') }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status:</div>
                        <div class="col-md-8">
                            <span class="badge-modern 
                                @if($bill->bill_status == 'pending') badge-warning
                                @elseif($bill->bill_status == 'approved') badge-success
                                @elseif($bill->bill_status == 'rejected') badge-danger
                                @else badge-info @endif">
                                {{ ucfirst($bill->bill_status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Submission Date:</div>
                        <div class="col-md-8">{{ $bill->created_at->format('d-m-Y H:i') }}</div>
                    </div>
                    
                    @if($bill->description)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Description:</div>
                            <div class="col-md-8">{{ $bill->description }}</div>
                        </div>
                    @endif
                    
                    @if($bill->bill_image)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Bill Image:</div>
                            <div class="col-md-8">
                                <a href="{{ asset('storage/' . $bill->bill_image) }}" target="_blank" class="d-block img-hover-zoom">
                                    <img src="{{ asset('storage/' . $bill->bill_image) }}" alt="Bill Image" class="img-thumbnail" style="max-height: 150px;">
                                    <small class="d-block mt-1 text-primary">Click to view full image</small>
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    @if($bill->admin_remarks)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">Admin Remarks:</div>
                            <div class="col-md-8">{{ $bill->admin_remarks }}</div>
                        </div>
                    @endif
                    
                    @if($bill->college_remarks)
                        <div class="row mb-3">
                            <div class="col-md-4 fw-bold">College Remarks:</div>
                            <div class="col-md-8">{{ $bill->college_remarks }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Project Information Card -->
        <div class="col-md-6 mb-4">
            <div class="modern-card h-100">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-building me-2 text-primary"></i>
                    <span class="fw-bold">Project Information</span>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">College:</div>
                        <div class="col-md-8">{{ $bill->college->college_name }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Type:</div>
                        <div class="col-md-8">
                            @if($bill->college->type === 'professional')
                                Professional College
                            @else
                                Model Degree College (MDC)
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Phase:</div>
                        <div class="col-md-8">Phase {{ $bill->college->phase }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">District:</div>
                        <div class="col-md-8">{{ $bill->college->district }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">State:</div>
                        <div class="col-md-8">{{ $bill->college->state }}</div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Total Funding:</div>
                        <div class="col-md-8">₹ {{ number_format($bill->funding->approved_amt, 2) }} Crores</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 fw-bold">Remaining Balance:</div>
                        <div class="col-md-8">₹ {{ number_format($bill->funding->remaining_balance, 2) }} Crores</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Physical Progress Section -->
    <div class="modern-card mb-4">
        <div class="card-header d-flex align-items-center">
            <i class="bi bi-graph-up me-2 text-primary"></i>
            <span class="fw-bold">Physical Progress Details</span>
        </div>
        <div class="card-body">
            @if($bill->progress->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped modern-table">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Completion</th>
                                <th>Status</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bill->progress as $progress)
                                <tr>
                                    <td>{{ $progress->category->category_name }}</td>
                                    <td>
                                        <div class="modern-progress">
                                            <div class="progress-bar shimmer-animation" role="progressbar" 
                                                style="width: {{ $progress->completion_percent }}%;" 
                                                aria-valuenow="{{ $progress->completion_percent }}" 
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted">{{ number_format($progress->completion_percent, 0) }}% Complete</small>
                                    </td>
                                    <td>
                                        <span class="badge-modern
                                            @if($progress->progress_status == 'not_started') badge-secondary
                                            @elseif($progress->progress_status == 'in_progress') badge-info
                                            @elseif($progress->progress_status == 'completed') badge-success
                                            @endif">
                                            {{ str_replace('_', ' ', ucfirst($progress->progress_status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $progress->description ?? 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Overall Progress Summary -->
                <div class="modern-card mt-4">
                    <div class="card-header d-flex align-items-center bg-light">
                        <i class="bi bi-bar-chart-line me-2 text-primary"></i>
                        <span class="fw-bold">Overall Progress Summary</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                @php
                                    $avgProgress = $bill->progress->avg('completion_percent');
                                    $completedItems = $bill->progress->where('progress_status', 'completed')->count();
                                    $inProgressItems = $bill->progress->where('progress_status', 'in_progress')->count();
                                    $notStartedItems = $bill->progress->where('progress_status', 'not_started')->count();
                                    $totalItems = $bill->progress->count();
                                @endphp
                                
                                <h5 class="mb-3">Average Completion: {{ number_format($avgProgress, 0) }}%</h5>
                                <div class="modern-progress mb-4" style="height: 10px;">
                                    <div class="progress-bar shimmer-animation" role="progressbar" 
                                        style="width: {{ $avgProgress }}%;" 
                                        aria-valuenow="{{ $avgProgress }}" 
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge-modern badge-success me-2">{{ $completedItems }}</span>
                                            <span>Completed</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge-modern badge-info me-2">{{ $inProgressItems }}</span>
                                            <span>In Progress</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge-modern badge-secondary me-2">{{ $notStartedItems }}</span>
                                            <span>Not Started</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                @if($bill->bill_status === 'pending')
                                    <div class="alert alert-warning modern-alert">
                                        <i class="bi bi-info-circle me-2"></i> This bill is currently pending approval. You can still edit or update the bill details.
                                    </div>
                                @elseif($bill->bill_status === 'approved')
                                    <div class="alert alert-success modern-alert">
                                        <i class="bi bi-check-circle me-2"></i> This bill has been approved. Funding will be released based on the approved amount.
                                    </div>
                                @elseif($bill->bill_status === 'rejected')
                                    <div class="alert alert-danger modern-alert">
                                        <i class="bi bi-x-circle me-2"></i> This bill has been rejected. Please contact the administrator for more details.
                                    </div>
                                @elseif($bill->bill_status === 'paid')
                                    <div class="alert alert-primary modern-alert">
                                        <i class="bi bi-credit-card me-2"></i> This bill has been paid. The amount has been disbursed.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-4 empty-state">
                    <i class="bi bi-exclamation-circle display-4 text-muted"></i>
                    <p class="mt-3">No progress information available for this bill.</p>
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
        
        /* Row spacing in card body */
        .card-body .row {
            margin-bottom: 0.75rem;
        }
        
        .card-body .row:last-child {
            margin-bottom: 0;
        }
        
        /* Modern Progress Bar */
        .modern-progress {
            height: 6px;
            background-color: rgba(240,242,245,0.7);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 5px;
        }
        
        .modern-progress .progress-bar {
            background: var(--primary-gradient);
            border-radius: 10px;
        }
        
        /* Shimmer Animation */
        .shimmer-animation {
            position: relative;
            overflow: hidden;
        }
        
        .shimmer-animation::after {
            content: '';
            position: absolute;
            top: 0;
            right: -100%;
            bottom: 0;
            left: 0;
            background: linear-gradient(
                90deg, 
                rgba(255,255,255,0) 0%, 
                rgba(255,255,255,0.3) 50%, 
                rgba(255,255,255,0) 100%
            );
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            to {
                transform: translateX(200%);
            }
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
        
        .badge-secondary {
            background: var(--secondary-gradient);
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
        
        .btn-secondary-gradient {
            background: var(--secondary-gradient);
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
        
        /* Image Hover Zoom Effect */
        .img-hover-zoom {
            overflow: hidden;
            transition: transform 0.3s ease;
        }
        
        .img-hover-zoom:hover img {
            transform: scale(1.05);
        }
        
        .img-hover-zoom img {
            transition: transform 0.3s ease;
        }
    </style>
@endsection 