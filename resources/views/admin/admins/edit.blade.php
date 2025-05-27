@extends('admin.layouts.app')

@section('title', 'Edit Admin')

@section('content')
    <style>
        /* Modern Header Design */
        .modern-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            color: white;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.2);
            position: relative;
            overflow: hidden;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.6;
            pointer-events: none;
        }

        .modern-header h1 {
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
            z-index: 2;
            position: relative;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .modern-header-subtitle {
            font-size: 0.9rem;
            margin: 4px 0 0 0;
            opacity: 0.9;
            font-weight: 400;
            z-index: 2;
            position: relative;
        }

        .modern-header-toolbar {
            display: flex;
            gap: 12px;
            align-items: center;
            z-index: 2;
            position: relative;
        }

        /* Modern Button Styles */
        .modern-btn {
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.3);
            color: white;
        }

        .modern-btn-secondary {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
        }

        .modern-btn-secondary:hover {
            background: linear-gradient(135deg, #5a6268 0%, #343a40 100%);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
        }

        .modern-btn-outline {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .modern-btn-outline:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
            color: white;
        }

        /* Modern Card Styles */
        .modern-card {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            margin-bottom: 24px;
        }

        .modern-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .modern-card-header {
            background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
            padding: 16px 24px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .modern-card-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            flex-shrink: 0;
        }

        .modern-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #2C3E50;
            margin: 0;
            flex: 1;
        }

        .modern-card-header-decoration {
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
            position: absolute;
            bottom: 0;
            left: 24px;
        }

        .modern-card-body {
            padding: 24px;
        }

        /* Modern Form Styles */
        .modern-form-group {
            margin-bottom: 20px;
        }

        .modern-form-label {
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 8px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modern-form-label i {
            color: #667eea;
        }

        .modern-form-label .required {
            color: #fa709a;
            font-weight: 700;
        }

        .modern-form-control {
            border-radius: 12px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            padding: 12px 16px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            background: #fff;
            width: 100%;
        }

        .modern-form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .modern-form-control.is-invalid {
            border-color: #fa709a;
            box-shadow: 0 0 0 4px rgba(250, 112, 154, 0.1);
        }

        .modern-invalid-feedback {
            color: #fa709a;
            font-size: 12px;
            font-weight: 600;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .modern-form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .modern-form-hint {
            font-size: 12px;
            color: #6C757D;
            margin-top: 4px;
            font-style: italic;
        }

        /* Action Section */
        .action-section {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            margin-top: 24px;
        }

        .action-grid {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-header {
                padding: 16px 20px;
            }

            .modern-header h1 {
                font-size: 1.5rem;
            }

            .modern-header-toolbar {
                flex-direction: column;
                gap: 8px;
                align-items: stretch;
            }

            .modern-card-body {
                padding: 20px 16px;
            }

            .modern-form-row {
                grid-template-columns: 1fr;
            }

            .action-grid {
                flex-direction: column;
            }
        }
    </style>

    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h1>Edit Administrator</h1>
                <div class="modern-header-subtitle">Update administrator account information</div>
            </div>
            <div class="modern-header-toolbar">
                <a href="{{ route('admin.admins.index') }}" class="modern-btn modern-btn-outline">
                    <i class="bi bi-arrow-left"></i> Back to Admins
                </a>
            </div>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <div class="modern-card-header-icon">
                <i class="bi bi-person-gear"></i>
            </div>
            <div class="modern-card-title">Edit Administrator Information</div>
            <div class="modern-card-header-decoration"></div>
        </div>
        <div class="modern-card-body">
            <form action="{{ route('admin.admins.update', $admin->admin_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <!-- Email Field -->
                <div class="modern-form-group">
                    <label for="email" class="modern-form-label">
                        <i class="bi bi-envelope"></i>
                        Email Address 
                        <span class="required">*</span>
                    </label>
                    <input type="email" 
                           class="modern-form-control @error('email') is-invalid @enderror" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $admin->email) }}" 
                           required
                           placeholder="Enter email address">
                    @error('email')
                        <div class="modern-invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Phone Number Field -->
                <div class="modern-form-group">
                    <label for="phone_no" class="modern-form-label">
                        <i class="bi bi-telephone"></i>
                        Phone Number 
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           class="modern-form-control @error('phone_no') is-invalid @enderror" 
                           id="phone_no" 
                           name="phone_no" 
                           value="{{ old('phone_no', $admin->phone_no) }}" 
                           required
                           placeholder="Enter phone number">
                    @error('phone_no')
                        <div class="modern-invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <!-- Password Fields -->
                <div class="modern-form-row">
                    <div class="modern-form-group">
                        <label for="password" class="modern-form-label">
                            <i class="bi bi-lock"></i>
                            New Password
                        </label>
                        <input type="password" 
                               class="modern-form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password"
                               placeholder="Enter new password">
                        <div class="modern-form-hint">Leave blank to keep current password</div>
                        @error('password')
                            <div class="modern-invalid-feedback">
                                <i class="bi bi-exclamation-circle"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="modern-form-group">
                        <label for="password_confirmation" class="modern-form-label">
                            <i class="bi bi-lock-fill"></i>
                            Confirm New Password
                        </label>
                        <input type="password" 
                               class="modern-form-control" 
                               id="password_confirmation" 
                               name="password_confirmation"
                               placeholder="Confirm new password">
                        <div class="modern-form-hint">Must match the new password</div>
                    </div>
                </div>
                
                <!-- Actions Section -->
                <div class="action-section">
                    <div class="action-grid">
                        <button type="submit" class="modern-btn modern-btn-primary">
                            <i class="bi bi-save"></i> Update Administrator
                        </button>
                        <a href="{{ route('admin.admins.index') }}" class="modern-btn modern-btn-secondary">
                            <i class="bi bi-x-circle"></i> Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Enhanced Interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add real-time validation feedback
            const form = document.querySelector('form');
            const passwordField = document.getElementById('password');
            const confirmPasswordField = document.getElementById('password_confirmation');
            
            // Password confirmation validation
            function validatePasswordConfirmation() {
                if (passwordField.value && confirmPasswordField.value) {
                    if (passwordField.value !== confirmPasswordField.value) {
                        confirmPasswordField.style.borderColor = '#fa709a';
                        confirmPasswordField.style.boxShadow = '0 0 0 4px rgba(250, 112, 154, 0.1)';
                    } else {
                        confirmPasswordField.style.borderColor = '#4facfe';
                        confirmPasswordField.style.boxShadow = '0 0 0 4px rgba(79, 172, 254, 0.1)';
                    }
                }
            }
            
            if (passwordField && confirmPasswordField) {
                passwordField.addEventListener('input', validatePasswordConfirmation);
                confirmPasswordField.addEventListener('input', validatePasswordConfirmation);
            }
            
            // Form submission loading state
            form.addEventListener('submit', function() {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Updating...';
                    submitButton.disabled = true;
                }
            });
        });

        // Add spin animation for loading
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .spin {
                animation: spin 1s linear infinite;
            }
        `;
        document.head.appendChild(style);
    </script>
@endsection 