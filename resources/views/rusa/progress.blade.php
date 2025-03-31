@extends('rusa.layouts.app')

@section('title', 'Progress Reports')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Physical Progress Monitoring</h1>
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

    <!-- Progress Status Summary -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up-arrow me-2"></i>Progress Status Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-warning text-dark mb-4">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs text-uppercase mb-1">Not Started</div>
                                            <div class="h3 mb-0">{{ $progressStats['not_started'] ?? 0 }}</div>
                                        </div>
                                        <div class="fs-1 opacity-50">
                                            <i class="bi bi-hourglass-top"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs text-uppercase mb-1">In Progress</div>
                                            <div class="h3 mb-0">{{ $progressStats['in_progress'] ?? 0 }}</div>
                                        </div>
                                        <div class="fs-1 opacity-50">
                                            <i class="bi bi-gear-wide-connected"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs text-uppercase mb-1">Completed</div>
                                            <div class="h3 mb-0">{{ $progressStats['completed'] ?? 0 }}</div>
                                        </div>
                                        <div class="fs-1 opacity-50">
                                            <i class="bi bi-check-circle"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white mb-4">
                                <div class="card-body py-3">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="text-xs text-uppercase mb-1">Total Reports</div>
                                            <div class="h3 mb-0">{{ ($progressStats['not_started'] ?? 0) + ($progressStats['in_progress'] ?? 0) + ($progressStats['completed'] ?? 0) }}</div>
                                        </div>
                                        <div class="fs-1 opacity-50">
                                            <i class="bi bi-clipboard-data"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Reports List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-list-check me-2"></i>Progress Reports</h5>
                    <div class="d-flex">
                        <div class="input-group">
                            <select class="form-select form-select-sm me-2" id="statusFilter">
                                <option value="all">All Status</option>
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        <input type="text" id="searchTable" class="form-control form-control-sm" placeholder="Search...">
                    </div>
                </div>
                <div class="card-body">
                    @if(isset($progressReports) && count($progressReports) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="progressTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>College</th>
                                        <th>Category</th>
                                        <th>Report Date</th>
                                        <th>Completion %</th>
                                        <th>Status</th>
                                        <th>Verified By</th>
                                        <th>Verification Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($progressReports as $report)
                                        <tr class="progress-row" data-status="{{ $report->progress_status }}">
                                            <td>{{ $report->college->college_name }}</td>
                                            <td>{{ $report->workCategory->category_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($report->report_date)->format('d M Y') }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress flex-grow-1 me-2" style="height: 6px;">
                                                        <div class="progress-bar 
                                                            @if($report->completion_percent >= 90) bg-success 
                                                            @elseif($report->completion_percent >= 50) bg-info 
                                                            @elseif($report->completion_percent >= 20) bg-primary 
                                                            @else bg-warning @endif" 
                                                             role="progressbar" style="width: {{ $report->completion_percent }}%"></div>
                                                    </div>
                                                    <span>{{ $report->completion_percent }}%</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($report->progress_status == 'not_started')
                                                    <span class="badge bg-warning text-dark">Not Started</span>
                                                @elseif($report->progress_status == 'in_progress')
                                                    <span class="badge bg-primary">In Progress</span>
                                                @elseif($report->progress_status == 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @endif
                                            </td>
                                            <td>{{ $report->verified_by ?? 'Not Verified' }}</td>
                                            <td>
                                                @if($report->verification_date)
                                                    {{ \Carbon\Carbon::parse($report->verification_date)->format('d M Y') }}
                                                @else
                                                    Not Verified
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $progressReports->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-clipboard-x display-4 text-muted"></i>
                            <p class="lead mt-3">No progress reports available</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Table search functionality
    document.getElementById('searchTable').addEventListener('keyup', function() {
        filterTable();
    });
    
    // Status filter functionality
    document.getElementById('statusFilter').addEventListener('change', function() {
        filterTable();
    });
    
    function filterTable() {
        const searchTerm = document.getElementById('searchTable').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const rows = document.getElementsByClassName('progress-row');
        
        for (let i = 0; i < rows.length; i++) {
            const rowText = rows[i].textContent.toLowerCase();
            const rowStatus = rows[i].getAttribute('data-status');
            
            let showRow = rowText.includes(searchTerm);
            
            if (statusFilter !== 'all') {
                showRow = showRow && rowStatus === statusFilter;
            }
            
            rows[i].style.display = showRow ? '' : 'none';
        }
    }
</script>
@endsection 