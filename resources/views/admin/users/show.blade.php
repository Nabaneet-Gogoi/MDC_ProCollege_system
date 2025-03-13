@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">User Details: {{ $user->username }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
            <a href="{{ route('admin.users.edit', $user->user_id) }}" class="btn btn-sm btn-primary">
                <i class="bi bi-pencil"></i> Edit User
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-person me-1"></i>
            User Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th class="bg-light" style="width: 30%;">User ID</th>
                            <td>{{ $user->user_id }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Username</th>
                            <td>{{ $user->username }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Role</th>
                            <td>
                                <span class="badge {{ $user->role === 'college' ? 'bg-success' : 'bg-info' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Associated College</th>
                            <td>
                                @if($user->college)
                                    <a href="{{ route('admin.colleges.show', $user->college->college_id) }}">
                                        {{ $user->college->college_name }}
                                    </a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light">Created At</th>
                            <td>{{ $user->created_at->format('F d, Y h:i A') }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light">Last Updated</th>
                            <td>{{ $user->updated_at->format('F d, Y h:i A') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-light">
                            <i class="bi bi-info-circle me-1"></i>
                            Additional Information
                        </div>
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>User Type:</strong> 
                                @if($user->isCollegeUser())
                                    This user is associated with a specific college and can manage that college's data.
                                @else
                                    This is a RUSA administrator user with access to all colleges.
                                @endif
                            </p>
                            
                            <hr>
                            
                            <div class="d-grid gap-2 mt-3">
                                <form action="{{ route('admin.users.destroy', $user->user_id) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i> Delete User
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 