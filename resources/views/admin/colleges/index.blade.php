@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Colleges</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.colleges.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Add New College
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-funnel me-1"></i>
            Filter Colleges
        </div>
        <div class="card-body">
            <form action="{{ route('admin.colleges.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="state" class="form-label">State</label>
                        <select class="form-select" id="state" name="state">
                            <option value="">All States</option>
                            @foreach($colleges->pluck('state')->unique()->sort() as $state)
                                <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>
                                    {{ $state }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="district" class="form-label">District</label>
                        <select class="form-select" id="district" name="district">
                            <option value="">All Districts</option>
                            @foreach($colleges->pluck('district')->unique()->sort() as $district)
                                <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                    {{ $district }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="type" class="form-label">College Type</label>
                        <select class="form-select" id="type" name="type">
                            <option value="">All Types</option>
                            <option value="professional" {{ request('type') == 'professional' ? 'selected' : '' }}>Professional</option>
                            <option value="MDC" {{ request('type') == 'MDC' ? 'selected' : '' }}>MDC</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="phase" class="form-label">Phase</label>
                        <select class="form-select" id="phase" name="phase">
                            <option value="">All Phases</option>
                            @foreach($colleges->whereNotNull('phase')->pluck('phase')->unique()->sort() as $phase)
                                <option value="{{ $phase }}" {{ request('phase') == $phase ? 'selected' : '' }}>
                                    Phase {{ $phase }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end">
                    <a href="{{ route('admin.colleges.index') }}" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-1"></i> Colleges List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>College Name</th>
                            <th>State</th>
                            <th>District</th>
                            <th>Type</th>
                            <th>Phase</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colleges as $college)
                            <tr>
                                <td>{{ $college->college_id }}</td>
                                <td>{{ $college->college_name }}</td>
                                <td>{{ $college->state }}</td>
                                <td>{{ $college->district }}</td>
                                <td>
                                    @if($college->type === 'professional')
                                        <span class="badge bg-primary">Professional</span>
                                    @else
                                        <span class="badge bg-success">MDC</span>
                                    @endif
                                </td>
                                <td>
                                    @if($college->type === 'MDC')
                                        Phase {{ $college->phase }}
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.colleges.show', $college->college_id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.colleges.edit', $college->college_id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.colleges.destroy', $college->college_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this college?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No colleges found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-3">
                {{ $colleges->links() }}
            </div>
        </div>
    </div>
@endsection 