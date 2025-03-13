@extends('admin.layouts.app')

@section('title', 'Manage Admins')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Admins</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.admins.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> Add New Admin
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
            <i class="bi bi-people me-1"></i> Admin Accounts
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($admins as $admin)
                            <tr>
                                <td>{{ $admin->admin_id }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>{{ $admin->phone_no }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.admins.show', $admin->admin_id) }}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.admins.edit', $admin->admin_id) }}" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.admins.destroy', $admin->admin_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this admin?');">
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
                                <td colspan="4" class="text-center">No admin accounts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-3">
                {{ $admins->links() }}
            </div>
        </div>
    </div>
@endsection 