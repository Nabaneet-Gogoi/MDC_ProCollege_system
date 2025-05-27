@extends('admin.layouts.app')

@section('title', 'User Details')

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
                                    <i class="bi bi-person-circle fs-4 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h1 class="h3 mb-1 fw-bold text-white">User Details</h1>
                                <p class="mb-0 text-white-50">{{ $user->username }} • {{ ucfirst($user->role) }}</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('admin.users.index') }}" 
                               class="btn btn-light btn-modern rounded-pill px-4 py-2 shadow-sm hover-lift">
                                <i class="bi bi-arrow-left me-2"></i>Back to Users
                            </a>
                            <a href="{{ route('admin.users.edit', $user->user_id) }}" 
                               class="btn btn-warning rounded-pill px-4 py-2 shadow-sm hover-lift"
                               style="background: linear-gradient(135deg, #ffc107, #fd7e14) !important; color: white !important; border: none;">
                                <i class="bi bi-pencil me-2"></i>Edit User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern User Information Cards -->
    <div class="row">
        <!-- Main User Information -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header border-0 py-3 gradient-info">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="bi bi-person-vcard text-white"></i>
                        </div>
                        <h5 class="mb-0 fw-semibold text-white">User Information</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 modern-details-table">
                            <tbody>
                                <tr class="detail-row">
                                    <th class="border-0 py-4 px-4 fw-bold text-dark bg-light" style="width: 30%;">
                                        <i class="bi bi-hash me-2 text-primary"></i>User ID
                                    </th>
                                    <td class="border-0 py-4 px-4">
                                        <div class="user-id-badge bg-primary bg-opacity-10 text-primary rounded-pill d-inline-flex align-items-center justify-content-center px-3 py-1" 
                                             style="font-family: 'Courier New', monospace; font-weight: bold;">
                                            {{ $user->user_id }}
                                        </div>
                                    </td>
                                </tr>
                                <tr class="detail-row">
                                    <th class="border-0 py-4 px-4 fw-bold text-dark bg-light">
                                        <i class="bi bi-person me-2 text-success"></i>Username
                                    </th>
                                    <td class="border-0 py-4 px-4">
                                        <div class="d-flex align-items-center">
                                            <div class="user-avatar bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea, #764ba2);">
                                                <span class="text-white fw-bold text-sm">{{ strtoupper(substr($user->username, 0, 2)) }}</span>
                                            </div>
                                            <div>
                                                <div class="fw-semibold text-dark">{{ $user->username }}</div>
                                                <small class="text-muted">Primary identifier</small>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="detail-row">
                                    <th class="border-0 py-4 px-4 fw-bold text-dark bg-light">
                                        <i class="bi bi-shield me-2 text-warning"></i>Role
                                    </th>
                                    <td class="border-0 py-4 px-4">
                                        @if($user->role === 'college')
                                            <span class="badge rounded-pill px-3 py-2" 
                                                  style="background: linear-gradient(135deg, #28a745, #20c997); color: white; font-weight: 500;">
                                                <i class="bi bi-mortarboard me-1"></i>College User
                                            </span>
                                        @else
                                            <span class="badge rounded-pill px-3 py-2" 
                                                  style="background: linear-gradient(135deg, #17a2b8, #007bff); color: white; font-weight: 500;">
                                                <i class="bi bi-shield-check me-1"></i>{{ ucfirst($user->role) }}
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="detail-row">
                                    <th class="border-0 py-4 px-4 fw-bold text-dark bg-light">
                                        <i class="bi bi-building me-2 text-info"></i>Associated College
                                    </th>
                                    <td class="border-0 py-4 px-4">
                                        @if($user->college)
                                            <div class="college-info">
                                                <a href="{{ route('admin.colleges.show', $user->college->college_id) }}" 
                                                   class="text-decoration-none fw-semibold d-flex align-items-center"
                                                   style="color: #6f42c1; transition: all 0.3s ease;">
                                                    <i class="bi bi-building me-2"></i>
                                                    <div>
                                                        <div>{{ $user->college->college_name }}</div>
                                                        <small class="text-muted">ID: {{ $user->college->college_id }}</small>
                                                    </div>
                                                </a>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="bi bi-dash-circle me-2"></i>
                                                <span>Not Assigned</span>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr class="detail-row">
                                    <th class="border-0 py-4 px-4 fw-bold text-dark bg-light">
                                        <i class="bi bi-calendar-plus me-2 text-secondary"></i>Created At
                                    </th>
                                    <td class="border-0 py-4 px-4">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-calendar-event me-2 text-info"></i>
                                            <div>
                                                <div class="fw-semibold">{{ $user->created_at->format('F d, Y h:i A') }}</div>
                                                <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="detail-row">
                                    <th class="border-0 py-4 px-4 fw-bold text-dark bg-light">
                                        <i class="bi bi-arrow-clockwise me-2 text-secondary"></i>Last Updated
                                    </th>
                                    <td class="border-0 py-4 px-4">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-clock-history me-2 text-warning"></i>
                                            <div>
                                                <div class="fw-semibold">{{ $user->updated_at->format('F d, Y h:i A') }}</div>
                                                <small class="text-muted">{{ $user->updated_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information & Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-header border-0 py-3 gradient-secondary">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="bi bi-info-circle text-white"></i>
                        </div>
                        <h5 class="mb-0 fw-semibold text-white">Additional Information</h5>
                    </div>
                </div>
                <div class="card-body p-4" style="background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);">
                    <div class="info-section mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="info-icon bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px; min-width: 40px;">
                                <i class="bi bi-person-gear text-primary"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">User Type</h6>
                                <p class="text-muted mb-0 small">
                                    @if($user->isCollegeUser())
                                        This user is associated with a specific college and can manage that college's data and operations.
                                    @else
                                        This is a RUSA administrator user with access to all colleges and system-wide management capabilities.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="info-section mb-4">
                        <div class="d-flex align-items-start">
                            <div class="info-icon bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px; min-width: 40px;">
                                <i class="bi bi-shield-check text-success"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-1">Access Level</h6>
                                <p class="text-muted mb-0 small">
                                    @if($user->role === 'college')
                                        Limited to assigned college operations
                                    @else
                                        Full system administration access
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4" style="border-color: #e9ecef;">

                    <!-- Action Buttons -->
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.users.edit', $user->user_id) }}" 
                           class="btn btn-lg rounded-3 hover-lift"
                           style="background: linear-gradient(135deg, #ffc107, #fd7e14) !important; color: white !important; border: none;">
                            <i class="bi bi-pencil me-2"></i>Edit User Details
                        </a>
                        
                        <form action="{{ route('admin.users.destroy', $user->user_id) }}" 
                              method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-lg w-100 rounded-3 hover-lift"
                                    style="background: linear-gradient(135deg, #dc3545, #e74c3c) !important; color: white !important; border: none;">
                                <i class="bi bi-trash me-2"></i>Delete User
                            </button>
                        </form>
                    </div>
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
        
        .gradient-info {
            background: #4facfe !important; /* Fallback */
            background: -webkit-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            background: -moz-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            color: white !important;
        }
        
        .gradient-secondary {
            background: #a8edea !important; /* Fallback */
            background: -webkit-linear-gradient(135deg, #a8edea 0%, #fed6e3 100%) !important;
            background: -moz-linear-gradient(135deg, #a8edea 0%, #fed6e3 100%) !important;
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%) !important;
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }
        
        .detail-row:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.03), rgba(118, 75, 162, 0.03)) !important;
        }
        
        .modern-details-table th {
            font-size: 0.9rem;
            letter-spacing: 0.3px;
            font-weight: 600;
        }
        
        .college-info a:hover {
            color: #5a2d91 !important;
            text-decoration: underline !important;
        }
        
        .user-avatar {
            font-size: 0.8rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .info-icon {
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .avatar-circle {
            box-shadow: 0 4px 15px rgba(255,255,255,0.2);
        }
        
        .user-id-badge {
            font-family: 'Courier New', monospace;
        }
        
        @media (max-width: 768px) {
            .card-header .d-flex {
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn-lg {
                padding: 0.75rem 1rem;
                font-size: 0.95rem;
            }
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Enhanced delete confirmation
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Check if SweetAlert2 is available
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This action cannot be undone! The user will be permanently deleted.",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete user!',
                            cancelButtonText: 'Cancel',
                            reverseButtons: true,
                            customClass: {
                                popup: 'rounded-4 shadow-lg',
                                confirmButton: 'rounded-3',
                                cancelButton: 'rounded-3'
                            }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    } else {
                        // Fallback to native confirm dialog
                        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
                            form.submit();
                        }
                    }
                });
            });
        });
    </script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection 