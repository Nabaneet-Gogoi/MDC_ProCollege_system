@extends('college.layouts.app')

@section('title', 'Manage Bills')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Bills</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Submit New Bill
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
            Bills List
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
                                <th>Status</th>
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
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ route('college.bills.show', $bill->bill_id) }}" class="btn btn-info" title="View details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            
                                            @if($bill->bill_status === 'pending')
                                                <a href="{{ route('college.bills.edit', $bill->bill_id) }}" class="btn btn-primary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                
                                                <form action="{{ route('college.bills.destroy', $bill->bill_id) }}" method="POST" 
                                                    class="d-inline" onsubmit="return confirm('Are you sure you want to delete this bill?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" title="Delete">
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
                <div class="text-center py-4">
                    <i class="bi bi-file-earmark-x display-4 text-muted"></i>
                    <p class="mt-3">No bills found. Create your first bill to get started.</p>
                    <a href="{{ route('college.bills.create') }}" class="btn btn-primary">Submit New Bill</a>
                </div>
            @endif
        </div>
    </div>
@endsection 