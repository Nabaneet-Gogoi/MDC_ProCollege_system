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