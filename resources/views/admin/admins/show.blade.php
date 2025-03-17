@extends('admin.layouts.app')

@section('title', 'View Admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Admin Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.admins.index') }}" class="btn btn-sm btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Admins
            </a>
            <a href="{{ route('admin.admins.edit', $admin->admin_id) }}" class="btn btn-sm btn-warning">
                <i class="bi bi-pencil"></i> Edit Admin
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-person me-1"></i> Admin Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th class="table-light" style="width: 40%">ID</th>
                            <td>{{ $admin->admin_id }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Email</th>
                            <td>{{ $admin->email }}</td>
                        </tr>
                        <tr>
                            <th class="table-light">Phone Number</th>
                            <td>{{ $admin->phone_no }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="text-center">
                                <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 100px; height: 100px;">
                                    <i class="bi bi-person-fill text-white" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="mb-0">{{ $admin->email }}</h5>
                                <div class="text-muted">Administrator</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4 d-flex">
                <a href="{{ route('admin.admins.edit', $admin->admin_id) }}" class="btn btn-primary me-2">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('admin.admins.destroy', $admin->admin_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this admin?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" {{ auth()->guard('admin')->user()->admin_id === $admin->admin_id ? 'disabled' : '' }}>
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
                @if(auth()->guard('admin')->user()->admin_id === $admin->admin_id)
                    <div class="alert alert-warning mt-2">
                        <i class="bi bi-exclamation-triangle-fill"></i> You cannot delete your own account while logged in.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection 