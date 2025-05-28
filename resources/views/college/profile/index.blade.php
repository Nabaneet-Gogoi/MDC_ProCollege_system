@extends('college.layouts.app')

@section('title', 'College Profile')

@section('content')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%);
    --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
    --warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
    --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
    --danger-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
    --secondary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
}

/* Modern Header Styling */
.modern-header {
    background: var(--primary-gradient);
    border-radius: 12px;
    padding: 16px;
    margin-bottom: 16px;
    box-shadow: 0 8px 24px rgba(30, 60, 114, 0.15);
}

.modern-header h1 {
    color: white;
    font-size: 1.5rem;
    margin: 0;
    font-weight: 600;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

/* Modern Card Styling */
.modern-card {
    border: none;
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
    overflow: hidden;
}

.modern-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
}

.modern-card .card-header {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
    border-bottom: 2px solid #e2e8f0;
    padding: 12px 16px;
    font-weight: 600;
    color: #334155;
    font-size: 0.95rem;
}

.modern-card .card-body {
    padding: 16px;
}

/* Enhanced Buttons */
.btn-modern {
    border-radius: 8px;
    font-weight: 500;
    padding: 8px 16px;
    font-size: 0.875rem;
    border: 1px solid rgba(255,255,255,0.3);
    backdrop-filter: blur(2px);
    transition: all 0.3s ease;
}

.btn-modern.btn-primary {
    background: var(--primary-gradient);
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

.btn-modern.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(59, 130, 246, 0.4);
}

.btn-modern.btn-secondary {
    background: var(--secondary-gradient);
    color: white;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.btn-modern.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
}

/* Compact Information Display */
.info-row {
    padding: 8px 0;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.9rem;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    color: #64748b;
    font-weight: 500;
    font-size: 0.85rem;
}

.info-value {
    color: #1e293b;
    font-weight: 600;
}

/* Enhanced Badges */
.badge-modern {
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.025em;
}

.badge-modern.bg-primary {
    background: var(--primary-gradient) !important;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}

.badge-modern.bg-info {
    background: var(--info-gradient) !important;
    box-shadow: 0 2px 8px rgba(6, 182, 212, 0.3);
}

.badge-modern.bg-secondary {
    background: linear-gradient(135deg, #94a3b8 0%, #64748b 100%) !important;
    box-shadow: 0 2px 8px rgba(100, 116, 139, 0.3);
}

/* Enhanced Progress Bar */
.progress-modern {
    height: 18px;
    border-radius: 10px;
    background: #f1f5f9;
    overflow: hidden;
    position: relative;
}

.progress-modern .progress-bar {
    background: var(--success-gradient);
    position: relative;
    overflow: hidden;
}

.progress-modern .progress-bar::after {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Enhanced Table */
.table-modern {
    font-size: 0.9rem;
}

.table-modern th {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    color: #475569;
    font-weight: 600;
    border: none;
    padding: 12px;
    font-size: 0.85rem;
}

.table-modern td {
    padding: 12px;
    border-color: #f1f5f9;
    vertical-align: middle;
}

.table-modern tbody tr {
    transition: all 0.2s ease;
}

.table-modern tbody tr:hover {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    transform: translateX(2px);
}

/* Compact Layout Utilities */
.compact-spacing {
    margin-bottom: 12px;
}

/* Enhanced Alert */
.alert-modern {
    border: none;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 0.9rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.alert-modern.alert-success {
    background: linear-gradient(135deg, rgba(5, 150, 105, 0.1) 0%, rgba(16, 185, 129, 0.1) 100%);
    border-left: 4px solid #10b981;
    color: #065f46;
}

.alert-modern.alert-info {
    background: linear-gradient(135deg, rgba(8, 145, 178, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
    border-left: 4px solid #06b6d4;
    color: #0c4a6e;
}

/* Modal Enhancements */
.modal-content {
    border: none;
    border-radius: 12px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.modal-header {
    background: var(--primary-gradient);
    color: white;
    border-radius: 12px 12px 0 0;
    padding: 16px 20px;
}

.modal-title {
    font-size: 1.1rem;
    font-weight: 600;
}

.modal-body {
    padding: 20px;
}

.form-control {
    border-radius: 8px;
    border: 2px solid #e2e8f0;
    padding: 10px 12px;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .modern-header {
        padding: 12px;
        margin-bottom: 12px;
    }
    
    .modern-header h1 {
        font-size: 1.3rem;
    }
    
    .modern-card .card-body {
        padding: 12px;
    }
    
    .info-row {
        font-size: 0.85rem;
    }
}
</style>

<div class="modern-header">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
        <h1 class="h2">College Profile</h1>
        <div class="btn-toolbar">
            <a href="{{ route('college.dashboard') }}" class="btn btn-modern btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-modern alert-success alert-dismissible fade show compact-spacing" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <!-- College Information Card -->
    <div class="col-md-6 compact-spacing">
        <div class="modern-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="bi bi-building me-2"></i>
                    College Information
                </div>
                <button type="button" class="btn btn-modern btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil"></i> Edit
                </button>
            </div>
            <div class="card-body">
                <div class="info-row d-flex">
                    <div class="col-md-4 info-label">College Name:</div>
                    <div class="col-md-8 info-value">{{ $college->college_name }}</div>
                </div>
                <div class="info-row d-flex">
                    <div class="col-md-4 info-label">College Type:</div>
                    <div class="col-md-8">
                        <span class="badge badge-modern bg-primary">{{ $typeOptions[$college->type] ?? $college->type }}</span>
                    </div>
                </div>
                <div class="info-row d-flex">
                    <div class="col-md-4 info-label">Phase:</div>
                    <div class="col-md-8">
                        @if($college->type === 'MDC')
                            <span class="badge badge-modern bg-info">{{ $phaseOptions[$college->phase] ?? $college->phase }}</span>
                        @else
                            <span class="badge badge-modern bg-secondary">N/A</span>
                        @endif
                    </div>
                </div>
                <div class="info-row d-flex">
                    <div class="col-md-4 info-label">State:</div>
                    <div class="col-md-8 info-value">{{ $college->state }}</div>
                </div>
                <div class="info-row d-flex">
                    <div class="col-md-4 info-label">District:</div>
                    <div class="col-md-8 info-value">{{ $college->district }}</div>
                </div>
                <div class="info-row d-flex">
                    <div class="col-md-4 info-label">Created:</div>
                    <div class="col-md-8 info-value">{{ $college->created_at ? $college->created_at->format('F d, Y') : 'Not available' }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Funding Information Card -->
    <div class="col-md-6 compact-spacing">
        <div class="modern-card h-100">
            <div class="card-header">
                <i class="bi bi-cash-coin me-2"></i>
                Funding Details
            </div>
            <div class="card-body">
                @if($fundingInfo)
                    <div class="info-row d-flex">
                        <div class="col-md-5 info-label">Total Approved:</div>
                        <div class="col-md-7 info-value">₹{{ $fundingInfo->approved_amt }} Cr</div>
                    </div>
                    <div class="info-row d-flex">
                        <div class="col-md-5 info-label">Central Share:</div>
                        <div class="col-md-7 info-value">₹{{ $fundingInfo->central_share }} Cr</div>
                    </div>
                    <div class="info-row d-flex">
                        <div class="col-md-5 info-label">State Share:</div>
                        <div class="col-md-7 info-value">₹{{ $fundingInfo->state_share }} Cr</div>
                    </div>
                    <div class="info-row d-flex">
                        <div class="col-md-5 info-label">Total Released:</div>
                        <div class="col-md-7 info-value">₹{{ $releasedAmount }} Cr</div>
                    </div>
                    <div class="info-row d-flex">
                        <div class="col-md-5 info-label">Release Status:</div>
                        <div class="col-md-7">
                            @php
                                $releasePercent = 0;
                                if($fundingInfo->approved_amt > 0) {
                                    $releasePercent = round(($releasedAmount / $fundingInfo->approved_amt) * 100, 2);
                                }
                            @endphp
                            <div class="progress progress-modern">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: {{ $releasePercent }}%;" 
                                     aria-valuenow="{{ $releasePercent }}" 
                                     aria-valuemin="0" 
                                     aria-valuemax="100">
                                    {{ $releasePercent }}%
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="info-row d-flex">
                        <div class="col-md-5 info-label">Utilization Status:</div>
                        <div class="col-md-7">
                            @if($fundingInfo->utilization_status === 'completed')
                                <span class="badge badge-modern" style="background: var(--success-gradient) !important;">Completed</span>
                            @elseif($fundingInfo->utilization_status === 'in_progress')
                                <span class="badge badge-modern bg-primary">In Progress</span>
                            @else
                                <span class="badge badge-modern" style="background: var(--warning-gradient) !important;">Not Started</span>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="alert alert-modern alert-info">
                        No funding information available for this college.
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- College Users Card -->
    <div class="col-md-12 compact-spacing">
        <div class="modern-card">
            <div class="card-header">
                <i class="bi bi-people me-2"></i>
                College Users
            </div>
            <div class="card-body">
                @if($college->users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-modern table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Last Login</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($college->users as $user)
                                    <tr>
                                        <td class="info-value">{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge badge-modern bg-info">{{ ucfirst($user->role) }}</span>
                                        </td>
                                        <td>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : 'Never' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-modern alert-info">
                        No users are associated with this college yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Edit Profile Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('college.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit College Profile</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="college_name" class="form-label">College Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('college_name') is-invalid @enderror" 
                            id="college_name" name="college_name" value="{{ old('college_name', $college->college_name) }}" required>
                        @error('college_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('state') is-invalid @enderror" 
                            id="state" name="state" value="{{ old('state', $college->state) }}" required>
                        @error('state')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('district') is-invalid @enderror" 
                            id="district" name="district" value="{{ old('district', $college->district) }}" required>
                        @error('district')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <div class="alert alert-modern alert-info">
                            <strong>Note:</strong> College type and phase cannot be changed. If you need to modify these details, please contact the administrator.
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-modern btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-modern btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 