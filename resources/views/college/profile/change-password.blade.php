@extends('college.layouts.app')

@section('title', 'Change Password')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Change Password</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.profile.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Profile
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-key me-1"></i>
                    Update Password
                </div>
                <div class="card-body">
                    <form action="{{ route('college.profile.update-password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text text-muted">
                                Password must be at least 8 characters long.
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-white">
                    <div class="small text-muted">
                        <i class="bi bi-info-circle"></i> For security reasons, you will be required to log in again after changing your password.
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 