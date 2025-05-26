@extends('admin.layouts.app')

@section('title', 'Fund Releases')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Fund Releases</h1>
        <a href="{{ route('admin.releases.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> New Release
        </a>
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
            Filter Fund Releases
        </div>
        <div class="card-body">
            <form action="{{ route('admin.releases.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="college_id" class="form-label">College</label>
                        <select class="form-select" id="college_id" name="college_id">
                            <option value="">All Colleges</option>
                            @foreach($releases->pluck('funding.college')->unique('college_id')->sortBy('college_name') as $college)
                                <option value="{{ $college->college_id }}" {{ request('college_id') == $college->college_id ? 'selected' : '' }}>
                                    {{ $college->college_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="date_from" class="form-label">Release Date From</label>
                        <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="date_to" class="form-label">Release Date To</label>
                        <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="min_amount" class="form-label">Min Amount (₹)</label>
                        <input type="number" step="0.01" class="form-control" id="min_amount" name="min_amount" value="{{ request('min_amount') }}" placeholder="0.00">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="max_amount" class="form-label">Max Amount (₹)</label>
                        <input type="number" step="0.01" class="form-control" id="max_amount" name="max_amount" value="{{ request('max_amount') }}" placeholder="100000.00">
                    </div>
                     <div class="col-md-1 mb-3">
                        <label for="utilization_status" class="form-label">Utilized %</label>
                        <select class="form-select" id="utilization_status" name="utilization_status">
                            <option value="">Any</option>
                            <option value="0-25" {{ request('utilization_status') == '0-25' ? 'selected' : '' }}>0-25%</option>
                            <option value="26-50" {{ request('utilization_status') == '26-50' ? 'selected' : '' }}>26-50%</option>
                            <option value="51-75" {{ request('utilization_status') == '51-75' ? 'selected' : '' }}>51-75%</option>
                            <option value="76-99" {{ request('utilization_status') == '76-99' ? 'selected' : '' }}>76-99%</option>
                            <option value="100" {{ request('utilization_status') == '100' ? 'selected' : '' }}>100%</option>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.releases.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table id="releasesTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>College</th>
                        <th>Release Amount</th>
                        <th>Release Date</th>
                        <th>Description</th>
                        <th>Funding Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($releases as $release)
                        <tr>
                            <td>{{ $release->release_id }}</td>
                            <td>{{ $release->funding->college->college_name }}</td>
                            <td>₹{{ number_format($release->release_amt, 2) }}</td>
                            <td>{{ $release->release_date->format('d M Y') }}</td>
                            <td>{{ $release->desc }}</td>
                            <td>
                                <span class="badge bg-{{ $release->funding->utilization_percentage >= 100 ? 'success' : 'info' }}">
                                    {{ number_format($release->funding->utilization_percentage, 1) }}% Utilized
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('admin.releases.show', $release->release_id) }}" 
                                       class="btn btn-sm btn-info" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.releases.edit', $release->release_id) }}" 
                                       class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.releases.destroy', $release->release_id) }}" 
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Are you sure you want to delete this release?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#releasesTable').DataTable({
            order: [[3, 'desc']], // Sort by release date by default
            pageLength: 10,
            responsive: true
        });
    });
</script>
@endpush 