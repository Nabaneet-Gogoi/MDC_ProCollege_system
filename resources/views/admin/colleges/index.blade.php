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
                                <td>Phase {{ $college->phase }}</td>
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
            
            <div class="mt-3">
                {{ $colleges->links() }}
            </div>
        </div>
    </div>
@endsection 