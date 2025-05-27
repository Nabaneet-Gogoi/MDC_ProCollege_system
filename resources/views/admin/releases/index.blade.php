@extends('admin.layouts.app')

@section('title', 'Fund Releases')

@section('content')
<style>
    /* Modern Design System Styles */
    .modern-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
    }
    
    .modern-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: radial-gradient(circle at 25% 25%, rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 20px 20px;
    }
    
    .modern-header h1 {
        color: white;
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .modern-btn {
        border-radius: 10px;
        font-weight: 600;
        font-size: 12px;
        padding: 8px 16px;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        position: relative;
        z-index: 10;
    }
    
    .modern-btn:hover {
        transform: translateY(-1px);
        text-decoration: none;
    }
    
    .modern-btn-primary {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(79, 172, 254, 0.3);
    }
    
    .modern-btn-primary:hover {
        box-shadow: 0 4px 16px rgba(79, 172, 254, 0.4);
        color: white;
    }
    
    .modern-btn-secondary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 3px 10px rgba(102, 126, 234, 0.3);
    }
    
    .modern-btn-secondary:hover {
        box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
        color: white;
    }
    
    .modern-btn-cancel {
        background: rgba(108, 117, 125, 0.15);
        color: #6c757d;
        border: 1px solid rgba(108, 117, 125, 0.2);
    }
    
    .modern-btn-cancel:hover {
        background: rgba(108, 117, 125, 0.25);
        color: #6c757d;
    }
    
    .modern-btn-info {
        background: #17a2b8;
        color: white;
        box-shadow: 0 3px 10px rgba(23, 162, 184, 0.3);
    }
    
    .modern-btn-warning {
        background: #ffc107;
        color: #212529;
        box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
    }
    
    .modern-btn-danger {
        background: #dc3545;
        color: white;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
    }
    
    .modern-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 24px;
        transition: all 0.3s ease;
    }
    
    .modern-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
    }
    
    .modern-card-header {
        background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
        border-bottom: none;
        padding: 16px 24px;
        font-weight: 600;
        font-size: 13px;
        color: #2c3e50;
    }
    
    .modern-card-body {
        padding: 20px 24px;
    }
    
    .modern-form-control {
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 8px 12px;
        font-size: 13px;
        transition: all 0.3s ease;
    }
    
    .modern-form-control:focus {
        border: 1px solid #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
        outline: none;
    }
    
    .modern-form-select {
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 8px 12px;
        font-size: 13px;
        transition: all 0.3s ease;
    }
    
    .modern-form-select:focus {
        border: 1px solid #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
        outline: none;
    }
    
    .form-label {
        font-weight: 600;
        font-size: 12px;
        color: #2c3e50;
        margin-bottom: 6px;
    }
    
    .modern-table {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }
    
    .modern-table thead th {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        font-weight: 600;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 16px;
        border: none;
    }
    
    .modern-table tbody tr {
        transition: all 0.3s ease;
        font-size: 13px;
    }
    
    .modern-table tbody tr:hover {
        background-color: rgba(79, 172, 254, 0.05);
        transform: scale(1.005);
    }
    
    .modern-table tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        vertical-align: middle;
    }
    
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 24px;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 16px;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 24px rgba(0, 0, 0, 0.15);
    }
    
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
    }
    
    .stat-content h3 {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        color: #2c3e50;
    }
    
    .stat-content p {
        font-size: 11px;
        color: #6c757d;
        margin: 0;
        font-weight: 500;
    }
    
    .modern-badge {
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
    }
    
    .modern-alert {
        border-radius: 12px;
        border: none;
        font-size: 13px;
        font-weight: 500;
    }
    
    @media (max-width: 768px) {
        .modern-header {
            padding: 16px 20px;
        }
        
        .modern-card-body {
            padding: 16px 20px;
        }
        
        .modern-btn {
            padding: 6px 12px;
            font-size: 11px;
        }
        
        .stats-container {
            grid-template-columns: 1fr;
        }
        
        .stat-card {
            padding: 16px;
        }
    }
</style>

<div class="container-fluid px-4">
    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h1><i class="bi bi-cash-coin me-2"></i>Fund Releases Management</h1>
            <a href="{{ route('admin.releases.create') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-plus-circle me-1"></i> New Release
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <i class="bi bi-cash-stack"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $releases->count() }}</h3>
                <p>Total Releases</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <i class="bi bi-currency-rupee"></i>
            </div>
            <div class="stat-content">
                <h3>₹{{ number_format($releases->sum('release_amt'), 0) }}</h3>
                <p>Total Amount</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $releases->filter(function($release) { return $release->funding->utilization_percentage >= 100; })->count() }}</h3>
                <p>Fully Utilized</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);">
                <i class="bi bi-building"></i>
            </div>
            <div class="stat-content">
                <h3>{{ $releases->pluck('funding.college')->unique('college_id')->count() }}</h3>
                <p>Active Colleges</p>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show modern-alert" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show modern-alert" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card modern-card">
        <div class="card-header modern-card-header">
            <i class="bi bi-funnel me-2"></i>Filter Fund Releases
        </div>
        <div class="card-body modern-card-body">
            <form action="{{ route('admin.releases.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="college_id" class="form-label">College</label>
                        <select class="form-select modern-form-select" id="college_id" name="college_id">
                            <option value="">All Colleges</option>
                            @foreach($releases->pluck('funding.college')->unique('college_id')->sortBy('college_name') as $college)
                                <option value="{{ $college->college_id }}" {{ request('college_id') == $college->college_id ? 'selected' : '' }}>
                                    {{ $college->college_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="date_from" class="form-label">Release Date From</label>
                        <input type="date" class="form-control modern-form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="date_to" class="form-label">Release Date To</label>
                        <input type="date" class="form-control modern-form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="min_amount" class="form-label">Min Amount (₹)</label>
                        <input type="number" step="0.01" class="form-control modern-form-control" id="min_amount" name="min_amount" value="{{ request('min_amount') }}" placeholder="0.00">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="max_amount" class="form-label">Max Amount (₹)</label>
                        <input type="number" step="0.01" class="form-control modern-form-control" id="max_amount" name="max_amount" value="{{ request('max_amount') }}" placeholder="100000.00">
                    </div>
                     <div class="col-md-1 mb-3">
                        <label for="utilization_status" class="form-label">Utilized %</label>
                        <select class="form-select modern-form-select" id="utilization_status" name="utilization_status">
                            <option value="">Any</option>
                            <option value="0-25" {{ request('utilization_status') == '0-25' ? 'selected' : '' }}>0-25%</option>
                            <option value="26-50" {{ request('utilization_status') == '26-50' ? 'selected' : '' }}>26-50%</option>
                            <option value="51-75" {{ request('utilization_status') == '51-75' ? 'selected' : '' }}>51-75%</option>
                            <option value="76-99" {{ request('utilization_status') == '76-99' ? 'selected' : '' }}>76-99%</option>
                            <option value="100" {{ request('utilization_status') == '100' ? 'selected' : '' }}>100%</option>
                        </select>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.releases.index') }}" class="modern-btn modern-btn-cancel">
                        <i class="bi bi-x-circle me-1"></i> Clear Filters
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="bi bi-funnel me-1"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card modern-card">
        <div class="card-body modern-card-body">
            <div class="table-responsive">
                <table id="releasesTable" class="table table-hover modern-table mb-0">
                    <thead>
                        <tr>
                            <th>Release ID</th>
                            <th>College Name</th>
                            <th>Release Amount</th>
                            <th>Release Date</th>
                            <th>Description</th>
                            <th>Utilization Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($releases as $release)
                            <tr>
                                <td>
                                    <span class="fw-bold text-primary">#{{ $release->release_id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-building me-2 text-muted"></i>
                                        <span class="fw-semibold">{{ $release->funding->college->college_name }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-currency-rupee me-1 text-success"></i>
                                        <span class="fw-bold text-success">{{ number_format($release->release_amt, 2) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-event me-2 text-muted"></i>
                                        <span>{{ $release->release_date->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="text-muted">{{ Str::limit($release->desc, 40) }}</span>
                                </td>
                                <td>
                                    @php
                                        $percentage = $release->funding->utilization_percentage;
                                        $badgeClass = $percentage >= 100 ? 'bg-success' : ($percentage >= 75 ? 'bg-info' : ($percentage >= 50 ? 'bg-warning' : 'bg-secondary'));
                                    @endphp
                                    <span class="badge modern-badge {{ $badgeClass }}">
                                        <i class="bi bi-percent me-1"></i>{{ number_format($percentage, 1) }}% Utilized
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.releases.show', $release->release_id) }}" 
                                           class="modern-btn modern-btn-info" title="View Details">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.releases.edit', $release->release_id) }}" 
                                           class="modern-btn modern-btn-warning" title="Edit Release">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.releases.destroy', $release->release_id) }}" 
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this release? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="modern-btn modern-btn-danger" title="Delete Release">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable with modern styling
        $('#releasesTable').DataTable({
            order: [[3, 'desc']], // Sort by release date by default
            pageLength: 10,
            responsive: true,
            dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rtip',
            language: {
                search: "Search releases:",
                lengthMenu: "Show _MENU_ releases per page",
                info: "Showing _START_ to _END_ of _TOTAL_ releases",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Add loading state to filter form
        $('form').on('submit', function() {
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<i class="bi bi-hourglass-split me-1"></i> Filtering...');
            submitBtn.prop('disabled', true);
            
            // Re-enable after 3 seconds in case of issues
            setTimeout(function() {
                submitBtn.html(originalText);
                submitBtn.prop('disabled', false);
            }, 3000);
        });

        // Enhanced tooltips for action buttons
        $('[title]').tooltip({
            placement: 'top',
            trigger: 'hover'
        });
    });
</script>
@endpush 