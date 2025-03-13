@extends('admin.layouts.app')

@section('title', 'Add New User')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New User</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-person-plus me-1"></i>
            User Details
        </div>
        <div class="card-body">
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                           id="username" name="username" value="{{ old('username') }}" required>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Password must be at least 8 characters.</small>
                </div>
                
                <div class="mb-3">
                    <label for="role" class="form-label">User Role <span class="text-danger">*</span></label>
                    <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                        <option value="">Select Role</option>
                        <option value="college" {{ old('role') == 'college' ? 'selected' : '' }}>College User</option>
                        <option value="RUSA" {{ old('role') == 'RUSA' ? 'selected' : '' }}>RUSA User</option>
                    </select>
                    @error('role')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3 college-field" id="collegeFieldDiv">
                    <label for="college_id" class="form-label">Associated College</label>
                    <select class="form-select @error('college_id') is-invalid @enderror" id="college_id" name="college_id">
                        <option value="">Select College</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->college_id }}" {{ old('college_id') == $college->college_id ? 'selected' : '' }}>
                                {{ $college->college_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('college_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Required only for College users.</small>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Create User
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Show/hide college field based on role selection
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const collegeFieldDiv = document.getElementById('collegeFieldDiv');
        const collegeSelect = document.getElementById('college_id');
        
        function toggleCollegeField() {
            if (roleSelect.value === 'college') {
                collegeFieldDiv.style.display = 'block';
                collegeSelect.setAttribute('required', 'required');
            } else {
                collegeFieldDiv.style.display = 'none';
                collegeSelect.removeAttribute('required');
            }
        }
        
        // Initial state
        toggleCollegeField();
        
        // On change
        roleSelect.addEventListener('change', toggleCollegeField);
    });
</script>
@endsection 