@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Funding Allocations</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.fundings.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Funding
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="bi bi-table me-1"></i> Funding Allocations List
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>College</th>
                            <th>Type</th>
                            <th>Phase</th>
                            <th>Approved Amount (Cr)</th>
                            <th>Central Share (Cr)</th>
                            <th>State Share (Cr)</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fundings as $funding)
                            <tr>
                                <td>{{ $funding->funding_id }}</td>
                                <td>{{ $funding->college->college_name }}</td>
                                <td>
                                    @if($funding->college->type === 'professional')
                                        <span class="badge bg-primary">Professional</span>
                                    @else
                                        <span class="badge bg-success">MDC</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info">Phase {{ $funding->college->phase }}</span>
                                </td>
                                <td>₹ {{ number_format($funding->approved_amt, 2) }}</td>
                                <td>₹ {{ number_format($funding->central_share, 2) }}</td>
                                <td>₹ {{ number_format($funding->state_share, 2) }}</td>
                                <td>
                                    @if($funding->utilization_status === 'not_started')
                                        <span class="badge bg-secondary">Not Started</span>
                                    @elseif($funding->utilization_status === 'in_progress')
                                        <span class="badge bg-warning">In Progress</span>
                                    @else
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.fundings.show', $funding->funding_id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.fundings.edit', $funding->funding_id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.fundings.destroy', $funding->funding_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this funding allocation?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No funding allocations found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection 