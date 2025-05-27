@extends('admin.layouts.app')

@section('title', 'Release Details')

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
    
    .modern-btn-warning {
        background: #ffc107;
        color: #212529;
        box-shadow: 0 3px 10px rgba(255, 193, 7, 0.3);
    }
    
    .modern-btn-warning:hover {
        box-shadow: 0 4px 16px rgba(255, 193, 7, 0.4);
        color: #212529;
    }
    
    .modern-btn-danger {
        background: #dc3545;
        color: white;
        box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
    }
    
    .modern-btn-danger:hover {
        box-shadow: 0 4px 16px rgba(220, 53, 69, 0.4);
        color: white;
    }
    
    .modern-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 24px;
        transition: all 0.3s ease;
        background: white;
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
    
    .info-item {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border: 1px solid rgba(79, 172, 254, 0.1);
        border-radius: 10px;
        padding: 12px 16px;
        margin-bottom: 12px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    
    .info-item:hover {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-color: rgba(79, 172, 254, 0.2);
        transform: translateX(4px);
    }
    
    .info-label {
        font-weight: 600;
        font-size: 12px;
        color: #2c3e50;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        min-width: 160px;
    }
    
    .info-value {
        font-size: 13px;
        color: #495057;
        margin: 0;
        font-weight: 500;
        text-align: right;
        flex: 1;
    }
    
    .modern-progress {
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        height: 24px;
        overflow: hidden;
        position: relative;
    }
    
    .modern-progress-bar {
        height: 100%;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 600;
        color: white;
        transition: width 0.6s ease;
        position: relative;
    }
    
    .modern-progress-bar.bg-success {
        background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    }
    
    .modern-progress-bar.bg-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    
    .modern-progress-bar.bg-warning {
        background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
        color: #212529;
    }
    
    .stat-highlight {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
        border-radius: 8px;
        padding: 6px 12px;
        font-weight: 600;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .status-badge {
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    
    .danger-zone {
        background: linear-gradient(135deg, rgba(220, 53, 69, 0.05) 0%, rgba(220, 53, 69, 0.02) 100%);
        border: 1px solid rgba(220, 53, 69, 0.1);
        border-radius: 12px;
        padding: 20px;
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
        
        .info-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .info-label {
            min-width: auto;
        }
        
        .info-value {
            text-align: left;
        }
    }
</style>

<div class="container-fluid px-4">
    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h1><i class="bi bi-receipt me-2"></i>Release Details</h1>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.releases.edit', $release->release_id) }}" class="modern-btn modern-btn-warning">
                    <i class="bi bi-pencil me-1"></i> Edit Release
                </a>
                <a href="{{ route('admin.releases.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Release Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card modern-card">
                <div class="card-header modern-card-header">
                    <i class="bi bi-info-circle me-2"></i>Release Information
                </div>
                <div class="card-body modern-card-body">
                    <div class="info-item">
                        <div class="info-label">Release ID</div>
                        <div class="info-value">
                            <span class="stat-highlight">
                                <i class="bi bi-hash"></i>#{{ $release->release_id }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Release Amount</div>
                        <div class="info-value">
                            <span class="stat-highlight">
                                <i class="bi bi-currency-rupee"></i>{{ number_format($release->release_amt, 2) }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Release Date</div>
                        <div class="info-value">
                            <i class="bi bi-calendar-event me-2 text-muted"></i>
                            {{ $release->release_date->format('d M Y') }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Description</div>
                        <div class="info-value">{{ $release->desc }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Created At</div>
                        <div class="info-value">
                            <i class="bi bi-clock me-2 text-muted"></i>
                            {{ $release->created_at->format('d M Y H:i:s') }}
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Last Updated</div>
                        <div class="info-value">
                            <i class="bi bi-clock-history me-2 text-muted"></i>
                            {{ $release->updated_at->format('d M Y H:i:s') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Associated Funding Details Card -->
        <div class="col-md-6 mb-4">
            <div class="card modern-card">
                <div class="card-header modern-card-header">
                    <i class="bi bi-bank me-2"></i>Associated Funding Details
                </div>
                <div class="card-body modern-card-body">
                    <div class="info-item">
                        <div class="info-label">College</div>
                        <div class="info-value">
                            <i class="bi bi-building me-2 text-muted"></i>
                            <strong>{{ $release->funding->college->college_name }}</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Funding ID</div>
                        <div class="info-value">
                            <span class="status-badge bg-info text-white">
                                <i class="bi bi-tag"></i>#{{ $release->funding->funding_id }}
                            </span>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Approved Amount</div>
                        <div class="info-value">
                            <i class="bi bi-currency-rupee me-1 text-success"></i>
                            <strong class="text-success">{{ number_format($release->funding->approved_amt, 2) }}</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Total Released</div>
                        <div class="info-value">
                            <i class="bi bi-currency-rupee me-1 text-primary"></i>
                            <strong class="text-primary">{{ number_format($release->funding->total_released, 2) }}</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Remaining Balance</div>
                        <div class="info-value">
                            <i class="bi bi-currency-rupee me-1 text-warning"></i>
                            <strong class="text-warning">{{ number_format($release->funding->remaining_balance, 2) }}</strong>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Utilization Status</div>
                        <div class="info-value">
                            <div class="modern-progress">
                                <div class="modern-progress-bar {{ $release->funding->utilization_percentage >= 100 ? 'bg-success' : ($release->funding->utilization_percentage >= 75 ? 'bg-info' : 'bg-warning') }}" 
                                     style="width: {{ min($release->funding->utilization_percentage, 100) }}%">
                                    {{ number_format($release->funding->utilization_percentage, 1) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Card -->
    <div class="card modern-card">
        <div class="card-header modern-card-header">
            <i class="bi bi-gear me-2"></i>Available Actions
        </div>
        <div class="card-body modern-card-body">
            <div class="danger-zone">
                <h6 class="text-danger mb-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>Danger Zone
                </h6>
                <p class="text-muted mb-3" style="font-size: 13px;">
                    Deleting this release will permanently remove it from the system. This action cannot be undone and may affect funding calculations.
                </p>
                <form action="{{ route('admin.releases.destroy', $release->release_id) }}" 
                      method="POST" 
                      class="d-inline"
                      onsubmit="return confirm('⚠️ Are you absolutely sure you want to delete this release?\n\nThis will:\n• Permanently remove release #{{ $release->release_id }}\n• Affect funding calculations for {{ $release->funding->college->college_name }}\n• Cannot be undone\n\nType DELETE to confirm this action.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modern-btn modern-btn-danger">
                        <i class="bi bi-trash me-1"></i> Delete Release
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 