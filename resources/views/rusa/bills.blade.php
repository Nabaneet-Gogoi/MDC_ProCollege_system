@extends('rusa.layouts.app')

@section('title', 'Bills')

@section('content')
<style>
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

.btn-rusa-outline {
    background: transparent;
    border: 2px solid var(--rusa-tertiary);
    color: var(--rusa-tertiary);
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-rusa-outline:hover {
    background: var(--warning-gradient);
    border-color: transparent;
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 15px rgba(247, 148, 29, 0.3);
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

.bills-count {
    background: var(--info-gradient);
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-left: 8px;
}

.rusa-badge {
    font-size: 0.75rem;
    padding: 6px 12px;
    border-radius: 20px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-pending {
    background: var(--warning-gradient);
    color: white;
}

.badge-approved {
    background: var(--success-gradient);
    color: white;
}

.badge-rejected {
    background: var(--danger-gradient);
    color: white;
}

.badge-paid {
    background: var(--info-gradient);
    color: white;
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

.bill-amount {
    font-weight: 600;
    color: var(--rusa-accent);
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
        <h1><i class="bi bi-receipt-cutoff me-2"></i>Bills Monitoring</h1>
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
                <h6 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Bills</h6>
            </div>
            <form action="{{ route('rusa.bills') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="college" class="form-label fw-semibold">College</label>
                    <select class="form-select form-select-rusa" id="college" name="college_id">
                        <option value="">All Colleges</option>
                        @foreach(App\Models\College::orderBy('college_name')->get() as $college)
                            <option value="{{ $college->college_id }}" {{ request('college_id') == $college->college_id ? 'selected' : '' }}>
                                {{ $college->college_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="status" class="form-label fw-semibold">Status</label>
                    <select class="form-select form-select-rusa" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="from_date" class="form-label fw-semibold">From Date</label>
                    <input type="date" class="form-control form-control-rusa" id="from_date" name="from_date" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="to_date" class="form-label fw-semibold">To Date</label>
                    <input type="date" class="form-control form-control-rusa" id="to_date" name="to_date" value="{{ request('to_date') }}">
                </div>
                <div class="col-md-12">
                    <label for="search" class="form-label fw-semibold">Search</label>
                    <div class="search-input-group input-group">
                        <input type="text" class="form-control form-control-rusa" id="search" name="search" 
                            placeholder="Search bills by number, college..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-rusa-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                        <a href="{{ route('rusa.bills') }}" class="btn btn-rusa-secondary">
                            <i class="bi bi-x-circle"></i> Clear
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bills List -->
    <div class="compact-section">
        <div class="rusa-card">
            <div class="rusa-card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-receipt me-2"></i>Bills</span>
                <span class="bills-count">{{ $bills->total() }}</span>
            </div>
            <div class="card-body p-0">
                @if(isset($bills) && count($bills) > 0)
                    <div class="table-responsive">
                        <table class="table table-rusa mb-0">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-hash me-1"></i>Bill No</th>
                                    <th><i class="bi bi-building me-1"></i>College</th>
                                    <th><i class="bi bi-currency-rupee me-1"></i>Amount (₹ Cr)</th>
                                    <th><i class="bi bi-calendar-date me-1"></i>Bill Date</th>
                                    <th><i class="bi bi-flag me-1"></i>Status</th>
                                    <th><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bills as $bill)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold">{{ $bill->bill_no }}</div>
                                        </td>
                                        <td>{{ $bill->college->college_name }}</td>
                                        <td>
                                            <span class="bill-amount">{{ number_format($bill->bill_amt, 2) }}</span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</td>
                                        <td>
                                            @if($bill->bill_status == 'pending')
                                                <span class="rusa-badge badge-pending">Pending</span>
                                            @elseif($bill->bill_status == 'approved')
                                                <span class="rusa-badge badge-approved">Approved</span>
                                            @elseif($bill->bill_status == 'rejected')
                                                <span class="rusa-badge badge-rejected">Rejected</span>
                                            @elseif($bill->bill_status == 'paid')
                                                <span class="rusa-badge badge-paid">Paid</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('bills.print', $bill->bill_id) }}" class="btn btn-rusa-outline btn-sm" target="_blank">
                                                <i class="bi bi-printer"></i> Print
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    @if($bills->hasPages())
                        <div class="d-flex justify-content-center p-3">
                            <nav aria-label="Bills pagination">
                                <div class="pagination-rusa">
                                    {{ $bills->links() }}
                                </div>
                            </nav>
                        </div>
                    @endif
                @else
                    <div class="empty-state">
                        <i class="bi bi-receipt"></i>
                        <p class="lead">No bills found</p>
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
        const buttons = document.querySelectorAll('.btn-rusa-primary, .btn-rusa-secondary, .btn-rusa-warning, .btn-rusa-outline');
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
        
        // Animate bill amounts on load
        const billAmounts = document.querySelectorAll('.bill-amount');
        billAmounts.forEach((amount, index) => {
            amount.style.opacity = '0';
            amount.style.transform = 'translateY(10px)';
            setTimeout(() => {
                amount.style.transition = 'all 0.5s ease';
                amount.style.opacity = '1';
                amount.style.transform = 'none';
            }, index * 100);
        });
    });
</script>
@endsection