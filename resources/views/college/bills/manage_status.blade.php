@extends('college.layouts.app')

@section('title', 'Manage Bill Status')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Bill Status</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Bills
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

    <div class="card">
        <div class="card-header">
            <i class="bi bi-file-earmark-text me-1"></i>
            Bills Status Management
        </div>
        <div class="card-body">
            @if($bills->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Bill Number</th>
                                <th>Amount (₹ Cr)</th>
                                <th>Date</th>
                                <th>Current Status</th>
                                <th>Project</th>
                                <th>Physical Progress</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bills as $bill)
                                <tr>
                                    <td>{{ $bill->bill_no }}</td>
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
                                    <td>{{ Str::limit($bill->funding->college->college_name, 20) }}</td>
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
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#statusModal{{ $bill->bill_id }}">
                                            <i class="bi bi-pencil-square"></i> Update Status
                                        </button>
                                        
                                        <!-- Status Update Modal -->
                                        <div class="modal fade" id="statusModal{{ $bill->bill_id }}" tabindex="-1" aria-labelledby="statusModalLabel{{ $bill->bill_id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="statusModalLabel{{ $bill->bill_id }}">Update Status: {{ $bill->bill_no }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('college.bills.status.update', $bill->bill_id) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="status{{ $bill->bill_id }}" class="form-label">Status</label>
                                                                <select class="form-select" id="status{{ $bill->bill_id }}" name="status" required>
                                                                    @foreach(App\Models\Bill::getStatusOptions() as $value => $label)
                                                                        <option value="{{ $value }}" {{ $bill->bill_status == $value ? 'selected' : '' }}>
                                                                            {{ $label }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="remarks{{ $bill->bill_id }}" class="form-label">Remarks</label>
                                                                <textarea class="form-control" id="remarks{{ $bill->bill_id }}" name="remarks" rows="3">{{ $bill->college_remarks }}</textarea>
                                                                <small class="text-muted">Add any comments or details about this status change.</small>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Update Status</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
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
                    <p class="mt-3">No bills found. Create your first bill to get started.</p>
                    <a href="{{ route('college.bills.create') }}" class="btn btn-primary">Submit New Bill</a>
                </div>
            @endif
        </div>
    </div>
@endsection 