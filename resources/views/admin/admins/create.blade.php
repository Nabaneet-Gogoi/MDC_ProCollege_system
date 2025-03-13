@extends('admin.layouts.app')

@section('title', 'Add New Admin')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New Admin</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.admins.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Admins
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-person-plus me-1"></i> Admin Information
        </div>
        <div class="card-body">
            <form action="{{ route('admin.admins.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="phone_no" class="form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('phone_no') is-invalid @enderror" id="phone_no" name="phone_no" value="{{ old('phone_no') }}" required>
                    @error('phone_no')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Create Admin
                    </button>
                    <a href="{{ route('admin.admins.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection 