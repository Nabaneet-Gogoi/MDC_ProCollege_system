@extends('rusa.layouts.app')

@section('title', 'Fund Utilization')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Fund Utilization Monitoring</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-file-earmark-excel"></i> Export
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
        </div>
    </div>

    <!-- Utilization Summary -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-bar-chart-line-fill me-2"></i>Overall Fund Utilization Summary</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
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
                                        <td>{{ $type }}</td>
                                        <td>{{ $stats['count'] }}</td>
                                        <td>₹ {{ number_format($stats['approved'], 2) }} Cr</td>
                                        <td>₹ {{ number_format($stats['released'], 2) }} Cr</td>
                                        <td>₹ {{ number_format($stats['utilized'], 2) }} Cr</td>
                                        <td>
                                            @if ($stats['approved'] > 0)
                                                {{ number_format(($stats['released'] / $stats['approved']) * 100, 2) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                        <td>
                                            @if ($stats['approved'] > 0)
                                                {{ number_format(($stats['utilized'] / $stats['approved']) * 100, 2) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                
                                <tr class="table-primary fw-bold">
                                    <td>Total</td>
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

    <!-- College-wise Utilization -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-list-columns-reverse me-2"></i>College-wise Fund Utilization</h5>
                    <div>
                        <input type="text" id="searchTable" class="form-control form-control-sm" placeholder="Search colleges...">
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover" id="collegeTable">
                            <thead class="table-light">
                                <tr>
                                    <th onclick="sortTable(0)">College <i class="bi bi-arrow-down-up"></i></th>
                                    <th onclick="sortTable(1)">Type <i class="bi bi-arrow-down-up"></i></th>
                                    <th onclick="sortTable(2)">State <i class="bi bi-arrow-down-up"></i></th>
                                    <th onclick="sortTable(3)">District <i class="bi bi-arrow-down-up"></i></th>
                                    <th onclick="sortTable(4)">Approved (₹ Cr) <i class="bi bi-arrow-down-up"></i></th>
                                    <th onclick="sortTable(5)">Released (₹ Cr) <i class="bi bi-arrow-down-up"></i></th>
                                    <th onclick="sortTable(6)">Utilized (₹ Cr) <i class="bi bi-arrow-down-up"></i></th>
                                    <th onclick="sortTable(7)">Release % <i class="bi bi-arrow-down-up"></i></th>
                                    <th onclick="sortTable(8)">Utilization % <i class="bi bi-arrow-down-up"></i></th>
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
                                        <td>{{ $college->college_name }}</td>
                                        <td>{{ $college->type }}</td>
                                        <td>{{ $college->state }}</td>
                                        <td>{{ $college->district }}</td>
                                        <td>{{ number_format($approved, 2) }}</td>
                                        <td>{{ number_format($released, 2) }}</td>
                                        <td>{{ number_format($utilized, 2) }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                    <div class="progress-bar bg-primary" 
                                                         role="progressbar" style="width: {{ $releasePercent }}%"></div>
                                                </div>
                                                <span>{{ number_format($releasePercent, 2) }}%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                    <div class="progress-bar {{ $utilizationPercent >= 90 ? 'bg-success' : 'bg-info' }}" 
                                                         role="progressbar" style="width: {{ $utilizationPercent }}%"></div>
                                                </div>
                                                <span>{{ number_format($utilizationPercent, 2) }}%</span>
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
    // Table search functionality
    document.getElementById('searchTable').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const table = document.getElementById('collegeTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const rowText = rows[i].textContent.toLowerCase();
            rows[i].style.display = rowText.includes(searchTerm) ? '' : 'none';
        }
    });
    
    // Table sorting functionality
    function sortTable(columnIndex) {
        const table = document.getElementById('collegeTable');
        let switching = true;
        let shouldSwitch, rows, i, x, y, direction = 'asc';
        let switchCount = 0;
        
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
    }
</script>
@endsection 