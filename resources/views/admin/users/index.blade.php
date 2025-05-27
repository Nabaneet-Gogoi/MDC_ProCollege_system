@extends('admin.layouts.app')

@section('title', 'Users Management')

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
                                    <i class="bi bi-people-fill fs-4 text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h1 class="h3 mb-1 fw-bold text-white">Users Management</h1>
                                <p class="mb-0 text-white-50">Manage system users and their permissions</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-white bg-opacity-20 text-black px-3 py-2 rounded-pill">
                                <i class="bi bi-person-check me-1"></i>
                                {{ $users->total() }} Total Users
                            </span>
                            <a href="{{ route('admin.users.create') }}" 
                               class="btn btn-light btn-modern rounded-pill px-4 py-2 shadow-sm hover-lift">
                                <i class="bi bi-plus-lg me-2"></i>Add New User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Alert with Modern Design -->
    @if(session('success'))
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert border-0 shadow-sm rounded-4 d-flex align-items-center" 
                     style="background: linear-gradient(135deg, #d4edda, #c3e6cb) !important;">
                    <div class="me-3">
                        <div class="alert-icon bg-success bg-opacity-20 d-flex align-items-center justify-content-center rounded-circle" 
                             style="width: 40px; height: 40px;">
                            <i class="bi bi-check-circle-fill text-success"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <strong class="text-success">Success!</strong>
                        <span class="text-success-emphasis">{{ session('success') }}</span>
                    </div>
                    <button type="button" class="btn-close btn-close-success" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        </div>
    @endif

    <!-- Modern Filter Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header border-0 text-white py-3 gradient-filter">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="bi bi-funnel-fill"></i>
                        </div>
                        <h5 class="mb-0 fw-semibold">Filter & Search Users</h5>
                    </div>
                </div>
                <div class="card-body p-4" style="background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%) !important;">
                    <form action="{{ route('admin.users.index') }}" method="GET" id="filterForm">
                        <div class="row g-4">
                            <div class="col-lg-3 col-md-6">
                                <label for="role" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-shield-check me-1 text-primary"></i>Role
                                </label>
                                <select class="form-select rounded-3 border-2 focus-ring" id="role" name="role" 
                                        style="border-color: #e0e6ed; transition: all 0.3s ease;">
                                    <option value="">All Roles</option>
                                    <option value="rusa" {{ request('role') == 'rusa' ? 'selected' : '' }}>RUSA</option>
                                    <option value="college" {{ request('role') == 'college' ? 'selected' : '' }}>College</option>
                                </select>
                            </div>
                            
                            <div class="col-lg-4 col-md-6">
                                <label for="college_id" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-building me-1 text-success"></i>College
                                </label>
                                <select class="form-select rounded-3 border-2 focus-ring" id="college_id" name="college_id"
                                        style="border-color: #e0e6ed; transition: all 0.3s ease;">
                                    <option value="">All Colleges</option>
                                    @foreach($users->pluck('college')->filter()->unique('college_id')->sortBy('college_name') as $college)
                                        <option value="{{ $college->college_id }}" {{ request('college_id') == $college->college_id ? 'selected' : '' }}>
                                            {{ $college->college_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-lg-3 col-md-6">
                                <label for="username" class="form-label fw-semibold text-dark">
                                    <i class="bi bi-search me-1 text-info"></i>Username
                                </label>
                                <input type="text" class="form-control rounded-3 border-2 focus-ring" 
                                       id="username" name="username" value="{{ request('username') }}" 
                                       placeholder="Search username..."
                                       style="border-color: #e0e6ed; transition: all 0.3s ease;">
                            </div>
                            
                            <div class="col-lg-2 col-md-6 d-flex align-items-end">
                                <div class="d-flex gap-2 w-100">
                                    <button type="submit" class="btn rounded-3 px-4 flex-grow-1 hover-lift"
                                            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: none !important; color: white !important;">
                                        <i class="bi bi-funnel me-1"></i>Filter
                                    </button>
                                    <a href="{{ route('admin.users.index') }}" 
                                       class="btn btn-light border-2 rounded-3 px-3 hover-lift"
                                       style="border-color: #e0e6ed;">
                                        <i class="bi bi-x-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modern Users Table -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header border-0 py-3 gradient-table">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <i class="bi bi-table text-dark"></i>
                            </div>
                            <h5 class="mb-0 fw-semibold text-dark">Users Directory</h5>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <span class="badge bg-dark bg-opacity-20 text-light px-3 py-2 rounded-pill">
                                Page {{ $users->currentPage() }} of {{ $users->lastPage() }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 modern-table">
                            <thead class="sticky-top" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%) !important;">
                                <tr>
                                    <th class="border-0 py-4 px-4 fw-bold text-dark">
                                        <i class="bi bi-hash me-1 text-primary"></i>ID
                                    </th>
                                    <th class="border-0 py-4 px-4 fw-bold text-dark">
                                        <i class="bi bi-person me-1 text-success"></i>User Details
                                    </th>
                                    <th class="border-0 py-4 px-4 fw-bold text-dark">
                                        <i class="bi bi-shield me-1 text-warning"></i>Role
                                    </th>
                                    <th class="border-0 py-4 px-4 fw-bold text-dark">
                                        <i class="bi bi-building me-1 text-info"></i>College
                                    </th>
                                    <th class="border-0 py-4 px-4 fw-bold text-dark">
                                        <i class="bi bi-calendar me-1 text-secondary"></i>Joined
                                    </th>
                                    <th class="border-0 py-4 px-4 fw-bold text-dark text-center">
                                        <i class="bi bi-gear me-1 text-dark"></i>Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $index => $user)
                                    <tr class="table-row-hover" style="border-bottom: 1px solid #f0f2f5; transition: all 0.3s ease;">
                                        <td class="py-4 px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="user-id-badge bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                     style="width: 32px; height: 32px; font-size: 0.75rem; font-weight: bold;">
                                                    {{ $user->user_id }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="d-flex align-items-center">
                                                <div class="user-avatar bg-gradient rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 45px; height: 45px; background: linear-gradient(135deg, {{ $index % 2 == 0 ? '#667eea, #764ba2' : '#f093fb, #f5576c' }});">
                                                    <span class="text-white fw-bold">{{ strtoupper(substr($user->username, 0, 2)) }}</span>
                                                </div>
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ $user->username }}</div>
                                                    <small class="text-muted">User ID: {{ $user->user_id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($user->role === 'college')
                                                <span class="badge rounded-pill px-3 py-2" 
                                                      style="background: linear-gradient(135deg, #28a745, #20c997); color: white; font-weight: 500;">
                                                    <i class="bi bi-mortarboard me-1"></i>College
                                                </span>
                                            @else
                                                <span class="badge rounded-pill px-3 py-2" 
                                                      style="background: linear-gradient(135deg, #17a2b8, #007bff); color: white; font-weight: 500;">
                                                    <i class="bi bi-shield-check me-1"></i>{{ ucfirst($user->role) }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            @if($user->college)
                                                <div class="college-info">
                                                    <a href="{{ route('admin.colleges.show', $user->college->college_id) }}" 
                                                       class="text-decoration-none fw-semibold"
                                                       style="color: #6f42c1; transition: all 0.3s ease;">
                                                        {{ $user->college->college_name }}
                                                    </a>
                                                    <div class="text-muted small">ID: {{ $user->college->college_id }}</div>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center text-muted">
                                                    <i class="bi bi-dash-circle me-1"></i>
                                                    <span>Not Assigned</span>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="bi bi-calendar-event me-2 text-info"></i>
                                                <div>
                                                    <div>{{ $user->created_at->format('M d, Y') }}</div>
                                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="d-flex justify-content-center gap-1">
                                                <a href="{{ route('admin.users.show', $user->user_id) }}" 
                                                   class="btn btn-sm rounded-3 px-3 py-2 border-0 hover-lift" 
                                                   style="background: linear-gradient(135deg, #17a2b8, #20c997) !important; color: white !important;"
                                                   data-bs-toggle="tooltip" title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.users.edit', $user->user_id) }}" 
                                                   class="btn btn-sm rounded-3 px-3 py-2 border-0 hover-lift" 
                                                   style="background: linear-gradient(135deg, #ffc107, #fd7e14) !important; color: white !important;"
                                                   data-bs-toggle="tooltip" title="Edit User">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.users.destroy', $user->user_id) }}" 
                                                      method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            class="btn btn-sm rounded-3 px-3 py-2 border-0 hover-lift" 
                                                            style="background: linear-gradient(135deg, #dc3545, #e74c3c) !important; color: white !important;"
                                                            data-bs-toggle="tooltip" title="Delete User">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="empty-state">
                                                <div class="mb-3">
                                                    <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                                                </div>
                                                <h5 class="text-muted mb-2">No Users Found</h5>
                                                <p class="text-muted mb-3">No users match your current filter criteria.</p>
                                                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary rounded-pill">
                                                    <i class="bi bi-arrow-clockwise me-1"></i>Clear Filters
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                @if($users->hasPages())
                    <div class="card-footer border-0 py-4" style="background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%) !important;">
                        <div class="d-flex justify-content-center">
                            <nav aria-label="Users pagination">
                                {{ $users->links('pagination::bootstrap-4') }}
                            </nav>
                        </div>
                    </div>
                @endif
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
        
        .gradient-filter {
            background: #4facfe !important; /* Fallback */
            background: -webkit-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            background: -moz-linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%) !important;
            color: white !important;
        }
        
        .gradient-table {
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
        
        .focus-ring:focus {
            border-color: #667eea !important;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25) !important;
        }
        
        .table-row-hover:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05), rgba(118, 75, 162, 0.05)) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .modern-table th {
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        .college-info a:hover {
            color: #5a2d91 !important;
            text-decoration: underline !important;
        }
        
        .user-avatar {
            font-size: 0.85rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .alert-icon {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
            
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .btn-group .btn {
                padding: 0.375rem 0.5rem;
            }
        }
        
        /* Custom pagination styling */
        .pagination {
            --bs-pagination-active-bg: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --bs-pagination-active-border-color: #667eea;
        }
        
        .pagination .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
            border: 1px solid #e0e6ed;
            color: #6c757d;
            transition: all 0.3s ease;
        }
        
        .pagination .page-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
            transform: translateY(-1px);
        }
        
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
        }
    </style>

    <!-- Enhanced JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
            
            // Enhanced delete confirmation
            document.querySelectorAll('.delete-form').forEach(function(form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Check if SweetAlert2 is available
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "This action cannot be undone!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#dc3545',
                            cancelButtonColor: '#6c757d',
                            confirmButtonText: 'Yes, delete it!',
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
            
            // Auto-submit filter form on select change (optional)
            document.querySelectorAll('#role, #college_id').forEach(function(select) {
                select.addEventListener('change', function() {
                    // Uncomment the line below if you want auto-submit on filter change
                    // document.getElementById('filterForm').submit();
                });
            });
            
            // Add smooth scroll for page navigation
            document.querySelectorAll('.pagination a').forEach(function(link) {
                link.addEventListener('click', function() {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                });
            });
                 });
     </script>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection 