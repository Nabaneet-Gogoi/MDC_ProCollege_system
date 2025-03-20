@extends('admin.layouts.app')

@section('title', 'Release Details')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Release Details</h1>
        <div>
            <a href="{{ route('admin.releases.edit', $release->release_id) }}" class="btn btn-warning me-2">
                <i class="bi bi-pencil"></i> Edit Release
            </a>
            <a href="{{ route('admin.releases.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Releases
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Release Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 200px;">Release ID:</th>
                            <td>{{ $release->release_id }}</td>
                        </tr>
                        <tr>
                            <th>Release Amount:</th>
                            <td>₹{{ number_format($release->release_amt, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Release Date:</th>
                            <td>{{ $release->release_date->format('d M Y') }}</td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $release->desc }}</td>
                        </tr>
                        <tr>
                            <th>Created At:</th>
                            <td>{{ $release->created_at->format('d M Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated:</th>
                            <td>{{ $release->updated_at->format('d M Y H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Associated Funding Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 200px;">College:</th>
                            <td>{{ $release->funding->college->name }}</td>
                        </tr>
                        <tr>
                            <th>Funding ID:</th>
                            <td>{{ $release->funding->funding_id }}</td>
                        </tr>
                        <tr>
                            <th>Approved Amount:</th>
                            <td>₹{{ number_format($release->funding->approved_amt, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Total Released:</th>
                            <td>₹{{ number_format($release->funding->total_released, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Remaining Balance:</th>
                            <td>₹{{ number_format($release->funding->remaining_balance, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Utilization:</th>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar {{ $release->funding->utilization_percentage >= 100 ? 'bg-success' : 'bg-info' }}" 
                                         role="progressbar" 
                                         style="width: {{ min($release->funding->utilization_percentage, 100) }}%"
                                         aria-valuenow="{{ $release->funding->utilization_percentage }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ number_format($release->funding->utilization_percentage, 1) }}%
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">Actions</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.releases.destroy', $release->release_id) }}" 
                  method="POST" 
                  class="d-inline"
                  onsubmit="return confirm('Are you sure you want to delete this release? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Delete Release
                </button>
            </form>
        </div>
    </div>
</div>
@endsection 