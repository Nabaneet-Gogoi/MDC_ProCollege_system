@extends('admin.layouts.app')

@section('title', 'View Bill Details')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Bill Details: {{ $bill->bill_no }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.index') }}" class="btn btn-sm btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Bills
            </a>
            
            @if($bill->bill_status === 'pending')
                <a href="{{ route('college.bills.edit', $bill->bill_id) }}" class="btn btn-sm btn-primary me-2">
                    <i class="bi bi-pencil"></i> Edit Bill
                </a>
                
                <form action="{{ route('college.bills.destroy', $bill->bill_id) }}" method="POST" 
                    class="d-inline" onsubmit="return confirm('Are you sure you want to delete this bill?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i> Delete Bill
                    </button>
                </form>
            @endif
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- Bill Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-file-earmark-text me-1"></i>
                    Bill Information
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
                            <span class="badge 
                                @if($bill->bill_status == 'pending') bg-warning
                                @elseif($bill->bill_status == 'approved') bg-success
                                @elseif($bill->bill_status == 'rejected') bg-danger
                                @else bg-primary @endif">
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
                </div>
            </div>
        </div>
        
        <!-- Project Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-building me-1"></i>
                    Project Information
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
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-graph-up me-1"></i>
            Physical Progress Details
        </div>
        <div class="card-body">
            @if($bill->progress->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
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
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" 
                                                style="width: {{ $progress->completion_percent }}%;" 
                                                aria-valuenow="{{ $progress->completion_percent }}" 
                                                aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>{{ number_format($progress->completion_percent, 0) }}% Complete</small>
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
                </div>
                
                <!-- Overall Progress Summary -->
                <div class="card mt-4">
                    <div class="card-header bg-light">
                        <i class="bi bi-bar-chart-line me-1"></i>
                        Overall Progress Summary
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
                                <div class="progress mb-4" style="height: 10px;">
                                    <div class="progress-bar" role="progressbar" 
                                        style="width: {{ $avgProgress }}%;" 
                                        aria-valuenow="{{ $avgProgress }}" 
                                        aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-success me-2">{{ $completedItems }}</span>
                                            <span>Completed</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-primary me-2">{{ $inProgressItems }}</span>
                                            <span>In Progress</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-secondary me-2">{{ $notStartedItems }}</span>
                                            <span>Not Started</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                @if($bill->bill_status === 'pending')
                                    <div class="alert alert-warning">
                                        <i class="bi bi-info-circle me-2"></i> This bill is currently pending approval. You can still edit or update the bill details.
                                    </div>
                                @elseif($bill->bill_status === 'approved')
                                    <div class="alert alert-success">
                                        <i class="bi bi-check-circle me-2"></i> This bill has been approved. Funding will be released based on the approved amount.
                                    </div>
                                @elseif($bill->bill_status === 'rejected')
                                    <div class="alert alert-danger">
                                        <i class="bi bi-x-circle me-2"></i> This bill has been rejected. Please contact the administrator for more details.
                                    </div>
                                @elseif($bill->bill_status === 'paid')
                                    <div class="alert alert-primary">
                                        <i class="bi bi-credit-card me-2"></i> This bill has been paid. The amount has been disbursed.
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-exclamation-circle display-4 text-muted"></i>
                    <p class="mt-3">No progress information available for this bill.</p>
                </div>
            @endif
        </div>
    </div>
@endsection 