@extends('rusa.layouts.app')

@section('title', 'Colleges')

@section('content')
<style>
:root {
    --rusa-primary: #FFE03B;
    --rusa-secondary: #FDB813;
    --rusa-tertiary: #F7941D;
    --rusa-accent: #D1322D;
    --rusa-gradient: linear-gradient(135deg, #FFE03B 0%, #FDB813 30%, #F7941D 70%, #D1322D 100%);
    --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
    --warning-gradient: linear-gradient(135deg, #FFE03B 0%, #FDB813 50%, #F7941D 100%);
    --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
    --danger-gradient: linear-gradient(135deg, #D1322D 0%, #ef4444 50%, #f87171 100%);
    --secondary-gradient: linear-gradient(135deg, #F7941D 0%, #FDB813 50%, #FFE03B 100%);
}

.rusa-header {
    background: var(--rusa-gradient);
    color: white;
    padding: 16px 20px;
    border-radius: 12px;
    margin-bottom: 16px;
    box-shadow: 0 8px 25px rgba(253, 184, 19, 0.3);
}

.rusa-header h1 {
    font-size: 1.5rem;
    margin: 0;
    font-weight: 600;
}

.btn-rusa-primary {
    background: var(--rusa-gradient);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    font-weight: 500;
    transition: all 0.3s ease;
    backdrop-filter: blur(2px);
}

.btn-rusa-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(253, 184, 19, 0.4);
    color: white;
}

.btn-rusa-secondary {
    background: var(--secondary-gradient);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-rusa-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(247, 148, 29, 0.4);
    color: white;
}

.btn-rusa-warning {
    background: var(--warning-gradient);
    border: 2px solid rgba(255, 255, 255, 0.3);
    color: white;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-rusa-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 224, 59, 0.4);
    color: white;
}

.rusa-card {
    background: linear-gradient(145deg, #ffffff 0%, #f8f9fa 100%);
    border: none;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
}

.rusa-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
}

.rusa-card-header {
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-bottom: 3px solid var(--rusa-tertiary);
    padding: 12px 20px;
    font-weight: 600;
    color: #333;
}

.rusa-filter-card {
    background: linear-gradient(135deg, #fff9e6 0%, #fff3d3 100%);
    border: 2px solid var(--rusa-secondary);
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(253, 184, 19, 0.15);
    transition: all 0.3s ease;
}

.rusa-filter-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(253, 184, 19, 0.25);
}

.form-select-rusa {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.form-select-rusa:focus {
    border-color: var(--rusa-secondary);
    box-shadow: 0 0 0 0.2rem rgba(253, 184, 19, 0.25);
}

.form-control-rusa {
    border: 2px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.form-control-rusa:focus {
    border-color: var(--rusa-secondary);
    box-shadow: 0 0 0 0.2rem rgba(253, 184, 19, 0.25);
}

.table-rusa {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
}

.table-rusa thead th {
    background: var(--warning-gradient);
    color: white;
    border: none;
    font-weight: 600;
    font-size: 0.85rem;
    padding: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.table-rusa tbody tr {
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.table-rusa tbody tr:hover {
    background: linear-gradient(135deg, #fff9e6 0%, #fff3d3 100%);
    transform: translateX(2px);
}

.table-rusa tbody td {
    padding: 12px;
    vertical-align: middle;
}

.colleges-count {
    background: var(--info-gradient);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-left: 8px;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #6c757d;
}

.empty-state i {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.5;
    background: var(--rusa-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.empty-state .lead {
    font-size: 1.1rem;
    margin: 0;
}

.search-input-group {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
}

.search-input-group input {
    border: none;
    padding: 12px 16px;
    font-size: 0.9rem;
}

.search-input-group input:focus {
    box-shadow: none;
    border-color: transparent;
}

.pagination-rusa .page-link {
    color: var(--rusa-tertiary);
    border: 1px solid #dee2e6;
    padding: 8px 12px;
    margin: 0 2px;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.pagination-rusa .page-link:hover {
    background: var(--warning-gradient);
    color: white;
    border-color: transparent;
    transform: translateY(-1px);
}

.pagination-rusa .page-item.active .page-link {
    background: var(--rusa-gradient);
    border-color: transparent;
    color: white;
}

.compact-section {
    margin-bottom: 20px;
}

@media (max-width: 768px) {
    .rusa-header {
        padding: 12px 16px;
    }
    
    .rusa-header h1 {
        font-size: 1.25rem;
    }
    
    .btn-toolbar {
        flex-direction: column;
        gap: 8px;
    }
    
    .table-rusa {
        font-size: 0.8rem;
    }
    
    .table-rusa th,
    .table-rusa td {
        padding: 8px;
    }
}

@media (max-width: 576px) {
    .rusa-filter-card .row {
        margin: 0;
    }
    
    .rusa-filter-card .col-md-3,
    .rusa-filter-card .col-md-12 {
        padding: 4px;
        margin-bottom: 8px;
    }
}
</style>

    <div class="rusa-header d-flex justify-content-between align-items-center">
        <h1><i class="bi bi-buildings me-2"></i>Colleges Monitoring</h1>
        <div class="btn-toolbar">
            <button type="button" class="btn btn-rusa-secondary btn-sm me-2">
                <i class="bi bi-file-earmark-excel"></i> Export
            </button>
            <button type="button" class="btn btn-rusa-warning btn-sm">
                <i class="bi bi-printer"></i> Print
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="compact-section">
        <div class="rusa-filter-card p-3">
            <div class="d-flex align-items-center mb-3">
                <h6 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Colleges</h6>
            </div>
            <form action="{{ route('rusa.colleges') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="type" class="form-label fw-semibold">Type</label>
                    <select class="form-select form-select-rusa" id="type" name="type">
                        <option value="">All Types</option>
                        @foreach($types as $type)
                            <option value="{{ $type }}" {{ request('type') == $type ? 'selected' : '' }}>
                                {{ $type }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="phase" class="form-label fw-semibold">Phase</label>
                    <select class="form-select form-select-rusa" id="phase" name="phase">
                        <option value="">All Phases</option>
                        @foreach($phases as $phase)
                            <option value="{{ $phase }}" {{ request('phase') == $phase ? 'selected' : '' }}>
                                {{ $phase }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="state" class="form-label fw-semibold">State</label>
                    <select class="form-select form-select-rusa" id="state" name="state">
                        <option value="">All States</option>
                        @foreach($states as $state)
                            <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>
                                {{ $state }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="district" class="form-label fw-semibold">District</label>
                    <select class="form-select form-select-rusa" id="district" name="district">
                        <option value="">All Districts</option>
                        @foreach($districts as $district)
                            <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>
                                {{ $district }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12">
                    <label for="search" class="form-label fw-semibold">Search</label>
                    <div class="search-input-group input-group">
                        <input type="text" class="form-control form-control-rusa" id="search" name="search" 
                            placeholder="Search colleges by name..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-rusa-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('rusa.colleges') }}" class="btn btn-rusa-secondary">
                            <i class="bi bi-x-circle"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Colleges List -->
    <div class="compact-section">
        <div class="rusa-card">
            <div class="rusa-card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-building me-2"></i>Colleges</span>
                <span class="colleges-count">{{ $colleges->total() }}</span>
            </div>
            <div class="card-body p-0">
                @if(isset($colleges) && count($colleges) > 0)
                    <div class="table-responsive">
                        <table class="table table-rusa mb-0" id="collegeTable">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-building me-1"></i>College Name</th>
                                    <th><i class="bi bi-tag me-1"></i>Type</th>
                                    <th><i class="bi bi-layers me-1"></i>Phase</th>
                                    <th><i class="bi bi-geo-alt me-1"></i>State</th>
                                    <th><i class="bi bi-pin-map me-1"></i>District</th>
                                    <th><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($colleges as $college)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $college->college_name }}</div>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill" style="background: var(--info-gradient); color: white;">
                                                {{ $college->type }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge rounded-pill" style="background: var(--secondary-gradient); color: white;">
                                                {{ $college->phase }}
                                            </span>
                                        </td>
                                        <td>{{ $college->state }}</td>
                                        <td>{{ $college->district }}</td>
                                        <td>
                                            <a href="{{ route('rusa.colleges.details', $college->college_id) }}" 
                                               class="btn btn-rusa-primary btn-sm">
                                                <i class="bi bi-eye"></i> View Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($colleges->hasPages())
                        <div class="d-flex justify-content-center p-3">
                            <nav aria-label="Colleges pagination">
                                <div class="pagination-rusa">
                                    {{ $colleges->links() }}
                                </div>
                            </nav>
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="bi bi-building"></i>
                        <p class="lead">No colleges found</p>
                        <p class="text-muted mb-0">Try adjusting your search criteria or filters</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Enhanced interactions and animations
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth hover effects to cards
        const cards = document.querySelectorAll('.rusa-card, .rusa-filter-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                if (this.classList.contains('rusa-filter-card')) {
                    this.style.transform = 'translateY(-2px)';
                } else {
                    this.style.transform = 'translateY(-4px)';
                }
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'none';
            });
        });
        
        // Enhanced table row interactions
        const tableRows = document.querySelectorAll('.table-rusa tbody tr');
        tableRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(2px)';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'none';
            });
        });
        
        // Form field focus animations
        const formInputs = document.querySelectorAll('.form-select-rusa, .form-control-rusa');
        formInputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'none';
            });
        });
        
        // Button hover effects
        const buttons = document.querySelectorAll('.btn-rusa-primary, .btn-rusa-secondary, .btn-rusa-warning');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'none';
            });
        });
        
        // Auto-submit search on Enter key
        const searchInput = document.getElementById('search');
        if (searchInput) {
            searchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    this.closest('form').submit();
                }
            });
        }
        
        // Smooth scroll to top when pagination is clicked
        const paginationLinks = document.querySelectorAll('.pagination a');
        paginationLinks.forEach(link => {
            link.addEventListener('click', function() {
                setTimeout(() => {
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }, 100);
            });
        });
    });
</script>
@endsection 