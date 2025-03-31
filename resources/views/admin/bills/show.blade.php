@extends('admin.layouts.app')

@section('title', 'Bill Details')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Bill Details: {{ $bill->bill_no }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.bills.index') }}" class="btn btn-sm btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Bills
            </a>
            <a href="{{ route('bills.print', $bill->bill_id) }}" class="btn btn-sm btn-primary" target="_blank">
                <i class="bi bi-printer"></i> Print Bill
            </a>
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

    <!-- Status Update Card -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-gear me-1"></i>
            Update Bill Status
        </div>
        <div class="card-body">
            <form action="{{ route('admin.bills.update', $bill->bill_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="bill_status" class="form-label">Bill Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('bill_status') is-invalid @enderror" id="bill_status" name="bill_status" required>
                            @foreach(App\Models\Bill::getStatusOptions() as $value => $label)
                                <option value="{{ $value }}" {{ old('bill_status', $bill->bill_status) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('bill_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-8 mb-3">
                        <label for="admin_remarks" class="form-label">Administrative Remarks</label>
                        <textarea class="form-control @error('admin_remarks') is-invalid @enderror" id="admin_remarks" 
                            name="admin_remarks" rows="2">{{ old('admin_remarks', $bill->admin_remarks) }}</textarea>
                        @error('admin_remarks')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Add any remarks or feedback on this bill that will be visible to the college.</small>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>

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
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Submitted By:</div>
                        <div class="col-md-8">{{ $bill->user->username }}</div>
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
                                <a href="{{ asset('storage/' . $bill->bill_image) }}" target="_blank" class="d-block">
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
                </div>
            </div>
        </div>
        
        <!-- Project Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-building me-1"></i>
                    College Information
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
                    
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Central Share:</div>
                        <div class="col-md-8">₹ {{ number_format($bill->funding->central_share, 2) }} Crores</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4 fw-bold">State Share:</div>
                        <div class="col-md-8">₹ {{ number_format($bill->funding->state_share, 2) }} Crores</div>
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
                            <div class="col-md-4">
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
                            </div>
                            
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h5 class="text-success">{{ $completedItems }}</h5>
                                                <small>Completed Tasks</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h5 class="text-primary">{{ $inProgressItems }}</h5>
                                                <small>In Progress Tasks</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center">
                                                <h5 class="text-secondary">{{ $notStartedItems }}</h5>
                                                <small>Not Started Tasks</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    
    <!-- Quick Actions -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-lightning-charge me-1"></i>
            Quick Actions
        </div>
        <div class="card-body">
            <div class="row">
                @if($bill->bill_status === 'pending')
                    <div class="col-md-3 mb-3">
                        <form action="{{ route('admin.bills.updateStatus', $bill->bill_id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-success w-100" 
                                onclick="return confirm('Are you sure you want to approve this bill?');">
                                <i class="bi bi-check-circle me-2"></i> Approve Bill
                            </button>
                        </form>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <form action="{{ route('admin.bills.updateStatus', $bill->bill_id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Are you sure you want to reject this bill?');">
                                <i class="bi bi-x-circle me-2"></i> Reject Bill
                            </button>
                        </form>
                    </div>
                @endif
                
                @if($bill->bill_status === 'approved')
                    <div class="col-md-3 mb-3">
                        <form action="{{ route('admin.bills.updateStatus', $bill->bill_id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="paid">
                            <button type="submit" class="btn btn-primary w-100"
                                onclick="return confirm('Are you sure you want to mark this bill as paid?');">
                                <i class="bi bi-credit-card me-2"></i> Mark as Paid
                            </button>
                        </form>
                    </div>
                @endif
                
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.colleges.show', $bill->college_id) }}" class="btn btn-info w-100">
                        <i class="bi bi-building me-2"></i> View College Details
                    </a>
                </div>
                
                <div class="col-md-3 mb-3">
                    <a href="{{ route('admin.fundings.show', $bill->funding_id) }}" class="btn btn-secondary w-100">
                        <i class="bi bi-cash-stack me-2"></i> View Funding Details
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection 