@extends('rusa.layouts.app')

@section('title', 'Fund Utilization')

@section('styles')
<style>
    /* RUSA Fund Utilization Specific Styles */
    .page-header {
        background: var(--rusa-gradient);
        border-radius: var(--radius-lg);
        padding: var(--spacing-lg);
        margin-bottom: var(--spacing-xl);
        box-shadow: var(--rusa-shadow);
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
        backdrop-filter: blur(2px);
    }
    
    .page-header h1 {
        color: #fff;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        margin: 0;
        font-size: 1.5rem;
        font-weight: 700;
        position: relative;
        z-index: 1;
    }
    
    .btn-toolbar {
        position: relative;
        z-index: 1;
    }
    
    .btn-group .btn-sm {
        padding: var(--spacing-sm) var(--spacing-md);
        font-size: 0.8rem;
        font-weight: 600;
        border-radius: var(--radius-md);
        transition: all 0.3s ease;
    }
    
    .btn-outline-secondary {
        border: 2px solid rgba(255, 255, 255, 0.8);
        color: #fff;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(2px);
    }
    
    .btn-outline-secondary:hover {
        background: rgba(255, 255, 255, 0.2);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 255, 255, 0.3);
    }
    
    /* Enhanced Card Styles */
    .utilization-card {
        border: none;
        border-radius: var(--radius-lg);
        box-shadow: var(--card-shadow);
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        overflow: hidden;
        position: relative;
        margin-bottom: var(--spacing-xl);
    }
    
    .utilization-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--rusa-gradient);
    }
    
    .utilization-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--card-shadow-hover);
    }
    
    .card-header-rusa {
        background: linear-gradient(135deg, rgba(255, 224, 59, 0.1) 0%, rgba(253, 184, 19, 0.1) 100%);
        border-bottom: 1px solid rgba(255, 224, 59, 0.2);
        padding: var(--spacing-lg);
    }
    
    .card-header-rusa h5 {
        color: var(--rusa-accent);
        font-weight: 700;
        margin: 0;
        font-size: 1.1rem;
    }
    
    .card-header-rusa i {
        color: var(--rusa-tertiary);
        margin-right: var(--spacing-sm);
    }
    
    /* Enhanced Table Styles */
    .table-enhanced {
        margin: 0;
    }
    
    .table-enhanced thead th {
        background: var(--rusa-gradient-soft);
        color: #fff;
        border: none;
        padding: var(--spacing-md);
        font-weight: 600;
        font-size: 0.85rem;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    .table-enhanced tbody td {
        padding: var(--spacing-md);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        font-size: 0.85rem;
    }
    
    .table-enhanced tbody tr:hover {
        background-color: rgba(255, 224, 59, 0.08);
        transform: translateX(2px);
        transition: all 0.2s ease;
    }
    
    .table-primary {
        background: var(--rusa-gradient-soft) !important;
        color: #fff !important;
    }
    
    .table-primary td {
        border: none !important;
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
    }
    
    /* Search Input Enhancement */
    .search-input {
        border: 2px solid var(--rusa-primary);
        border-radius: var(--radius-md);
        padding: var(--spacing-sm) var(--spacing-md);
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(5px);
    }
    
    .search-input:focus {
        border-color: var(--rusa-tertiary);
        box-shadow: 0 0 0 0.2rem rgba(255, 224, 59, 0.25);
        background: #fff;
    }
    
    /* Progress Bar Enhancements */
    .progress-enhanced {
        height: 8px;
        border-radius: var(--radius-sm);
        background: rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: relative;
    }
    
    .progress-bar-rusa {
        background: var(--rusa-gradient);
        transition: width 1s ease-in-out;
        position: relative;
        overflow: hidden;
    }
    
    .progress-bar-rusa::after {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        bottom: 0;
        right: -100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 2s infinite;
    }
    
    .progress-bar-success {
        background: var(--success-gradient);
    }
    
    .progress-bar-info {
        background: var(--info-gradient);
    }
    
    /* Sortable Table Headers */
    .sortable-header {
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease;
    }
    
    .sortable-header:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-1px);
    }
    
    .sortable-header i {
        opacity: 0.6;
        transition: opacity 0.2s ease;
    }
    
    .sortable-header:hover i {
        opacity: 1;
    }
    
    /* Responsive Improvements */
    @media (max-width: 768px) {
        .page-header {
            padding: var(--spacing-md);
        }
        
        .page-header h1 {
            font-size: 1.25rem;
        }
        
        .btn-toolbar {
            margin-top: var(--spacing-md);
        }
        
        .card-header-rusa {
            padding: var(--spacing-md);
        }
        
        .table-enhanced {
            font-size: 0.75rem;
        }
        
        .table-enhanced thead th,
        .table-enhanced tbody td {
            padding: var(--spacing-sm);
        }
    }
</style>
@endsection

@section('content')
    <!-- Enhanced Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
            <h1><i class="bi bi-currency-rupee me-2"></i>Fund Utilization Monitoring</h1>
            <div class="btn-toolbar">
                <div class="btn-group me-2">
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-file-earmark-excel me-1"></i> Export
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-printer me-1"></i> Print
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Utilization Summary -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="utilization-card">
                <div class="card-header-rusa">
                    <h5><i class="bi bi-bar-chart-line-fill"></i>Overall Fund Utilization Summary</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-enhanced">
                            <thead>
                                <tr>
                                    <th>College Type</th>
                                    <th>Count</th>
                                    <th>Approved Funding</th>
                                    <th>Released Funding</th>
                                    <th>Utilized Funding</th>
                                    <th>Release %</th>
                                    <th>Utilization %</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $typeStats = [];
                                    $totalApproved = 0;
                                    $totalReleased = 0;
                                    $totalUtilized = 0;
                                    
                                    foreach ($colleges as $college) {
                                        $approved = 0;
                                        foreach ($college->fundings as $funding) {
                                            $approved += $funding->approved_amt;
                                        }
                                        
                                        $released = $college->released_amount ?? 0;
                                        $utilized = $college->utilized_amount ?? 0;
                                        
                                        $type = $college->type;
                                        
                                        if (!isset($typeStats[$type])) {
                                            $typeStats[$type] = [
                                                'count' => 0,
                                                'approved' => 0,
                                                'released' => 0,
                                                'utilized' => 0
                                            ];
                                        }
                                        
                                        $typeStats[$type]['count']++;
                                        $typeStats[$type]['approved'] += $approved;
                                        $typeStats[$type]['released'] += $released;
                                        $typeStats[$type]['utilized'] += $utilized;
                                        
                                        $totalApproved += $approved;
                                        $totalReleased += $released;
                                        $totalUtilized += $utilized;
                                    }
                                @endphp
                                
                                @foreach ($typeStats as $type => $stats)
                                    <tr>
                                        <td><strong>{{ $type }}</strong></td>
                                        <td><span class="badge bg-primary">{{ $stats['count'] }}</span></td>
                                        <td><strong>₹ {{ number_format($stats['approved'], 2) }} Cr</strong></td>
                                        <td>₹ {{ number_format($stats['released'], 2) }} Cr</td>
                                        <td>₹ {{ number_format($stats['utilized'], 2) }} Cr</td>
                                        <td>
                                            @if ($stats['approved'] > 0)
                                                <span class="badge bg-info">{{ number_format(($stats['released'] / $stats['approved']) * 100, 2) }}%</span>
                                            @else
                                                <span class="badge bg-secondary">0%</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($stats['approved'] > 0)
                                                @php $utilPercent = ($stats['utilized'] / $stats['approved']) * 100; @endphp
                                                <span class="badge {{ $utilPercent >= 75 ? 'bg-success' : ($utilPercent >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                                    {{ number_format($utilPercent, 2) }}%
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">0%</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                
                                <tr class="table-primary fw-bold">
                                    <td><i class="bi bi-calculator me-1"></i> Total</td>
                                    <td>{{ count($colleges) }}</td>
                                    <td>₹ {{ number_format($totalApproved, 2) }} Cr</td>
                                    <td>₹ {{ number_format($totalReleased, 2) }} Cr</td>
                                    <td>₹ {{ number_format($totalUtilized, 2) }} Cr</td>
                                    <td>
                                        @if ($totalApproved > 0)
                                            {{ number_format(($totalReleased / $totalApproved) * 100, 2) }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                    <td>
                                        @if ($totalApproved > 0)
                                            {{ number_format(($totalUtilized / $totalApproved) * 100, 2) }}%
                                        @else
                                            0%
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced College-wise Utilization -->
    <div class="row">
        <div class="col-lg-12">
            <div class="utilization-card">
                <div class="card-header-rusa d-flex justify-content-between align-items-center flex-wrap">
                    <h5><i class="bi bi-list-columns-reverse"></i>College-wise Fund Utilization</h5>
                    <div class="mt-2 mt-md-0">
                        <input type="text" id="searchTable" class="form-control search-input" placeholder="🔍 Search colleges..." style="min-width: 200px;">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-enhanced" id="collegeTable">
                            <thead>
                                <tr>
                                    <th class="sortable-header" onclick="sortTable(0)">College <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortable-header" onclick="sortTable(1)">Type <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortable-header" onclick="sortTable(2)">State <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortable-header" onclick="sortTable(3)">District <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortable-header" onclick="sortTable(4)">Approved (₹ Cr) <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortable-header" onclick="sortTable(5)">Released (₹ Cr) <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortable-header" onclick="sortTable(6)">Utilized (₹ Cr) <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortable-header" onclick="sortTable(7)">Release % <i class="bi bi-arrow-down-up"></i></th>
                                    <th class="sortable-header" onclick="sortTable(8)">Utilization % <i class="bi bi-arrow-down-up"></i></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($colleges as $college)
                                    @php
                                        $approved = 0;
                                        foreach ($college->fundings as $funding) {
                                            $approved += $funding->approved_amt;
                                        }
                                        
                                        $released = $college->released_amount ?? 0;
                                        $utilized = $college->utilized_amount ?? 0;
                                        
                                        $releasePercent = $approved > 0 ? ($released / $approved) * 100 : 0;
                                        $utilizationPercent = $approved > 0 ? ($utilized / $approved) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $college->college_name }}</strong></td>
                                        <td><span class="badge bg-secondary">{{ $college->type }}</span></td>
                                        <td>{{ $college->state }}</td>
                                        <td>{{ $college->district }}</td>
                                        <td><strong>{{ number_format($approved, 2) }}</strong></td>
                                        <td>{{ number_format($released, 2) }}</td>
                                        <td>{{ number_format($utilized, 2) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-enhanced flex-grow-1 me-2">
                                                    <div class="progress-bar progress-bar-rusa" 
                                                         role="progressbar" style="width: {{ $releasePercent }}%"></div>
                                                </div>
                                                <small class="fw-bold">{{ number_format($releasePercent, 1) }}%</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress progress-enhanced flex-grow-1 me-2">
                                                    <div class="progress-bar {{ $utilizationPercent >= 75 ? 'progress-bar-success' : ($utilizationPercent >= 50 ? 'progress-bar-rusa' : 'progress-bar-info') }}" 
                                                         role="progressbar" style="width: {{ $utilizationPercent }}%"></div>
                                                </div>
                                                <small class="fw-bold">{{ number_format($utilizationPercent, 1) }}%</small>
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
    </div>
@endsection

@section('scripts')
<script>
    // Enhanced table search functionality
    document.getElementById('searchTable').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const table = document.getElementById('collegeTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const rowText = rows[i].textContent.toLowerCase();
            if (rowText.includes(searchTerm)) {
                rows[i].style.display = '';
                rows[i].style.animation = 'fadeIn 0.3s ease-in';
            } else {
                rows[i].style.display = 'none';
            }
        }
    });
    
    // Enhanced table sorting functionality
    function sortTable(columnIndex) {
        const table = document.getElementById('collegeTable');
        let switching = true;
        let shouldSwitch, rows, i, x, y, direction = 'asc';
        let switchCount = 0;
        
        // Update header indicators
        const headers = table.querySelectorAll('th.sortable-header');
        headers.forEach(header => {
            const icon = header.querySelector('i');
            icon.className = 'bi bi-arrow-down-up';
        });
        
        const currentHeader = headers[columnIndex];
        
        while (switching) {
            switching = false;
            rows = table.rows;
            
            for (i = 1; i < (rows.length - 1); i++) {
                shouldSwitch = false;
                x = rows[i].getElementsByTagName('td')[columnIndex];
                y = rows[i + 1].getElementsByTagName('td')[columnIndex];
                
                // Check if columns contain percentage or numerical values
                if ([4, 5, 6, 7, 8].includes(columnIndex)) {
                    let xValue, yValue;
                    
                    if (columnIndex == 7 || columnIndex == 8) {
                        // For percentage columns, extract the percentage value
                        xValue = parseFloat(x.textContent.replace(/[^0-9.]/g, ''));
                        yValue = parseFloat(y.textContent.replace(/[^0-9.]/g, ''));
                    } else {
                        // For amount columns
                        xValue = parseFloat(x.textContent.replace(/[^0-9.]/g, ''));
                        yValue = parseFloat(y.textContent.replace(/[^0-9.]/g, ''));
                    }
                    
                    if (direction === 'asc') {
                        if (xValue > yValue) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (xValue < yValue) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                } else {
                    // For text columns
                    if (direction === 'asc') {
                        if (x.textContent.toLowerCase() > y.textContent.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    } else {
                        if (x.textContent.toLowerCase() < y.textContent.toLowerCase()) {
                            shouldSwitch = true;
                            break;
                        }
                    }
                }
            }
            
            if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                switchCount++;
            } else {
                if (switchCount === 0 && direction === 'asc') {
                    direction = 'desc';
                    switching = true;
                }
            }
        }
        
        // Update sort indicator
        const sortIcon = currentHeader.querySelector('i');
        sortIcon.className = direction === 'asc' ? 'bi bi-arrow-up' : 'bi bi-arrow-down';
    }
    
    // Add fade-in animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection 