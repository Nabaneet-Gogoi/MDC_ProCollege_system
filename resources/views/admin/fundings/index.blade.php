@extends('admin.layouts.app')

@section('content')
    <style>
        /* Modern Header Styling */
        .modern-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
            color: white !important;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.1) 1px, transparent 0);
            background-size: 20px 20px;
            opacity: 0.3;
            pointer-events: none;
        }

        .modern-header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: white !important;
            position: relative;
            z-index: 2;
        }

        /* Statistics Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border: 1px solid rgba(102, 126, 234, 0.1);
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.15);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: white;
            flex-shrink: 0;
        }

        .stat-icon.total { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .stat-icon.professional { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }
        .stat-icon.mdc { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .stat-icon.amount { background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); }

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

        /* Modern Card Styling */
        .modern-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .modern-card-header {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            padding: 14px 18px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            font-weight: 600;
            font-size: 14px;
            color: #2C3E50;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .modern-card-body {
            padding: 18px;
        }

        /* Modern Form Controls */
        .modern-form-control, .modern-form-select {
            border-radius: 8px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .modern-form-control:focus, .modern-form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-label {
            font-weight: 600;
            font-size: 12px;
            color: #2C3E50;
            margin-bottom: 6px;
        }

        /* Modern Button System */
        .modern-btn {
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .modern-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(79, 172, 254, 0.3);
            color: white;
        }

        .modern-btn-secondary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

                 .modern-btn-secondary:hover {
             transform: translateY(-1px);
             box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
             color: white;
         }

         .modern-header .modern-btn-secondary {
             position: relative;
             z-index: 2;
             text-decoration: none;
         }

        .modern-btn-outline {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid #dee2e6;
        }

        .modern-btn-outline:hover {
            background: rgba(108, 117, 125, 0.2);
            color: #495057;
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

        .modern-btn-sm {
            font-size: 11px;
            padding: 6px 10px;
        }

        /* Modern Table */
        .modern-table {
            margin: 0;
            border-radius: 8px;
            overflow: hidden;
        }

        .modern-table thead th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            padding: 12px 10px;
        }

        .modern-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #f1f5f9;
        }

        .modern-table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }

        .modern-table tbody td {
            padding: 12px 10px;
            font-size: 12px;
            font-weight: 500;
            vertical-align: middle;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        }

        /* Modern Badges */
        .modern-badge {
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 8px;
        }

        .badge-professional {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .badge-mdc {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .badge-phase {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #2d3748;
        }

        .badge-status {
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            padding: 4px 8px;
        }

        /* Alert Styling */
        .modern-alert {
            border-radius: 10px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .modern-alert-success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-header {
                padding: 16px 20px;
            }
            
            .modern-card-body {
                padding: 16px;
            }
            
            .stats-container {
                grid-template-columns: 1fr;
            }
            
            .modern-btn {
                font-size: 11px;
                padding: 6px 12px;
            }
        }
    </style>

    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap position-relative">
            <h1><i class="bi bi-piggy-bank me-2"></i>Funding Allocations</h1>
            <a href="{{ route('admin.fundings.create') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-plus-circle"></i> Add New Funding
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="modern-alert modern-alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon total">
                <i class="bi bi-collection"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $fundings->count() }}</h3>
                <p>Total Fundings</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon professional">
                <i class="bi bi-mortarboard"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $fundings->where('college.type', 'professional')->count() }}</h3>
                <p>Professional Colleges</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon mdc">
                <i class="bi bi-hospital"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $fundings->where('college.type', 'MDC')->count() }}</h3>
                <p>Model Degree Colleges</p>
            </div>
        </div>
        
        <div class="stat-card">
            <div class="stat-icon amount">
                <i class="bi bi-currency-rupee"></i>
            </div>
            <div class="stat-content">
                <h3>{{ number_format($fundings->sum('approved_amt'), 1) }}Cr</h3>
                <p>Total Approved Amount</p>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <i class="bi bi-funnel me-2"></i>Filter Funding Allocations
        </div>
        <div class="modern-card-body">
            <form action="{{ route('admin.fundings.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="college_id" class="form-label">College</label>
                        <select class="form-select modern-form-select" id="college_id" name="college_id">
                            <option value="">All Colleges</option>
                            @foreach($fundings->pluck('college')->unique('college_id') as $college)
                                <option value="{{ $college->college_id }}" {{ request('college_id') == $college->college_id ? 'selected' : '' }}>
                                    {{ $college->college_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="type" class="form-label">Type</label>
                        <select class="form-select modern-form-select" id="type" name="type">
                            <option value="">All Types</option>
                            <option value="professional" {{ request('type') == 'professional' ? 'selected' : '' }}>Professional</option>
                            <option value="MDC" {{ request('type') == 'MDC' ? 'selected' : '' }}>MDC</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="phase" class="form-label">Phase</label>
                        <select class="form-select modern-form-select" id="phase" name="phase">
                            <option value="">All Phases</option>
                            @foreach($fundings->pluck('college.phase')->filter()->unique()->sort() as $phase)
                                <option value="{{ $phase }}" {{ request('phase') == $phase ? 'selected' : '' }}>
                                    Phase {{ $phase }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select modern-form-select" id="status" name="status">
                            <option value="">All Statuses</option>
                            <option value="not_started" {{ request('status') == 'not_started' ? 'selected' : '' }}>Not Started</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-3">
                        <label for="min_amount" class="form-label">Min Amount (Cr)</label>
                        <input type="number" step="0.01" class="form-control modern-form-control" id="min_amount" name="min_amount" value="{{ request('min_amount') }}" placeholder="0.00">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="max_amount" class="form-label">Max Amount (Cr)</label>
                        <input type="number" step="0.01" class="form-control modern-form-control" id="max_amount" name="max_amount" value="{{ request('max_amount') }}" placeholder="1000.00">
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.fundings.index') }}" class="modern-btn modern-btn-outline">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="bi bi-funnel"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <i class="bi bi-table me-2"></i>Funding Allocations List
        </div>
        <div class="modern-card-body">
            <div class="table-responsive">
                <table class="table table-hover modern-table mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>College</th>
                            <th>Type</th>
                            <th>Phase</th>
                            <th>Approved Amount</th>
                            <th>Central Share</th>
                            <th>State Share</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fundings as $funding)
                            <tr>
                                <td><strong>#{{ $funding->funding_id }}</strong></td>
                                <td>
                                    <div style="font-weight: 600; color: #2C3E50;">{{ $funding->college->college_name }}</div>
                                </td>
                                <td>
                                    @if($funding->college->type === 'professional')
                                        <span class="badge modern-badge badge-professional">Professional</span>
                                    @else
                                        <span class="badge modern-badge badge-mdc">MDC</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge modern-badge badge-phase">Phase {{ $funding->college->phase }}</span>
                                </td>
                                <td><strong style="color: #2C3E50;">₹ {{ number_format($funding->approved_amt, 2) }} Cr</strong></td>
                                <td>₹ {{ number_format($funding->central_share, 2) }} Cr</td>
                                <td>₹ {{ number_format($funding->state_share, 2) }} Cr</td>
                                <td>
                                    @if($funding->utilization_status === 'not_started')
                                        <span class="badge badge-status bg-secondary">Not Started</span>
                                    @elseif($funding->utilization_status === 'in_progress')
                                        <span class="badge badge-status bg-warning text-dark">In Progress</span>
                                    @else
                                        <span class="badge badge-status bg-success">Completed</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.fundings.show', $funding->funding_id) }}" class="modern-btn modern-btn-info modern-btn-sm" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.fundings.edit', $funding->funding_id) }}" class="modern-btn modern-btn-warning modern-btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.fundings.destroy', $funding->funding_id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="modern-btn modern-btn-danger modern-btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this funding allocation?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="bi bi-inbox display-6 text-muted d-block mb-2"></i>
                                    <span class="text-muted">No funding allocations found</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Enhanced form interaction
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Applying...';
                submitBtn.disabled = true;
            });
        });
    </script>
@endsection 