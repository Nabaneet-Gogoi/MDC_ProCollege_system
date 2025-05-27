@extends('admin.layouts.app')

@section('title', 'Add New User')

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
                                    <i class="bi bi-person-plus fs-4 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h1 class="h3 mb-1 fw-bold text-white">Add New User</h1>
                                <p class="mb-0 text-white-50">Create a new user account with appropriate permissions</p>
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

    <!-- Modern Create Form -->
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
                    <form action="{{ route('admin.users.store') }}" method="POST" id="createUserForm">
                        @csrf
                        
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
                                       value="{{ old('username') }}" 
                                       required
                                       style="padding: 12px 16px; font-size: 0.95rem;"
                                       placeholder="Enter unique username">
                                @error('username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Username must be unique and contain only letters, numbers, and underscores</small>
                        </div>
                        
                        <!-- Password Field -->
                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold text-dark">
                                <i class="bi bi-key me-1 text-warning"></i>Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text border-0 bg-light">
                                    <i class="bi bi-shield-lock text-muted"></i>
                                </span>
                                <input type="password" 
                                       class="form-control border-0 bg-light @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password" 
                                       required
                                       style="padding: 12px 16px; font-size: 0.95rem; border-radius: 0;"
                                       placeholder="Enter secure password">
                                <span class="input-group-text border-0 bg-light password-toggle" style="cursor: pointer;">
                                    <i class="bi bi-eye text-muted" id="passwordToggleIcon"></i>
                                </span>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Password must be at least 8 characters long and contain letters and numbers</small>
                            
                            <!-- Password Strength Indicator -->
                            <div class="mt-2">
                                <div class="password-strength-meter">
                                    <div class="password-strength-bar" id="passwordStrengthBar"></div>
                                </div>
                                <small class="text-muted" id="passwordStrengthText">Password strength: <span id="strengthLevel">Weak</span></small>
                            </div>
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
                                <option value="college" {{ old('role') == 'college' ? 'selected' : '' }}>
                                    <i class="bi bi-mortarboard"></i> College User
                                </option>
                                <option value="RUSA" {{ old('role') == 'RUSA' ? 'selected' : '' }}>
                                    <i class="bi bi-shield-check"></i> RUSA User
                                </option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Choose the appropriate access level for this user</small>
                        </div>
                        
                        <!-- College Field -->
                        <div class="mb-4 college-field" id="collegeFieldDiv" style="display: none;">
                            <label for="college_id" class="form-label fw-semibold text-dark">
                                <i class="bi bi-building me-1 text-info"></i>Associated College <span class="text-danger">*</span>
                            </label>
                            <select class="form-select border-0 bg-light @error('college_id') is-invalid @enderror" 
                                    id="college_id" 
                                    name="college_id"
                                    style="padding: 12px 16px; font-size: 0.95rem;">
                                <option value="">Select College</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->college_id }}" 
                                            {{ old('college_id') == $college->college_id ? 'selected' : '' }}>
                                        {{ $college->college_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('college_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">This college will be assigned to the user for management</small>
                        </div>

                        <!-- User Guidelines -->
                        <div class="alert border-0 rounded-4 mb-4" 
                             style="background: linear-gradient(135deg, #e8f5e8, #f0f8ff); border-left: 4px solid #28a745;">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <div class="info-icon bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-lightbulb text-success"></i>
                                    </div>
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-2">User Creation Guidelines</h6>
                                    <ul class="small text-muted mb-0">
                                        <li><strong>College Users:</strong> Can only access and manage their assigned college's data</li>
                                        <li><strong>RUSA Users:</strong> Have administrative access to all colleges and system features</li>
                                        <li><strong>Username:</strong> Must be unique and will be used for login identification</li>
                                        <li><strong>Password:</strong> Should be strong and secure for user account protection</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="d-flex gap-3 justify-content-end">
                            <button type="reset" 
                                    class="btn btn-outline-secondary rounded-pill px-4 py-2 hover-lift"
                                    id="resetFormBtn">
                                <i class="bi bi-arrow-clockwise me-2"></i>Reset Form
                            </button>
                            <button type="submit" 
                                    class="btn rounded-pill px-5 py-2 hover-lift"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; color: white !important; border: none;"
                                    id="submitBtn">
                                <i class="bi bi-save me-2"></i>Create User
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
        
        /* Password strength meter */
        .password-strength-meter {
            width: 100%;
            height: 4px;
            background-color: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }
        
        .strength-weak { background: linear-gradient(90deg, #dc3545, #e74c3c); }
        .strength-fair { background: linear-gradient(90deg, #ffc107, #fd7e14); }
        .strength-good { background: linear-gradient(90deg, #28a745, #20c997); }
        .strength-strong { background: linear-gradient(90deg, #17a2b8, #007bff); }
        
        /* Enhanced form styling */
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 8px;
        }
        
        .college-field {
            transition: all 0.3s ease;
        }
        
        .password-toggle:hover {
            background-color: rgba(102, 126, 234, 0.1) !important;
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
            const passwordInput = document.getElementById('password');
            const passwordToggle = document.querySelector('.password-toggle');
            const passwordToggleIcon = document.getElementById('passwordToggleIcon');
            const strengthBar = document.getElementById('passwordStrengthBar');
            const strengthText = document.getElementById('strengthLevel');
            
            // Show/hide college field based on role
            function toggleCollegeField() {
                if (roleSelect.value === 'college') {
                    collegeFieldDiv.style.display = 'block';
                    collegeFieldDiv.style.opacity = '1';
                    collegeSelect.setAttribute('required', 'required');
                    // Update label to show required
                    collegeFieldDiv.querySelector('label').innerHTML = '<i class="bi bi-building me-1 text-info"></i>Associated College <span class="text-danger">*</span>';
                } else {
                    collegeFieldDiv.style.display = 'none';
                    collegeFieldDiv.style.opacity = '0';
                    collegeSelect.removeAttribute('required');
                    collegeSelect.value = '';
                    // Update label to remove required
                    collegeFieldDiv.querySelector('label').innerHTML = '<i class="bi bi-building me-1 text-info"></i>Associated College';
                }
            }
            
            // Initial state
            toggleCollegeField();
            
            // On role change
            roleSelect.addEventListener('change', toggleCollegeField);

            // Password toggle functionality
            passwordToggle.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    passwordToggleIcon.className = 'bi bi-eye-slash text-muted';
                } else {
                    passwordToggleIcon.className = 'bi bi-eye text-muted';
                }
            });

            // Password strength checker
            function checkPasswordStrength(password) {
                let strength = 0;
                let feedback = [];
                
                if (password.length >= 8) strength += 1;
                if (password.match(/[a-z]+/)) strength += 1;
                if (password.match(/[A-Z]+/)) strength += 1;
                if (password.match(/[0-9]+/)) strength += 1;
                if (password.match(/[!@#$%^&*(),.?":{}|<>]+/)) strength += 1;
                
                let level = '';
                let width = 0;
                let className = '';
                
                switch(strength) {
                    case 0:
                    case 1:
                        level = 'Weak';
                        width = 25;
                        className = 'strength-weak';
                        break;
                    case 2:
                        level = 'Fair';
                        width = 50;
                        className = 'strength-fair';
                        break;
                    case 3:
                        level = 'Good';
                        width = 75;
                        className = 'strength-good';
                        break;
                    case 4:
                    case 5:
                        level = 'Strong';
                        width = 100;
                        className = 'strength-strong';
                        break;
                }
                
                strengthBar.style.width = width + '%';
                strengthBar.className = 'password-strength-bar ' + className;
                strengthText.textContent = level;
                strengthText.style.color = getComputedStyle(strengthBar).backgroundColor;
            }

            passwordInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
            });

            // Form validation enhancement
            const form = document.getElementById('createUserForm');
            form.addEventListener('submit', function(e) {
                const password = passwordInput.value;
                const username = document.getElementById('username').value;
                
                // Password validation
                if (password.length < 8) {
                    e.preventDefault();
                    showAlert('Password Too Short', 'Password must be at least 8 characters long.', 'warning');
                    passwordInput.focus();
                    return false;
                }
                
                // Username validation
                if (!/^[a-zA-Z0-9_]+$/.test(username)) {
                    e.preventDefault();
                    showAlert('Invalid Username', 'Username can only contain letters, numbers, and underscores.', 'warning');
                    document.getElementById('username').focus();
                    return false;
                }
                
                // Show loading state
                const submitBtn = document.getElementById('submitBtn');
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Creating User...';
                submitBtn.disabled = true;
            });

            // Reset form functionality
            document.getElementById('resetFormBtn').addEventListener('click', function() {
                form.reset();
                toggleCollegeField();
                strengthBar.style.width = '0%';
                strengthBar.className = 'password-strength-bar';
                strengthText.textContent = 'Weak';
                passwordInput.setAttribute('type', 'password');
                passwordToggleIcon.className = 'bi bi-eye text-muted';
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

            // Alert function
            function showAlert(title, text, icon) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: title,
                        text: text,
                        icon: icon,
                        confirmButtonColor: '#667eea',
                        customClass: {
                            popup: 'rounded-4 shadow-lg',
                            confirmButton: 'rounded-3'
                        }
                    });
                } else {
                    alert(text);
                }
            }
        });
    </script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection 