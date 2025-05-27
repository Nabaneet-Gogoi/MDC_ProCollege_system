@extends('admin.layouts.app')

@section('title', 'View Audit Log')

@section('styles')
<style>
    .audit-detail-container {
        background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
        min-height: calc(100vh - 60px);
        padding: 20px 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 25px 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(102, 126, 234, 0.15);
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.15) 1px, transparent 1px);
        background-size: 30px 30px;
        opacity: 0.4;
        pointer-events: none;
    }
    
    .page-header-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: between;
        align-items: center;
        gap: 20px;
    }
    
    .page-header h1 {
        color: white;
        font-weight: 700;
        font-size: 2.2rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 15px;
        flex: 1;
    }
    
    .page-header .header-icon {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        padding: 12px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .back-btn {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 12px;
        padding: 10px 20px;
        color: white;
        text-decoration: none;
        transition: all 0.3s ease;
        backdrop-filter: blur(10px);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .back-btn:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
    }
    
    .info-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border-radius: 20px;
        border: 1px solid rgba(102, 126, 234, 0.1);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
        margin-bottom: 25px;
        overflow: hidden;
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    }
    
    .info-card .card-header {
        background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        padding: 20px 25px;
        font-weight: 700;
        color: #667eea;
        font-size: 1.1rem;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    
    .info-card .card-body {
        padding: 25px;
    }
    
    .info-table {
        border: none;
        margin-bottom: 0;
    }
    
    .info-table tr {
        border: none;
    }
    
    .info-table th {
        background: none;
        border: none;
        padding: 12px 15px 12px 0;
        font-weight: 700;
        color: #4a5568;
        font-size: 0.9rem;
        vertical-align: top;
        width: 150px;
    }
    
    .info-table td {
        border: none;
        padding: 12px 0;
        color: #2d3748;
        font-size: 0.95rem;
        vertical-align: top;
    }
    
    .admin-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .admin-avatar {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 18px;
        font-weight: 600;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }
    
    .admin-details .admin-name {
        font-weight: 700;
        color: #2d3748;
        font-size: 1rem;
        margin-bottom: 2px;
    }
    
    .admin-details .admin-email {
        color: #718096;
        font-size: 0.85rem;
    }
    
    .system-indicator {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #718096;
        font-weight: 600;
    }
    
    .system-avatar {
        width: 45px;
        height: 45px;
        border-radius: 12px;
        background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 16px;
    }
    
    .badge {
        padding: 8px 14px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border: 1px solid;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .badge.bg-success {
        background: linear-gradient(135deg, #48bb78 0%, #38a169 100%) !important;
        border-color: #38a169;
        box-shadow: 0 2px 8px rgba(72, 187, 120, 0.3);
    }
    
    .badge.bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
    }
    
    .badge.bg-danger {
        background: linear-gradient(135deg, #f56565 0%, #e53e3e 100%) !important;
        border-color: #e53e3e;
        box-shadow: 0 2px 8px rgba(245, 101, 101, 0.3);
    }
    
    .badge.bg-info {
        background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%) !important;
        border-color: #3182ce;
        box-shadow: 0 2px 8px rgba(66, 153, 225, 0.3);
    }
    
    .description-text {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(102, 126, 234, 0.1);
        color: #2d3748;
        line-height: 1.6;
        font-size: 0.95rem;
    }
    
    .properties-table {
        border: none;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    
    .properties-table thead th {
        background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
        border: none;
        padding: 18px 20px;
        font-weight: 700;
        color: #667eea;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .properties-table tbody tr {
        transition: all 0.3s ease;
        border: none;
    }
    
    .properties-table tbody tr:hover {
        background: linear-gradient(135deg, #f8f9ff 0%, rgba(248, 249, 255, 0.5) 100%);
    }
    
    .properties-table tbody td {
        padding: 16px 20px;
        border: none;
        color: #2d3748;
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(102, 126, 234, 0.05);
    }
    
    .field-name {
        font-weight: 600;
        color: #4a5568;
    }
    
    .old-value {
        background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
        padding: 8px 12px;
        border-radius: 8px;
        color: #742a2a;
        font-family: 'Monaco', 'Courier New', monospace;
        font-size: 0.85rem;
        border: 1px solid #fc8181;
    }
    
    .new-value {
        background: linear-gradient(135deg, #c6f6d5 0%, #9ae6b4 100%);
        padding: 8px 12px;
        border-radius: 8px;
        color: #22543d;
        font-family: 'Monaco', 'Courier New', monospace;
        font-size: 0.85rem;
        border: 1px solid #68d391;
    }
    
    .deleted-value {
        background: linear-gradient(135deg, #fed7d7 0%, #feb2b2 100%);
        padding: 8px 12px;
        border-radius: 8px;
        color: #742a2a;
        font-family: 'Monaco', 'Courier New', monospace;
        font-size: 0.85rem;
        border: 1px solid #fc8181;
    }
    
    .na-value {
        color: #a0aec0;
        font-style: italic;
        font-size: 0.85rem;
    }
    
    .json-display {
        background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
        border-radius: 12px;
        padding: 20px;
        color: #e2e8f0;
        font-family: 'Monaco', 'Courier New', monospace;
        font-size: 0.85rem;
        line-height: 1.5;
        border: 1px solid #4a5568;
        overflow-x: auto;
    }
    
    .request-info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }
    
    .request-info-item {
        background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(102, 126, 234, 0.1);
    }
    
    .request-info-label {
        font-weight: 700;
        color: #4a5568;
        font-size: 0.9rem;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .request-info-value {
        color: #2d3748;
        font-size: 0.9rem;
        word-break: break-all;
        line-height: 1.4;
    }
    
    /* Mobile Responsiveness */
    @media (max-width: 768px) {
        .page-header {
            padding: 20px;
            border-radius: 15px;
        }
        
        .page-header-content {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }
        
        .page-header h1 {
            font-size: 1.8rem;
            justify-content: center;
            text-align: center;
        }
        
        .back-btn {
            align-self: center;
        }
        
        .info-card .card-body {
            padding: 20px;
        }
        
        .info-table th {
            width: 120px;
            font-size: 0.8rem;
        }
        
        .info-table td {
            font-size: 0.85rem;
        }
        
        .admin-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        
        .admin-avatar,
        .system-avatar {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }
        
        .properties-table thead th,
        .properties-table tbody td {
            padding: 12px 15px;
            font-size: 0.8rem;
        }
        
        .request-info-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }
    
    /* Loading animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .info-card {
        animation: fadeInUp 0.6s ease-out;
    }
    
    .info-card:nth-child(2) { animation-delay: 0.1s; }
    .info-card:nth-child(3) { animation-delay: 0.2s; }
    .info-card:nth-child(4) { animation-delay: 0.3s; }
    .info-card:nth-child(5) { animation-delay: 0.4s; }
</style>
@endsection

@section('content')
<div class="audit-detail-container">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-content">
            <h1>
                <div class="header-icon">
                    <i class="bi bi-file-text"></i>
                </div>
                Audit Log Details
            </h1>
            <a href="{{ route('admin.audit-logs.index') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i>
                Back to Logs
            </a>
        </div>
    </div>

    <!-- Basic Information -->
    <div class="info-card">
        <div class="card-header">
            <i class="bi bi-info-circle"></i>
            Basic Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <table class="info-table">
                        <tr>
                            <th><i class="bi bi-hash me-2"></i>Log ID:</th>
                            <td>
                                <span class="badge bg-secondary">#{{ $auditLog->id }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-person me-2"></i>Admin:</th>
                            <td>
                                @if($auditLog->admin)
                                    <div class="admin-info">
                                        <div class="admin-avatar">
                                            {{ strtoupper(substr($auditLog->admin->name ?? $auditLog->admin->email, 0, 1)) }}
                                        </div>
                                        <div class="admin-details">
                                            <div class="admin-name">{{ $auditLog->admin->name ?? 'N/A' }}</div>
                                            <div class="admin-email">{{ $auditLog->admin->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="system-indicator">
                                        <div class="system-avatar">
                                            <i class="bi bi-gear"></i>
                                        </div>
                                        <span>System Operation</span>
                                    </div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-activity me-2"></i>Action:</th>
                            <td>
                                <span class="badge 
                                    {{ $auditLog->action == 'create' ? 'bg-success' : '' }}
                                    {{ $auditLog->action == 'update' ? 'bg-primary' : '' }}
                                    {{ $auditLog->action == 'delete' ? 'bg-danger' : '' }}
                                    {{ !in_array($auditLog->action, ['create', 'update', 'delete']) ? 'bg-info' : '' }}
                                ">
                                    <i class="bi 
                                        {{ $auditLog->action == 'create' ? 'bi-plus-circle' : '' }}
                                        {{ $auditLog->action == 'update' ? 'bi-pencil-square' : '' }}
                                        {{ $auditLog->action == 'delete' ? 'bi-trash' : '' }}
                                        {{ !in_array($auditLog->action, ['create', 'update', 'delete']) ? 'bi-activity' : '' }}
                                    "></i>
                                    {{ ucfirst($auditLog->action) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6">
                    <table class="info-table">
                        <tr>
                            <th><i class="bi bi-box me-2"></i>Model Type:</th>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-diagram-3 text-primary"></i>
                                    <span class="fw-semibold">{{ class_basename($auditLog->model_type) }}</span>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-key me-2"></i>Model ID:</th>
                            <td>
                                @if($auditLog->model_id)
                                    <span class="badge bg-secondary">#{{ $auditLog->model_id }}</span>
                                @else
                                    <span class="na-value">Not Applicable</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th><i class="bi bi-calendar-event me-2"></i>Date & Time:</th>
                            <td>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $auditLog->created_at->format('F j, Y') }}</div>
                                    <div class="text-muted">{{ $auditLog->created_at->format('g:i:s A') }}</div>
                                    <small class="text-muted">{{ $auditLog->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Description -->
    <div class="info-card">
        <div class="card-header">
            <i class="bi bi-file-text"></i>
            Description
        </div>
        <div class="card-body">
            <div class="description-text">
                {{ $auditLog->description }}
            </div>
        </div>
    </div>

    <!-- Changed Properties -->
    @if($auditLog->properties && count($auditLog->properties) > 0)
        <div class="info-card">
            <div class="card-header">
                <i class="bi bi-list-columns"></i>
                Changed Properties
                <span class="badge bg-primary ms-2">
                    {{ isset($auditLog->properties['attributes']) ? count($auditLog->properties['attributes']) : 0 }} Fields
                </span>
            </div>
            <div class="card-body p-0">
                @if(isset($auditLog->properties['old']) && isset($auditLog->properties['attributes']))
                    <div class="table-responsive">
                        <table class="properties-table">
                            <thead>
                                <tr>
                                    <th width="25%">Field Name</th>
                                    <th width="37.5%">Previous Value</th>
                                    <th width="37.5%">New Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auditLog->properties['attributes'] as $key => $value)
                                    @if(array_key_exists($key, $auditLog->properties['old']) || $auditLog->action == 'create')
                                        <tr>
                                            <td>
                                                <div class="field-name">
                                                    <i class="bi bi-arrow-right-circle me-2 text-primary"></i>
                                                    {{ ucwords(str_replace('_', ' ', $key)) }}
                                                </div>
                                            </td>
                                            <td>
                                                @if($auditLog->action == 'create')
                                                    <span class="na-value">
                                                        <i class="bi bi-dash-circle me-1"></i>
                                                        No previous value
                                                    </span>
                                                @else
                                                    <div class="old-value">
                                                        {{ $auditLog->properties['old'][$key] ?? 'Empty' }}
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="new-value">
                                                    {{ $value ?: 'Empty' }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @elseif($auditLog->action == 'delete' && isset($auditLog->properties['old']))
                    <div class="table-responsive">
                        <table class="properties-table">
                            <thead>
                                <tr>
                                    <th width="30%">Field Name</th>
                                    <th width="70%">Deleted Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auditLog->properties['old'] as $key => $value)
                                    <tr>
                                        <td>
                                            <div class="field-name">
                                                <i class="bi bi-trash me-2 text-danger"></i>
                                                {{ ucwords(str_replace('_', ' ', $key)) }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="deleted-value">
                                                {{ $value ?: 'Empty' }}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="card-body">
                        <h6 class="mb-3">
                            <i class="bi bi-code-square me-2"></i>
                            Raw Properties Data
                        </h6>
                        <div class="json-display">{{ json_encode($auditLog->properties, JSON_PRETTY_PRINT) }}</div>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Request Information -->
    @if(isset($auditLog->ip_address) || isset($auditLog->user_agent))
        <div class="info-card">
            <div class="card-header">
                <i class="bi bi-hdd-network"></i>
                Request Information
            </div>
            <div class="card-body">
                <div class="request-info-grid">
                    @if(isset($auditLog->ip_address))
                        <div class="request-info-item">
                            <div class="request-info-label">
                                <i class="bi bi-geo-alt"></i>
                                IP Address
                            </div>
                            <div class="request-info-value">{{ $auditLog->ip_address }}</div>
                        </div>
                    @endif
                    
                    @if(isset($auditLog->user_agent))
                        <div class="request-info-item">
                            <div class="request-info-label">
                                <i class="bi bi-browser-chrome"></i>
                                User Agent
                            </div>
                            <div class="request-info-value">{{ $auditLog->user_agent }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        
        // Enhanced hover effects for property rows
        const propertyRows = document.querySelectorAll('.properties-table tbody tr');
        
        propertyRows.forEach(row => {
            row.addEventListener('mouseenter', function() {
                this.style.transform = 'translateX(4px)';
                this.style.transition = 'all 0.3s ease';
            });
            
            row.addEventListener('mouseleave', function() {
                this.style.transform = 'translateX(0)';
            });
        });
        
        // Copy to clipboard functionality for JSON data
        const jsonDisplay = document.querySelector('.json-display');
        if (jsonDisplay) {
            jsonDisplay.addEventListener('click', function() {
                const textArea = document.createElement('textarea');
                textArea.value = this.textContent;
                document.body.appendChild(textArea);
                textArea.select();
                document.execCommand('copy');
                document.body.removeChild(textArea);
                
                // Show temporary success message
                const originalContent = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check-circle text-success"></i> Copied to clipboard!';
                setTimeout(() => {
                    this.innerHTML = originalContent;
                }, 2000);
            });
            
            // Add cursor pointer to indicate clickable
            jsonDisplay.style.cursor = 'pointer';
            jsonDisplay.title = 'Click to copy to clipboard';
        }
        
        // Auto-refresh timestamp
        const timestampElement = document.querySelector('[data-timestamp]');
        if (timestampElement) {
            setInterval(() => {
                // Update relative time display
                const timestamp = timestampElement.getAttribute('data-timestamp');
                const date = new Date(timestamp);
                const now = new Date();
                const diff = now - date;
                const minutes = Math.floor(diff / 60000);
                const hours = Math.floor(minutes / 60);
                const days = Math.floor(hours / 24);
                
                let relativeTime;
                if (days > 0) {
                    relativeTime = `${days} day${days > 1 ? 's' : ''} ago`;
                } else if (hours > 0) {
                    relativeTime = `${hours} hour${hours > 1 ? 's' : ''} ago`;
                } else {
                    relativeTime = `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
                }
                
                const relativeElement = timestampElement.querySelector('.relative-time');
                if (relativeElement) {
                    relativeElement.textContent = relativeTime;
                }
            }, 60000); // Update every minute
        }
    });
</script>
@endsection 