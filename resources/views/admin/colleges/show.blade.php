@extends('admin.layouts.app')

@section('title', 'College Details')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">College Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <a href="{{ route('admin.colleges.edit', $college->college_id) }}" class="btn btn-sm btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('admin.colleges.destroy', $college->college_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this college?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
            <a href="{{ route('admin.colleges.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Colleges
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-info-circle me-1"></i> College Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">College ID</h5>
                    <p class="fs-5">{{ $college->college_id }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">College Name</h5>
                    <p class="fs-5">{{ $college->college_name }}</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">State</h5>
                    <p class="fs-5">{{ $college->state }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">District</h5>
                    <p class="fs-5">{{ $college->district }}</p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">College Type</h5>
                    <p class="fs-5">
                        @if($college->type === 'professional')
                            <span class="badge bg-primary">Professional College</span>
                        @else
                            <span class="badge bg-success">Model Degree College (MDC)</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">Phase</h5>
                    <p class="fs-5">
                        <span class="badge bg-info">Phase {{ $college->phase }}</span>
                    </p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">Created At</h5>
                    <p class="fs-5">{{ $college->created_at ? $college->created_at->format('F d, Y h:i A') : 'Not available' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <h5 class="text-muted">Last Updated</h5>
                    <p class="fs-5">{{ $college->updated_at ? $college->updated_at->format('F d, Y h:i A') : 'Not available' }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection 