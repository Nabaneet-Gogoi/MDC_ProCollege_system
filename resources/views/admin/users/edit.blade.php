@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
    <!-- Modern Header Section with Gradient Background -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-header border-0 text-white position-relative gradient-header" 
                     style="min-height: 120px;">
                    
                    <div class="d-flex justify-content-between align-items-center position-relative h-100 py-3">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="avatar-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center" 
                                     style="width: 50px; height: 50px; border-radius: 15px;">
                                    <i class="bi bi-pencil-square fs-4 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h1 class="h3 mb-1 fw-bold text-white">Edit User</h1>
                                <p class="mb-0 text-white-50">Modify {{ $user->username }} details and permissions</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('admin.users.index') }}" 
                               class="btn btn-light btn-modern rounded-pill px-4 py-2 shadow-sm hover-lift">
                                <i class="bi bi-arrow-left me-2"></i>Back to Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Edit Form -->
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header border-0 py-3 gradient-form">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="bi bi-person-gear text-white"></i>
                        </div>
                        <h5 class="mb-0 fw-semibold text-white">User Details</h5>
                    </div>
                </div>
                <div class="card-body p-4" style="background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);">
                    <form action="{{ route('admin.users.update', $user->user_id) }}" method="POST" id="editUserForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Username Field -->
                        <div class="mb-4">
                            <label for="username" class="form-label fw-semibold text-dark">
                                <i class="bi bi-person me-1 text-primary"></i>Username <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light">
                                    <i class="bi bi-at text-muted"></i>
                                </span>
                                <input type="text" 
                                       class="form-control rounded-end border-0 bg-light @error('username') is-invalid @enderror" 
                                       id="username" 
                                       name="username" 
                                       value="{{ old('username', $user->username) }}" 
                                       required
                                       style="padding: 12px 16px; font-size: 0.95rem;">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Username must be unique across the system</small>
                        </div>
                        
                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-dark">
                                <i class="bi bi-key me-1 text-warning"></i>Password
                            </label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light">
                                    <i class="bi bi-shield-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control rounded-end border-0 bg-light @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password"
                                       style="padding: 12px 16px; font-size: 0.95rem;">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Leave blank to keep current password. New password must be at least 8 characters.</small>
                        </div>
                        
                        <!-- Role Field -->
                        <div class="mb-4">
                            <label for="role" class="form-label fw-semibold text-dark">
                                <i class="bi bi-shield-check me-1 text-success"></i>User Role <span class="text-danger">*</span>
                            </label>
                            <select class="form-select border-0 bg-light @error('role') is-invalid @enderror" 
                                    id="role" 
                                    name="role" 
                                    required
                                    style="padding: 12px 16px; font-size: 0.95rem;">
                                <option value="">Select Role</option>
                                <option value="college" {{ (old('role', $user->role) == 'college') ? 'selected' : '' }}>
                                    College User
                                </option>
                                <option value="RUSA" {{ (old('role', $user->role) == 'RUSA') ? 'selected' : '' }}>
                                    RUSA User
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Determines user access level and permissions</small>
                        </div>
                        
                        <!-- College Field -->
                        <div class="mb-4 college-field" id="collegeFieldDiv">
                            <label for="college_id" class="form-label fw-semibold text-dark">
                                <i class="bi bi-building me-1 text-info"></i>Associated College
                            </label>
                            <select class="form-select border-0 bg-light @error('college_id') is-invalid @enderror" 
                                    id="college_id" 
                                    name="college_id"
                                    style="padding: 12px 16px; font-size: 0.95rem;">
                                <option value="">Select College</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->college_id }}" 
                                            {{ (old('college_id', $user->college_id) == $college->college_id) ? 'selected' : '' }}>
                                        {{ $college->college_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('college_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Required only for College users</small>
                        </div>

                        <!-- Current User Info Display -->
                        <div class="alert border-0 rounded-4 mb-4" 
                             style="background: linear-gradient(135deg, #e3f2fd, #f3e5f5); border-left: 4px solid #667eea;">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <div class="info-icon bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-info-circle text-primary"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-2">Current User Information</h6>
                                    <div class="row g-3 small">
                                        <div class="col-sm-6">
                                            <strong>Current Role:</strong> 
                                            <span class="badge rounded-pill ms-1 px-2 py-1" 
                                                  style="background: linear-gradient(135deg, #28a745, #20c997); color: white;">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </div>
                                        <div class="col-sm-6">
                                            <strong>Current College:</strong> 
                                            @if($user->college)
                                                <span class="text-info">{{ $user->college->college_name }}</span>
                                            @else
                                                <span class="text-muted">Not Assigned</span>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <strong>Created:</strong> {{ $user->created_at->format('M d, Y') }}
                                        </div>
                                        <div class="col-sm-6">
                                            <strong>Last Updated:</strong> {{ $user->updated_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('admin.users.show', $user->user_id) }}" 
                               class="btn btn-outline-secondary rounded-pill px-4 py-2 hover-lift">
                                <i class="bi bi-eye me-2"></i>View Details
                            </a>
                            <button type="submit" 
                                    class="btn rounded-pill px-5 py-2 hover-lift"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; color: white !important; border: none;">
                                <i class="bi bi-save me-2"></i>Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Styles -->
    <style>
        /* Force gradients to be visible */
        .gradient-header {
            background: #667eea !important; /* Fallback */
            background: -webkit-linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            background: -moz-linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%) !important;
            color: white !important;
        }
        
        .gradient-form {
            background: #4facfe !important; /* Fallback */
            background: -webkit-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            background: -moz-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            color: white !important;
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }
        
        .form-control, .form-select {
            transition: all 0.3s ease;
            border: 2px solid transparent !important;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
            background-color: white !important;
        }
        
        .input-group-text {
            border: 2px solid transparent !important;
            transition: all 0.3s ease;
        }
        
        .form-control:focus + .input-group-text,
        .input-group:focus-within .input-group-text {
            border-color: #667eea !important;
            background-color: rgba(102, 126, 234, 0.1) !important;
        }
        
        .avatar-circle {
            box-shadow: 0 4px 15px rgba(255,255,255,0.2);
        }
        
        .info-icon {
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        /* Enhanced form styling */
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        
        .college-field {
            transition: all 0.3s ease;
        }
        
        @media (max-width: 768px) {
            .card-header .d-flex {
                flex-direction: column;
                gap: 1rem;
            }
            
            .d-flex.justify-content-end {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role');
            const collegeFieldDiv = document.getElementById('collegeFieldDiv');
            const collegeSelect = document.getElementById('college_id');
            
            function toggleCollegeField() {
                if (roleSelect.value === 'college') {
                    collegeFieldDiv.style.display = 'block';
                    collegeFieldDiv.style.opacity = '1';
                    collegeSelect.setAttribute('required', 'required');
                } else {
                    collegeFieldDiv.style.display = 'none';
                    collegeFieldDiv.style.opacity = '0';
                    collegeSelect.removeAttribute('required');
                    collegeSelect.value = '';
                }
            }
            
            // Initial state
            toggleCollegeField();
            
            // On change
            roleSelect.addEventListener('change', toggleCollegeField);

            // Form validation enhancement
            const form = document.getElementById('editUserForm');
            form.addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                
                if (password && password.length < 8) {
                    e.preventDefault();
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Password Too Short',
                            text: 'Password must be at least 8 characters long.',
                            icon: 'warning',
                            confirmButtonColor: '#667eea',
                            customClass: {
                                popup: 'rounded-4 shadow-lg',
                                confirmButton: 'rounded-3'
                            }
                        });
                    } else {
                        alert('Password must be at least 8 characters long.');
                    }
                    
                    document.getElementById('password').focus();
                    return false;
                }
            });

            // Add smooth focus effects
            const inputs = document.querySelectorAll('.form-control, .form-select');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.closest('.mb-4').style.transform = 'translateY(-2px)';
                });
                
                input.addEventListener('blur', function() {
                    this.closest('.mb-4').style.transform = 'translateY(0)';
                });
            });
        });
    </script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection 