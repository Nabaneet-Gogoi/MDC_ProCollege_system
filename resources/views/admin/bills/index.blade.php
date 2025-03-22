@extends('admin.layouts.app')

@section('title', 'Manage Bills')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Bills</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
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

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-funnel me-1"></i>
            Filter Bills
        </div>
        <div class="card-body">
            <form action="{{ route('admin.bills.filter') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="college_id" class="form-label">College</label>
                        <select class="form-select" id="college_id" name="college_id">
                            <option value="">All Colleges</option>
                            @foreach($colleges ?? [] as $college)
                                <option value="{{ $college->college_id }}" {{ request('college_id') == $college->college_id ? 'selected' : '' }}>
                                    {{ $college->college_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Bill Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            @foreach(App\Models\Bill::getStatusOptions() as $value => $label)
                                <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="date_from" class="form-label">Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="date_to" class="form-label">Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.bills.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bills List Card -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-file-earmark-text me-1"></i>
            Bills List
        </div>
        <div class="card-body">
            @if($bills->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Bill Number</th>
                                <th>College</th>
                                <th>Amount (₹ Cr)</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Physical Progress</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bills as $bill)
                                <tr>
                                    <td>{{ $bill->bill_no }}</td>
                                    <td>{{ Str::limit($bill->college->college_name, 20) }}</td>
                                    <td>{{ number_format($bill->bill_amt, 2) }}</td>
                                    <td>{{ $bill->bill_date->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($bill->bill_status == 'pending') bg-warning
                                            @elseif($bill->bill_status == 'approved') bg-success
                                            @elseif($bill->bill_status == 'rejected') bg-danger
                                            @else bg-primary @endif">
                                            {{ ucfirst($bill->bill_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            // Calculate average progress
                                            $avgProgress = $bill->progress->avg('completion_percent');
                                        @endphp
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $avgProgress }}%;" 
                                                aria-valuenow="{{ $avgProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>{{ number_format($avgProgress, 0) }}% Complete</small>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('admin.bills.show', $bill->bill_id) }}" class="btn btn-info" title="View details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            
                                            <!-- Quick Status Update Buttons -->
                                            @if($bill->bill_status === 'pending')
                                                <form action="{{ route('admin.bills.updateStatus', $bill->bill_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-success" title="Approve Bill" 
                                                        onclick="return confirm('Are you sure you want to approve this bill?');">
                                                        <i class="bi bi-check-circle"></i>
                                                    </button>
                                                </form>
                                                
                                                <form action="{{ route('admin.bills.updateStatus', $bill->bill_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-danger" title="Reject Bill"
                                                        onclick="return confirm('Are you sure you want to reject this bill?');">
                                                        <i class="bi bi-x-circle"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if($bill->bill_status === 'approved')
                                                <form action="{{ route('admin.bills.updateStatus', $bill->bill_id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="hidden" name="status" value="paid">
                                                    <button type="submit" class="btn btn-primary" title="Mark as Paid"
                                                        onclick="return confirm('Are you sure you want to mark this bill as paid?');">
                                                        <i class="bi bi-credit-card"></i>
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
                <div class="text-center py-4">
                    <i class="bi bi-file-earmark-x display-4 text-muted"></i>
                    <p class="mt-3">No bills found matching your criteria.</p>
                </div>
            @endif
        </div>
    </div>
@endsection 