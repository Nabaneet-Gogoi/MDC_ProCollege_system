@extends('rusa.layouts.app')

@section('title', 'Colleges')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Colleges Monitoring</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-file-earmark-excel"></i> Export
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Colleges</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rusa.colleges') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="type" class="form-label">Type</label>
                            <select class="form-select" id="type" name="type">
                                <option value="">All Types</option>
                                @foreach($types as $type)
                                    <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="phase" class="form-label">Phase</label>
                            <select class="form-select" id="phase" name="phase">
                                <option value="">All Phases</option>
                                @foreach($phases as $phase)
                                    <option value="{{ $phase }}" {{ request('phase') == $phase ? 'selected' : '' }}>
                                        {{ $phase }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="state" class="form-label">State</label>
                            <select class="form-select" id="state" name="state">
                                <option value="">All States</option>
                                @foreach($states as $state)
                                    <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>
                                        {{ $state }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="district" class="form-label">District</label>
                            <select class="form-select" id="district" name="district">
                                <option value="">All Districts</option>
                                @foreach($districts as $district)
                                    <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                        {{ $district }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" name="search" 
                                    placeholder="Search colleges..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Search
                                </button>
                                <a href="{{ route('rusa.colleges') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Colleges List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-building me-2"></i>Colleges ({{ $colleges->total() }})</h5>
                </div>
                <div class="card-body">
                    @if(isset($colleges) && count($colleges) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="collegeTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>College Name</th>
                                        <th>Type</th>
                                        <th>Phase</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($colleges as $college)
                                        <tr>
                                            <td>{{ $college->college_name }}</td>
                                            <td>{{ $college->type }}</td>
                                            <td>{{ $college->phase }}</td>
                                            <td>{{ $college->state }}</td>
                                            <td>{{ $college->district }}</td>
                                            <td>
                                                <a href="{{ route('rusa.colleges.details', $college->college_id) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i> View Details
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $colleges->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-building display-4 text-muted"></i>
                            <p class="lead mt-3">No colleges found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection 