@extends('admin.layouts.app')

@section('content')
    <style>
        .modern-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            color: white;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.3;
        }

        .modern-header h1 {
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
            z-index: 2;
            position: relative;
        }

        .modern-btn {
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            font-size: 13px;
            position: relative;
            z-index: 10;
            cursor: pointer;
            pointer-events: auto;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .modern-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(79, 172, 254, 0.4);
            color: white;
        }

        .modern-btn-outline {
            background: rgba(255, 255, 255, 0.1);
            color: #667eea;
            border: 1px solid rgba(102, 126, 234, 0.2);
            backdrop-filter: blur(10px);
        }

        .modern-btn-outline:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
            color: #667eea;
        }

        .modern-card {
            background: #fff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            margin-bottom: 20px;
        }

        .modern-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .modern-card-header {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            padding: 14px 18px;
            font-weight: 600;
            color: #2C3E50;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
        }

        .modern-card-body {
            padding: 18px;
        }

        .modern-form-select, .modern-form-control {
            border-radius: 8px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            padding: 8px 12px;
            transition: all 0.3s ease;
            font-size: 12px;
            font-weight: 500;
        }

        .modern-form-select:focus, .modern-form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .modern-table {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .modern-table th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 10px;
            border: none;
        }

        .modern-table td {
            padding: 12px 10px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            font-size: 12px;
            font-weight: 500;
            vertical-align: middle;
        }

        .modern-table tbody tr {
            transition: all 0.3s ease;
        }

        .modern-table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }

        .modern-badge {
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .modern-badge-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modern-badge-success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .modern-btn-group {
            display: flex;
            gap: 4px;
            align-items: center;
        }

        .modern-btn-sm {
            padding: 6px 8px;
            font-size: 10px;
            border-radius: 6px;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 30px;
            height: 30px;
        }

        .modern-btn-info {
            background: #17a2b8;
            color: white;
        }

        .modern-btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .modern-btn-danger {
            background: #dc3545;
            color: white;
        }

        .modern-btn-sm:hover {
            transform: translateY(-1px) scale(1.05);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
        }

        .modern-alert {
            border-radius: 12px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 16px;
            box-shadow: 0 3px 16px rgba(0, 0, 0, 0.1);
            animation: slideIn 0.5s ease;
        }

        .modern-alert-success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .filter-section {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-radius: 16px;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 12px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 14px 16px;
            box-shadow: 0 3px 16px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: white;
        }

        .stat-content h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #2C3E50;
        }

        .stat-content p {
            margin: 0;
            font-size: 11px;
            color: #6C757D;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .modern-header {
                padding: 16px;
                margin-bottom: 16px;
            }
            
            .modern-header h1 {
                font-size: 1.5rem;
            }
            
            .modern-card-body {
                padding: 16px;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            
            .modern-table {
                font-size: 12px;
            }
            
            .modern-btn {
                padding: 10px 16px;
                font-size: 12px;
            }
        }
    </style>

    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h1><i class="bi bi-mortarboard me-2"></i>Colleges Management</h1>
            <a href="{{ route('admin.colleges.create') }}" class="modern-btn modern-btn-primary">
                <i class="bi bi-plus-circle"></i>
                Add New College
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="modern-alert modern-alert-success" role="alert">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="bi bi-mortarboard"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $colleges->total() }}</h3>
                <p>Total Colleges</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="bi bi-geo-alt"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $colleges->pluck('state')->unique()->count() }}</h3>
                <p>States Covered</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <i class="bi bi-building"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $colleges->where('type', 'professional')->count() }}</h3>
                <p>Professional Colleges</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
                <i class="bi bi-hospital"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $colleges->where('type', 'MDC')->count() }}</h3>
                <p>Model Degree Colleges</p>
            </div>
        </div>
    </div>

    <!-- Modern Filter Card -->
    <div class="filter-section">
        <div class="d-flex align-items-center mb-3">
            <i class="bi bi-funnel me-2" style="color: #667eea; font-size: 18px;"></i>
            <h5 class="mb-0" style="color: #2C3E50; font-weight: 600;">Filter & Search Colleges</h5>
        </div>
        
        <form action="{{ route('admin.colleges.index') }}" method="GET">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <label for="state" class="form-label" style="font-weight: 600; color: #2C3E50; font-size: 12px;">State</label>
                    <select class="form-select modern-form-select" id="state" name="state">
                        <option value="">All States</option>
                        @foreach($colleges->pluck('state')->unique()->sort() as $state)
                            <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <label for="district" class="form-label" style="font-weight: 600; color: #2C3E50; font-size: 12px;">District</label>
                    <select class="form-select modern-form-select" id="district" name="district">
                        <option value="">All Districts</option>
                        @foreach($colleges->pluck('district')->unique()->sort() as $district)
                            <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                {{ $district }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <label for="type" class="form-label" style="font-weight: 600; color: #2C3E50; font-size: 12px;">College Type</label>
                    <select class="form-select modern-form-select" id="type" name="type">
                        <option value="">All Types</option>
                        <option value="professional" {{ request('type') == 'professional' ? 'selected' : '' }}>Professional</option>
                        <option value="MDC" {{ request('type') == 'MDC' ? 'selected' : '' }}>MDC</option>
                    </select>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <label for="phase" class="form-label" style="font-weight: 600; color: #2C3E50; font-size: 12px;">Phase</label>
                    <select class="form-select modern-form-select" id="phase" name="phase">
                        <option value="">All Phases</option>
                        @foreach($colleges->whereNotNull('phase')->pluck('phase')->unique()->sort() as $phase)
                            <option value="{{ $phase }}" {{ request('phase') == $phase ? 'selected' : '' }}>
                                Phase {{ $phase }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="d-flex justify-content-end mt-3 gap-2">
                <a href="{{ route('admin.colleges.index') }}" class="modern-btn modern-btn-outline">
                    <i class="bi bi-x-circle"></i>
                    Clear Filters
                </a>
                <button type="submit" class="modern-btn modern-btn-primary">
                    <i class="bi bi-search"></i>
                    Apply Filters
                </button>
            </div>
        </form>
    </div>

    <!-- Modern Data Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <i class="bi bi-table"></i>
            Colleges Directory
            <div class="ms-auto">
                <small style="color: #6C757D;">{{ $colleges->count() }} of {{ $colleges->total() }} colleges</small>
            </div>
        </div>
        <div class="modern-card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover modern-table mb-0">
                    <thead>
                        <tr>
                            <th>College ID</th>
                            <th>College Name</th>
                            <th>Location</th>
                            <th>Type</th>
                            <th>Phase</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($colleges as $college)
                            <tr>
                                <td>
                                    <span style="font-weight: 600; color: #667eea;">{{ $college->college_id }}</span>
                                </td>
                                <td>
                                    <div>
                                        <div style="font-weight: 600; color: #2C3E50;">{{ $college->college_name }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 12px;">
                                        <div style="font-weight: 600; color: #2C3E50;">{{ $college->district }}</div>
                                        <div style="color: #6C757D;">{{ $college->state }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($college->type === 'professional')
                                        <span class="modern-badge modern-badge-primary">
                                            <i class="bi bi-mortarboard"></i>
                                            Professional
                                        </span>
                                    @else
                                        <span class="modern-badge modern-badge-success">
                                            <i class="bi bi-hospital"></i>
                                            MDC
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($college->type === 'MDC' && $college->phase)
                                        <span style="font-weight: 600; color: #667eea;">Phase {{ $college->phase }}</span>
                                    @else
                                        <span style="color: #6C757D; font-style: italic;">—</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="modern-btn-group">
                                        <a href="{{ route('admin.colleges.show', $college->college_id) }}" 
                                           class="modern-btn-sm modern-btn-info" 
                                           title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.colleges.edit', $college->college_id) }}" 
                                           class="modern-btn-sm modern-btn-warning" 
                                           title="Edit College">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.colleges.destroy', $college->college_id) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this college? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="modern-btn-sm modern-btn-danger" 
                                                    title="Delete College">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div style="color: #6C757D;">
                                        <i class="bi bi-inbox" style="font-size: 48px; opacity: 0.5;"></i>
                                        <div class="mt-2">No colleges found matching your criteria.</div>
                                        <small>Try adjusting your filters or <a href="{{ route('admin.colleges.create') }}" style="color: #667eea;">add a new college</a>.</small>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($colleges->hasPages())
                <div class="d-flex justify-content-center py-4" style="background: #f8f9fa; border-top: 1px solid rgba(102, 126, 234, 0.1);">
                    {{ $colleges->links() }}
                </div>
            @endif
        </div>
    </div>

    <script>
        // Add smooth scrolling and enhanced interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading state to filter form
            const filterForm = document.querySelector('form');
            if (filterForm) {
                filterForm.addEventListener('submit', function() {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.innerHTML;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Filtering...';
                    submitBtn.disabled = true;
                });
            }

            // Enhanced table row interactions
            const tableRows = document.querySelectorAll('.modern-table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function() {
                    this.style.background = 'rgba(102, 126, 234, 0.08)';
                });
                
                row.addEventListener('mouseleave', function() {
                    this.style.background = '';
                });
            });

            // Auto-dismiss alerts
            const alerts = document.querySelectorAll('.modern-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>
@endsection 