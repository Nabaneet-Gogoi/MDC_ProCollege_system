@extends('college.layouts.app')

@section('title', 'Change Password')

@section('content')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%);
    --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
    --warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
    --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
    --danger-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
    --secondary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
}

/* Modern Header Styling */
.modern-header {
    background: var(--primary-gradient);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 8px 24px rgba(30, 60, 114, 0.15);
}

.modern-header h1 {
    color: white;
    font-size: 1.5rem;
    margin: 0;
    font-weight: 600;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Modern Card Styling */
.modern-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    overflow: hidden;
}

.modern-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.modern-card .card-header {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 16px;
    font-weight: 600;
    color: #334155;
    font-size: 0.95rem;
}

.modern-card .card-body {
    padding: 20px;
}

.modern-card .card-footer {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-top: 1px solid #e2e8f0;
    padding: 12px 16px;
}

/* Enhanced Buttons */
.btn-modern {
    border-radius: 8px;
    font-weight: 500;
    padding: 12px 24px;
    font-size: 0.9rem;
    border: 1px solid rgba(255,255,255,0.3);
    backdrop-filter: blur(2px);
    transition: all 0.3s ease;
    min-width: 120px;
}

.btn-modern.btn-primary {
    background: var(--primary-gradient);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-modern.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
}

.btn-modern.btn-secondary {
    background: var(--secondary-gradient);
    color: white;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.btn-modern.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
}

/* Enhanced Form Controls */
.form-control-modern {
    border-radius: 8px;
    border: 2px solid #e2e8f0;
    padding: 12px 16px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
}

.form-control-modern:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    background: #ffffff;
    transform: translateY(-1px);
}

.form-control-modern.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
}

/* Enhanced Labels */
.form-label-modern {
    font-weight: 600;
    color: #374151;
    font-size: 0.9rem;
    margin-bottom: 8px;
    display: block;
}

/* Enhanced Alert */
.alert-modern {
    border: none;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.9rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    margin-bottom: 16px;
}

.alert-modern.alert-success {
    background: linear-gradient(135deg, rgba(5, 150, 105, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    border-left: 4px solid #10b981;
    color: #065f46;
}

/* Security Info Styling */
.security-info {
    background: linear-gradient(135deg, rgba(8, 145, 178, 0.05) 0%, rgba(6, 182, 212, 0.05) 100%);
    border-left: 4px solid #06b6d4;
    color: #0c4a6e;
    font-size: 0.85rem;
    line-height: 1.5;
}

/* Enhanced Icon Styling */
.icon-primary {
    color: #3b82f6;
    margin-right: 8px;
}

.icon-info {
    color: #06b6d4;
    margin-right: 6px;
}

/* Compact Layout Utilities */
.compact-spacing {
    margin-bottom: 16px;
}

/* Password Strength Indicator */
.password-strength {
    margin-top: 8px;
    font-size: 0.8rem;
    color: #64748b;
}

/* Form Group Spacing */
.form-group-modern {
    margin-bottom: 20px;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .modern-header {
        padding: 12px;
        margin-bottom: 12px;
    }
    
    .modern-header h1 {
        font-size: 1.3rem;
    }
    
    .modern-card .card-body {
        padding: 16px;
    }
    
    .btn-modern {
        padding: 10px 20px;
        font-size: 0.85rem;
    }
    
    .form-control-modern {
        padding: 10px 12px;
        font-size: 0.85rem;
    }
}
</style>

<div class="modern-header">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <h1 class="h2"><i class="bi bi-key icon-primary"></i>Change Password</h1>
        <div class="btn-toolbar">
            <a href="{{ route('college.profile.index') }}" class="btn btn-modern btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Profile
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-modern alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="modern-card compact-spacing">
            <div class="card-header">
                <i class="bi bi-shield-lock icon-primary"></i>
                Update Password
            </div>
            <div class="card-body">
                <form action="{{ route('college.profile.update-password') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group-modern">
                        <label for="current_password" class="form-label-modern">
                            Current Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" 
                               class="form-control-modern @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password" 
                               required
                               placeholder="Enter your current password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="password" class="form-label-modern">
                            New Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" 
                               class="form-control-modern @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required
                               placeholder="Enter your new password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="password-strength">
                            <i class="bi bi-info-circle icon-info"></i>
                            Password must be at least 8 characters long and include a mix of letters, numbers, and symbols.
                        </div>
                    </div>
                    
                    <div class="form-group-modern">
                        <label for="password_confirmation" class="form-label-modern">
                            Confirm New Password <span class="text-danger">*</span>
                        </label>
                        <input type="password" 
                               class="form-control-modern" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               placeholder="Confirm your new password">
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-modern btn-primary">
                            <i class="bi bi-save me-2"></i> Update Password
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer security-info">
                <i class="bi bi-exclamation-triangle-fill icon-info"></i>
                <strong>Security Notice:</strong> For your protection, you will be automatically logged out and required to sign in again after successfully changing your password.
            </div>
        </div>
    </div>
</div>
@endsection 