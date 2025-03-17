@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Funding Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.fundings.index') }}" class="btn btn-sm btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
            <a href="{{ route('admin.fundings.edit', $funding->funding_id) }}" class="btn btn-sm btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-building me-1"></i> College Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>College Name:</strong> {{ $funding->college->college_name }}</p>
                    <p><strong>College ID:</strong> {{ $funding->college->college_id }}</p>
                    <p><strong>State:</strong> {{ $funding->college->state }}</p>
                    <p><strong>District:</strong> {{ $funding->college->district }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Type:</strong> 
                        @if($funding->college->type === 'professional')
                            <span class="badge bg-primary">Professional College</span>
                        @else
                            <span class="badge bg-success">Model Degree College (MDC)</span>
                        @endif
                    </p>
                    <p><strong>Phase:</strong> 
                        @if($funding->college->type === 'MDC')
                            <span class="badge bg-info">Phase {{ $funding->college->phase }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-currency-dollar me-1"></i> Funding Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-bg-primary mb-3">
                        <div class="card-header">Total Approved Amount</div>
                        <div class="card-body">
                            <h5 class="card-title">₹ {{ number_format($funding->approved_amt, 2) }} Crores</h5>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-bg-success mb-3">
                        <div class="card-header">Central Government Share</div>
                        <div class="card-body">
                            <h5 class="card-title">₹ {{ number_format($funding->central_share, 2) }} Crores</h5>
                            <p class="card-text">{{ number_format(($funding->central_share / $funding->approved_amt * 100), 0) }}% of total funding</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-bg-info mb-3">
                        <div class="card-header">State Government Share</div>
                        <div class="card-body">
                            <h5 class="card-title">₹ {{ number_format($funding->state_share, 2) }} Crores</h5>
                            <p class="card-text">{{ number_format(($funding->state_share / $funding->approved_amt * 100), 0) }}% of total funding</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <p><strong>Utilization Status:</strong> 
                    @if($funding->utilization_status === 'not_started')
                        <span class="badge bg-secondary">Not Started</span>
                    @elseif($funding->utilization_status === 'in_progress')
                        <span class="badge bg-warning">In Progress</span>
                    @else
                        <span class="badge bg-success">Completed</span>
                    @endif
                </p>
                <p><strong>Created At:</strong> {{ $funding->created_at->format('M d, Y h:i A') }}</p>
                <p><strong>Last Updated:</strong> {{ $funding->updated_at->format('M d, Y h:i A') }}</p>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-info-circle me-1"></i> Standard Funding Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <p>Based on college type and phase, the standard funding allocation would be:</p>
                    <ul>
                        @if($funding->college->type === 'MDC')
                            @if($funding->college->phase === '1')
                                <li>MDC Phase 1: Total ₹8 crores (Central:State ratio = 50:50)</li>
                                <li>Central Share: ₹4 crores</li>
                                <li>State Share: ₹4 crores</li>
                            @else
                                <li>MDC Phase 2: Total ₹12 crores (Central:State ratio = 90:10)</li>
                                <li>Central Share: ₹10.8 crores</li>
                                <li>State Share: ₹1.2 crores</li>
                            @endif
                        @else
                            <li>Professional College: Total ₹26 crores (Central:State ratio = 90:10)</li>
                            <li>Central Share: ₹23.4 crores</li>
                            <li>State Share: ₹2.6 crores</li>
                        @endif
                    </ul>
                    @if($funding->approved_amt != 
                        ($funding->college->type === 'MDC' ? 
                            ($funding->college->phase === '1' ? 8 : 12) : 
                            26))
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle"></i> The current funding amount differs from the standard amount for this college type and phase.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 