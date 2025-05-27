@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="dashboard-header d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-2 mb-3">
        <div class="dashboard-title-section">
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">Welcome back! Here's what's happening with your system today.</p>
        </div>
        <div class="dashboard-toolbar">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-modern btn-modern-primary">
                    <i class="bi bi-download me-1"></i>Export
                </button>
                <button type="button" class="btn btn-modern btn-modern-secondary">
                    <i class="bi bi-printer me-1"></i>Print
                </button>
            </div>
            <button type="button" class="btn btn-modern btn-modern-outline dropdown-toggle d-flex align-items-center gap-2">
                <i class="bi bi-calendar3"></i>
                <span>This week</span>
                <i class="bi bi-chevron-down"></i>
            </button>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-3">
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-card-primary mb-2">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $adminCount ?? 0 }}</div>
                        <div class="stat-label">Admins</div>
                    </div>
                    <div class="stat-trend">
                        <i class="bi bi-arrow-up"></i>
                        <span>+5%</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-card-success mb-2">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="bi bi-building-fill"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $collegeCount ?? 0 }}</div>
                        <div class="stat-label">Colleges</div>
                    </div>
                    <div class="stat-trend">
                        <i class="bi bi-arrow-up"></i>
                        <span>+2%</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-card-danger mb-2">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $userCount ?? 0 }}</div>
                        <div class="stat-label">Users</div>
                    </div>
                    <div class="stat-trend">
                        <i class="bi bi-arrow-up"></i>
                        <span>+12%</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-card-warning mb-2">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $billCount ?? 0 }}</div>
                        <div class="stat-label">Bills</div>
                        <div class="stat-badges">
                            <span class="stat-badge stat-badge-pending">{{ $pendingBillCount ?? 0 }} Pending</span>
                            <span class="stat-badge stat-badge-approved">{{ $approvedBillCount ?? 0 }} Approved</span>
                        </div>
                    </div>
                    <div class="stat-trend">
                        @if(($pendingBillCount ?? 0) > 0)
                            <i class="bi bi-exclamation-triangle text-warning"></i>
                        @else
                            <i class="bi bi-check-circle text-success"></i>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-card-info mb-2">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="bi bi-file-text"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $auditLogCount ?? 0 }}</div>
                        <div class="stat-label">Audit Logs</div>
                        <div class="stat-badges">
                            <span class="stat-badge stat-badge-info">Today: {{ $todayLogCount ?? 0 }}</span>
                        </div>
                    </div>
                    <div class="stat-trend">
                        <i class="bi bi-shield-check"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 col-sm-6">
            <div class="stat-card stat-card-secondary mb-2">
                <div class="stat-card-body">
                    <div class="stat-icon">
                        <i class="bi bi-wifi"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">{{ $activeSessionCount ?? 0 }}</div>
                        <div class="stat-label">Active Sessions</div>
                        <div class="stat-badges">
                            <span class="stat-badge stat-badge-online">
                                <span class="pulse-dot"></span>
                                Online Now
                            </span>
                        </div>
                    </div>
                    <div class="stat-trend">
                        <i class="bi bi-person-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Charts and Quick Actions Row -->
    <div class="row mb-3">
        <div class="col-lg-4 mb-2">
            <div class="modern-card modern-card-actions h-100">
                <div class="modern-card-header">
                    <div class="modern-card-header-icon">
                        <i class="bi bi-lightning-charge"></i>
                    </div>
                    <h6 class="modern-card-title">Quick Actions</h6>
                    <div class="modern-card-header-decoration"></div>
                </div>
                <div class="modern-card-body">
                    <div class="modern-action-list">
                        <a href="{{ route('admin.bills.index') }}?status=pending" class="modern-action-item">
                            <div class="modern-action-icon modern-action-icon-warning">
                                <i class="bi bi-receipt"></i>
                            </div>
                            <div class="modern-action-content">
                                <div class="modern-action-title">Pending Bills</div>
                                <div class="modern-action-subtitle">Review and approve</div>
                            </div>
                            <div class="modern-action-badge modern-badge-warning">{{ $pendingBillCount ?? 0 }}</div>
                        </a>
                        <a href="{{ route('admin.colleges.index') }}" class="modern-action-item">
                            <div class="modern-action-icon modern-action-icon-success">
                                <i class="bi bi-building"></i>
                            </div>
                            <div class="modern-action-content">
                                <div class="modern-action-title">Manage Colleges</div>
                                <div class="modern-action-subtitle">View and manage</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="modern-action-item">
                            <div class="modern-action-icon modern-action-icon-info">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="modern-action-content">
                                <div class="modern-action-title">User Management</div>
                                <div class="modern-action-subtitle">Manage user accounts</div>
                            </div>
                        </a>
                        @if(auth('admin')->user() && auth('admin')->user()->role === 'superadmin')
                        <a href="{{ route('admin.audit-logs.index') }}" class="modern-action-item">
                            <div class="modern-action-icon modern-action-icon-secondary">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="modern-action-content">
                                <div class="modern-action-title">Audit Logs</div>
                                <div class="modern-action-subtitle">View system logs</div>
                            </div>
                        </a>
                        @endif
                        <a href="{{ route('admin.fundings.index') }}" class="modern-action-item">
                            <div class="modern-action-icon modern-action-icon-primary">
                                <i class="bi bi-cash-stack"></i>
                            </div>
                            <div class="modern-action-content">
                                <div class="modern-action-title">Funding Management</div>
                                <div class="modern-action-subtitle">Manage fund allocations</div>
                            </div>
                        </a>
                        <a href="{{ route('admin.releases.index') }}" class="modern-action-item">
                            <div class="modern-action-icon modern-action-icon-info">
                                <i class="bi bi-arrow-right-circle"></i>
                            </div>
                            <div class="modern-action-content">
                                <div class="modern-action-title">Fund Releases</div>
                                <div class="modern-action-subtitle">Manage fund releases</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-5 mb-2">
            <div class="modern-card modern-card-chart h-100 d-flex flex-column">
                <div class="modern-card-header">
                    <div class="modern-card-header-icon">
                        <i class="bi bi-graph-up"></i>
                    </div>
                    <h6 class="modern-card-title">Fund Utilization Trends</h6>
                    <div class="modern-card-header-decoration"></div>
                </div>
                <div class="modern-card-body flex-grow-1 d-flex flex-column">
                    <div class="chart-container flex-grow-1 d-flex align-items-center justify-content-center">
                        <canvas id="utilizationChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 mb-2">
            <div class="modern-card modern-card-chart h-100 d-flex flex-column">
                <div class="modern-card-header">
                    <div class="modern-card-header-icon">
                        <i class="bi bi-pie-chart"></i>
                    </div>
                    <h6 class="modern-card-title">Funding Distribution</h6>
                    <div class="modern-card-header-decoration"></div>
                </div>
                <div class="modern-card-body flex-grow-1 d-flex flex-column">
                    <div class="chart-container flex-grow-1 d-flex align-items-center justify-content-center">
                        <canvas id="fundingTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- College-wise Fund Utilization -->
    <div class="row">
        <div class="col-12">
            <div class="modern-card modern-card-table">
                <div class="modern-card-header">
                    <div class="modern-card-header-icon">
                        <i class="bi bi-list-columns"></i>
                    </div>
                    <h6 class="modern-card-title">College-wise Fund Utilization</h6>
                    <div class="modern-card-header-decoration"></div>
                    <div class="modern-card-header-actions">
                        <a href="{{ route('admin.colleges.index') }}" class="btn btn-modern btn-modern-outline-sm">
                            <i class="bi bi-eye me-1"></i>View All
                        </a>
                    </div>
                </div>
                <div class="modern-card-body">
                    @if(isset($collegeUtilization) && count($collegeUtilization) > 0)
                        <div class="modern-table-container">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>College</th>
                                        <th>Type</th>
                                        <th>Approved</th>
                                        <th>Released</th>
                                        <th>Utilized</th>
                                        <th>Release %</th>
                                        <th>Utilization %</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($collegeUtilization->take(5) as $college)
                                        <tr class="modern-table-row">
                                            <td class="modern-table-cell-primary">{{ Str::limit($college->college_name, 25) }}</td>
                                            <td>
                                                <span class="modern-badge modern-badge-{{ $college->type == 'professional' ? 'primary' : 'success' }}">
                                                    {{ ucfirst($college->type) }}
                                                </span>
                                            </td>
                                            <td class="modern-table-amount">₹{{ number_format($college->total_approved, 1) }}Cr</td>
                                            <td class="modern-table-amount">₹{{ number_format($college->total_released, 1) }}Cr</td>
                                            <td class="modern-table-amount">₹{{ number_format($college->total_utilized, 1) }}Cr</td>
                                            <td>
                                                <div class="modern-progress-container">
                                                    <div class="modern-progress">
                                                        <div class="modern-progress-bar modern-progress-primary" 
                                                             style="width: {{ $college->release_percent }}%"></div>
                                                    </div>
                                                    <span class="modern-progress-text">{{ $college->release_percent }}%</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="modern-progress-container">
                                                    <div class="modern-progress">
                                                        <div class="modern-progress-bar {{ $college->utilization_percent >= 90 ? 'modern-progress-success' : 'modern-progress-info' }}" 
                                                             style="width: {{ $college->utilization_percent }}%"></div>
                                                    </div>
                                                    <span class="modern-progress-text">{{ $college->utilization_percent }}%</span>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if(isset($collegeUtilization) && count($collegeUtilization) > 5)
                                <div class="modern-table-footer">
                                    <small class="text-muted">Showing top 5 colleges. <a href="{{ route('admin.colleges.index') }}" class="modern-link">View all {{ count($collegeUtilization) }} colleges</a></small>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="modern-empty-state">
                            <div class="modern-empty-icon">
                                <i class="bi bi-building"></i>
                            </div>
                            <h6 class="modern-empty-title">No Data Available</h6>
                            <p class="modern-empty-text">No college utilization data available at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
<style>
/* Dashboard Header Styling */
.dashboard-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 18px 20px;
    margin-bottom: 0;
    color: white;
    box-shadow: 0 6px 24px rgba(102, 126, 234, 0.12);
    border: 1px solid rgba(255, 255, 255, 0.1);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 20px 20px;
    opacity: 0.5;
}

.dashboard-title {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dashboard-subtitle {
    font-size: 0.9rem;
    margin: 4px 0 0 0;
    opacity: 0.9;
    font-weight: 400;
}

.dashboard-toolbar {
    display: flex;
    gap: 12px;
    align-items: center;
}

/* Modern Button Styles */
.btn-modern {
    padding: 10px 20px;
    border-radius: 12px;
    font-weight: 600;
    font-size: 14px;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.btn-modern-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.btn-modern-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
    color: white;
}

.btn-modern-secondary {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: white;
}

.btn-modern-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(240, 147, 251, 0.3);
    color: white;
}

.btn-modern-outline {
    background: rgba(255, 255, 255, 0.1);
    color: white;
    border: 1px solid rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
}

.btn-modern-outline:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
    color: white;
}

.btn-modern-outline-sm {
    padding: 8px 16px;
    font-size: 13px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.btn-modern-outline-sm:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
    color: white;
}

/* Stats Cards - Enhanced Existing Styles */
.stat-card {
    background: #fff;
    border-radius: 16px;
    border: none;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.stat-card-body {
    padding: 12px 14px;
    position: relative;
    display: flex;
    align-items: center;
    gap: 12px;
}

.stat-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.stat-card-primary .stat-icon {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.stat-card-success .stat-icon {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.stat-card-danger .stat-icon {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    color: white;
}

.stat-card-warning .stat-icon {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    color: #8B4513;
}

.stat-card-info .stat-icon {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #2C3E50;
}

.stat-card-secondary .stat-icon {
    background: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%);
    color: #6C757D;
}

.stat-content {
    flex: 1;
    min-width: 0;
}

.stat-number {
    font-size: 20px;
    font-weight: 700;
    color: #2C3E50;
    line-height: 1;
    margin-bottom: 2px;
}

.stat-label {
    font-size: 11px;
    font-weight: 600;
    color: #6C757D;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}

.stat-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
}

.stat-badge {
    font-size: 9px;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 8px;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.stat-badge-pending {
    background: #FFF3CD;
    color: #856404;
}

.stat-badge-approved {
    background: #D1E7DD;
    color: #0F5132;
}

.stat-badge-info {
    background: #CCE7FF;
    color: #055160;
}

.stat-badge-online {
    background: #E2E3E5;
    color: #383D41;
}

.stat-trend {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 2px;
    color: #28A745;
    font-size: 10px;
    font-weight: 600;
}

.stat-trend i {
    font-size: 14px;
}

.pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #28A745;
    animation: pulse 2s infinite;
    display: inline-block;
}

@keyframes pulse {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0.7);
    }
    
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 10px rgba(40, 167, 69, 0);
    }
    
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(40, 167, 69, 0);
    }
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 100px;
    height: 100px;
    opacity: 0.05;
    background-image: radial-gradient(circle, #000 2px, transparent 2px);
    background-size: 15px 15px;
}

/* Modern Cards */
.modern-card {
    background: #fff;
    border-radius: 20px;
    border: none;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    overflow: hidden;
    position: relative;
}

.modern-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.modern-card-header {
    background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
    padding: 14px 18px;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
    display: flex;
    align-items: center;
    gap: 12px;
    position: relative;
}

.modern-card-header-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 16px;
    flex-shrink: 0;
}

.modern-card-title {
    font-size: 14px;
    font-weight: 700;
    color: #2C3E50;
    margin: 0;
    flex: 1;
}

.modern-card-header-decoration {
    width: 50px;
    height: 3px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 2px;
    position: absolute;
    bottom: 0;
    left: 18px;
}

.modern-card-header-actions {
    margin-left: auto;
}

.modern-card-body {
    padding: 16px 18px;
}

/* Chart Container */
.chart-container {
    position: relative;
    padding: 12px;
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    border-radius: 12px;
    border: 1px solid rgba(102, 126, 234, 0.1);
    min-height: 220px;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Modern Action List */
.modern-action-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.modern-action-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 12px;
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    border: 1px solid rgba(102, 126, 234, 0.1);
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.modern-action-item:hover {
    transform: translateX(4px);
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-decoration: none;
    box-shadow: 0 8px 24px rgba(102, 126, 234, 0.2);
}

.modern-action-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.modern-action-icon-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.modern-action-icon-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

.modern-action-icon-warning {
    background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
    color: #8B4513;
}

.modern-action-icon-info {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
    color: #2C3E50;
}

.modern-action-icon-secondary {
    background: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%);
    color: #6C757D;
}

.modern-action-item:hover .modern-action-icon {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

.modern-action-content {
    flex: 1;
}

.modern-action-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 4px;
    color: #2C3E50;
    transition: color 0.3s ease;
}

.modern-action-subtitle {
    font-size: 12px;
    color: #6C757D;
    transition: color 0.3s ease;
}

.modern-action-item:hover .modern-action-title,
.modern-action-item:hover .modern-action-subtitle {
    color: white;
}

.modern-action-badge {
    padding: 6px 12px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.modern-badge-warning {
    background: #FFF3CD;
    color: #856404;
}

.modern-action-item:hover .modern-badge-warning {
    background: rgba(255, 255, 255, 0.2);
    color: white;
}

/* Modern Table */
.modern-table-container {
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.modern-table {
    width: 100%;
    margin: 0;
    background: white;
}

.modern-table thead {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.modern-table thead th {
    padding: 12px 16px;
    font-size: 12px;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border: none;
}

.modern-table-row {
    transition: all 0.3s ease;
    border-bottom: 1px solid rgba(102, 126, 234, 0.1);
}

.modern-table-row:hover {
    background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
    transform: scale(1.01);
}

.modern-table-row:last-child {
    border-bottom: none;
}

.modern-table-row td {
    padding: 12px 16px;
    font-size: 13px;
    color: #2C3E50;
    border: none;
    vertical-align: middle;
}

.modern-table-cell-primary {
    font-weight: 600;
    color: #667eea;
}

.modern-table-amount {
    font-family: 'Courier New', monospace;
    font-weight: 600;
    color: #28A745;
}

/* Modern Badges */
.modern-badge {
    padding: 6px 12px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.modern-badge-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.modern-badge-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    color: white;
}

/* Modern Progress */
.modern-progress-container {
    display: flex;
    align-items: center;
    gap: 12px;
}

.modern-progress {
    height: 8px;
    width: 80px;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.modern-progress-bar {
    height: 100%;
    border-radius: 4px;
    transition: width 0.3s ease;
    position: relative;
}

.modern-progress-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.modern-progress-success {
    background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
}

.modern-progress-info {
    background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
}

.modern-progress-text {
    font-size: 12px;
    font-weight: 600;
    color: #2C3E50;
    min-width: 40px;
}

.modern-table-footer {
    text-align: center;
    padding: 12px;
    background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
    border-top: 1px solid rgba(102, 126, 234, 0.1);
}

.modern-link {
    color: #667eea;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
}

.modern-link:hover {
    color: #764ba2;
    text-decoration: underline;
}

/* Modern Empty State */
.modern-empty-state {
    text-align: center;
    padding: 32px 20px;
    background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
    border-radius: 12px;
    border: 1px solid rgba(102, 126, 234, 0.1);
}

.modern-empty-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 16px;
    border-radius: 16px;
    background: linear-gradient(135deg, #e9ecff 0%, #f8f9ff 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #667eea;
    font-size: 24px;
}

.modern-empty-title {
    font-size: 16px;
    font-weight: 600;
    color: #2C3E50;
    margin-bottom: 6px;
}

.modern-empty-text {
    font-size: 13px;
    color: #6C757D;
    margin: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .dashboard-title {
        font-size: 1.75rem;
    }
    
    .dashboard-header {
        padding: 16px;
        text-align: center;
    }
    
    .dashboard-toolbar {
        justify-content: center;
        margin-top: 12px;
    }
    
    .modern-card-header {
        padding: 12px 16px;
    }
    
    .modern-card-body {
        padding: 14px 16px;
    }
    
    .modern-action-item {
        padding: 10px;
    }
    
    .modern-table-row td {
        padding: 10px 12px;
        font-size: 12px;
    }
    
    .stat-card-body {
        padding: 12px;
        gap: 10px;
    }
    
    .stat-icon {
        width: 38px;
        height: 38px;
        font-size: 16px;
    }
    
    .stat-number {
        font-size: 18px;
    }
    
    .stat-label {
        font-size: 11px;
    }
}

@media (max-width: 576px) {
    .modern-progress {
        width: 50px;
    }
    
    .modern-progress-container {
        gap: 6px;
    }
    
    .modern-table-row td {
        padding: 8px 10px;
        font-size: 11px;
    }
    
    .modern-empty-state {
        padding: 24px 12px;
    }
    
    .modern-empty-icon {
        width: 50px;
        height: 50px;
        font-size: 20px;
    }
    
    .dashboard-title {
        font-size: 1.5rem;
    }
    
    .dashboard-subtitle {
        font-size: 0.8rem;
    }
}
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Utilization Chart
        const utilizationCtx = document.getElementById('utilizationChart').getContext('2d');
        new Chart(utilizationCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($chartData['labels'] ?? []) !!},
                datasets: [{
                    label: 'Monthly Fund Utilization (₹ Cr)',
                    data: {!! json_encode($chartData['data'] ?? []) !!},
                    backgroundColor: function(context) {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return 'rgba(102, 126, 234, 0.8)';
                        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, 'rgba(102, 126, 234, 0.1)');
                        gradient.addColorStop(1, 'rgba(102, 126, 234, 0.8)');
                        return gradient;
                    },
                    borderColor: 'rgba(102, 126, 234, 1)',
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#2C3E50',
                        bodyColor: '#667eea',
                        borderColor: '#667eea',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(102, 126, 234, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#6C757D',
                            font: {
                                size: 12,
                                family: "'Inter', sans-serif"
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            color: '#6C757D',
                            font: {
                                size: 12,
                                family: "'Inter', sans-serif"
                            }
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
        
        // Funding Type Distribution Chart
        @if(isset($fundingTypeData) && count($fundingTypeData) > 0)
        const fundingTypeCtx = document.getElementById('fundingTypeChart').getContext('2d');
        new Chart(fundingTypeCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($fundingTypeData->pluck('funding_type')->toArray()) !!},
                datasets: [{
                    data: {!! json_encode($fundingTypeData->pluck('total_amount')->toArray()) !!},
                    backgroundColor: [
                        'rgba(102, 126, 234, 0.8)',
                        'rgba(75, 172, 254, 0.8)',
                        'rgba(168, 237, 234, 0.8)',
                        'rgba(250, 112, 154, 0.8)',
                        'rgba(255, 204, 188, 0.8)'
                    ],
                    borderColor: [
                        'rgba(102, 126, 234, 1)',
                        'rgba(75, 172, 254, 1)',
                        'rgba(168, 237, 234, 1)',
                        'rgba(250, 112, 154, 1)',
                        'rgba(255, 204, 188, 1)'
                    ],
                    borderWidth: 3,
                    hoverBorderWidth: 5,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#2C3E50',
                            font: {
                                size: 12,
                                family: "'Inter', sans-serif"
                            },
                            padding: 15,
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.95)',
                        titleColor: '#2C3E50',
                        bodyColor: '#667eea',
                        borderColor: '#667eea',
                        borderWidth: 1,
                        cornerRadius: 8,
                        displayColors: true,
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.formattedValue;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.raw / total) * 100).toFixed(1);
                                return `${label}: ₹${value}Cr (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    animateScale: true,
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });
        @endif
    });
</script>
@endsection 