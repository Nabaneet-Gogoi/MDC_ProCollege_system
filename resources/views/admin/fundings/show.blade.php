@extends('admin.layouts.app')

@section('content')
    <style>
        /* Modern Header Styling */
        .modern-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            border-radius: 16px;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.2);
            color: white !important;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: radial-gradient(circle at 2px 2px, rgba(255, 255, 255, 0.1) 1px, transparent 0);
            background-size: 20px 20px;
            opacity: 0.3;
            pointer-events: none;
        }

        .modern-header h1 {
            margin: 0;
            font-weight: 700;
            font-size: 1.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            color: white !important;
            position: relative;
            z-index: 2;
        }

        .modern-header .modern-btn {
            position: relative;
            z-index: 2;
            text-decoration: none;
        }

        /* Modern Card Styling */
        .modern-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.1);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .modern-card-header {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            padding: 14px 18px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            font-weight: 600;
            font-size: 14px;
            color: #2C3E50;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .modern-card-body {
            padding: 18px;
        }

        /* Modern Button System */
        .modern-btn {
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            padding: 8px 16px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-right: 8px;
        }

        .modern-btn-secondary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modern-btn-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
            color: white;
        }

        .modern-btn-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
            color: #212529;
        }

        .modern-btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(255, 193, 7, 0.3);
            color: #212529;
        }

        /* Info Display Cards */
        .info-item {
            background: white;
            border-radius: 10px;
            padding: 16px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: rgba(102, 126, 234, 0.02);
            border-color: rgba(102, 126, 234, 0.15);
        }

        .info-item strong {
            display: block;
            color: #2C3E50;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .info-item p, .info-item span {
            color: #6C757D;
            font-size: 12px;
            font-weight: 500;
            margin: 0;
        }

        /* Funding Amount Cards */
        .funding-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .funding-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.15);
        }

        .funding-card-header {
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 11px;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .funding-card-header.total { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .funding-card-header.central { background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); }
        .funding-card-header.state { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

        .funding-card h5 {
            font-size: 20px;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 8px;
        }

        .funding-card p {
            color: #6C757D;
            font-size: 11px;
            font-weight: 500;
            margin: 0;
        }

        /* Modern Badges */
        .modern-badge {
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 8px;
            display: inline-block;
        }

        .badge-professional {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .badge-mdc {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .badge-phase {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #2C3E50;
        }

        /* Alert Styling */
        .modern-alert {
            border-radius: 10px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .modern-alert-success {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }

        .modern-alert-warning {
            background: linear-gradient(135deg, #ffc107 0%, #ff8f00 100%);
            color: #212529;
        }

        /* Standard Funding Info */
        .standard-info {
            background: linear-gradient(135deg, #e0f2fe 0%, #f3e5f5 100%);
            border: 1px solid rgba(102, 126, 234, 0.15);
            border-radius: 10px;
            padding: 16px 20px;
        }

        .standard-info ul {
            list-style: none;
            padding: 0;
            margin: 8px 0 0 0;
        }

        .standard-info li {
            padding: 4px 0;
            font-size: 13px;
            color: #4a5568;
        }

        .standard-info li::before {
            content: '•';
            color: #667eea;
            font-weight: bold;
            width: 1em;
            margin-right: 8px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-header {
                padding: 16px 20px;
            }
            
            .modern-card-body {
                padding: 16px;
            }
            
            .modern-btn {
                font-size: 11px;
                padding: 6px 12px;
                margin-bottom: 8px;
            }

            .funding-card {
                margin-bottom: 16px;
            }
        }
    </style>

    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap position-relative">
            <h1><i class="bi bi-eye me-2"></i>Funding Details</h1>
            <div>
                <a href="{{ route('admin.fundings.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
                <a href="{{ route('admin.fundings.edit', $funding->funding_id) }}" class="modern-btn modern-btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
            </div>
        </div>
    </div>

    @if(session('success'))
        <div class="modern-alert modern-alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-card">
        <div class="modern-card-header">
            <i class="bi bi-building me-2"></i>College Information
        </div>
        <div class="modern-card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="info-item">
                        <strong>College Name:</strong>
                        <p>{{ $funding->college->college_name }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="info-item">
                        <strong>College ID:</strong>
                        <p>{{ $funding->college->college_id }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="info-item">
                        <strong>State:</strong>
                        <p>{{ $funding->college->state }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="info-item">
                        <strong>District:</strong>
                        <p>{{ $funding->college->district }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="info-item">
                        <strong>Type:</strong>
                        @if($funding->college->type === 'professional')
                            <span class="modern-badge badge-professional">Professional College</span>
                        @else
                            <span class="modern-badge badge-mdc">Model Degree College (MDC)</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="info-item">
                        <strong>Phase:</strong>
                        @if($funding->college->type === 'MDC')
                            <span class="modern-badge badge-phase">Phase {{ $funding->college->phase }}</span>
                        @else
                            <span>N/A</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modern-card">
        <div class="modern-card-header">
            <i class="bi bi-currency-dollar me-2"></i>Funding Information
        </div>
        <div class="modern-card-body">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="funding-card">
                        <div class="funding-card-header total">Total Approved Amount</div>
                        <h5>₹ {{ number_format($funding->approved_amt, 2) }} Crores</h5>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="funding-card">
                        <div class="funding-card-header central">Central Government Share</div>
                        <h5>₹ {{ number_format($funding->central_share, 2) }} Crores</h5>
                        <p>{{ number_format(($funding->central_share / $funding->approved_amt * 100), 0) }}% of total funding</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="funding-card">
                        <div class="funding-card-header state">State Government Share</div>
                        <h5>₹ {{ number_format($funding->state_share, 2) }} Crores</h5>
                        <p>{{ number_format(($funding->state_share / $funding->approved_amt * 100), 0) }}% of total funding</p>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-4 mb-3">
                    <div class="info-item">
                        <strong>Utilization Status:</strong>
                        @if($funding->utilization_status === 'not_started')
                            <span class="badge bg-secondary">Not Started</span>
                        @elseif($funding->utilization_status === 'in_progress')
                            <span class="badge bg-warning text-dark">In Progress</span>
                        @else
                            <span class="badge bg-success">Completed</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="info-item">
                        <strong>Created At:</strong>
                        <p>{{ $funding->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="info-item">
                        <strong>Last Updated:</strong>
                        <p>{{ $funding->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modern-card">
        <div class="modern-card-header">
            <i class="bi bi-info-circle me-2"></i>Standard Funding Information
        </div>
        <div class="modern-card-body">
            <div class="standard-info">
                <p style="color: #4a5568; font-size: 13px; margin-bottom: 12px;"><strong>Based on college type and phase, the standard funding allocation would be:</strong></p>
                <ul>
                    @if($funding->college->type === 'MDC')
                        @if($funding->college->phase === '1')
                            <li>MDC Phase 1: Total ₹8 crores (Central:State ratio = 50:50)</li>
                            <li>Central Share: ₹4 crores</li>
                            <li>State Share: ₹4 crores</li>
                        @else
                            <li>MDC Phase 2: Total ₹12 crores (Central:State ratio = 90:10)</li>
                            <li>Central Share: ₹10.8 crores</li>
                            <li>State Share: ₹1.2 crores</li>
                        @endif
                    @else
                        <li>Professional College: Total ₹26 crores (Central:State ratio = 90:10)</li>
                        <li>Central Share: ₹23.4 crores</li>
                        <li>State Share: ₹2.6 crores</li>
                    @endif
                </ul>
                @if($funding->approved_amt != 
                    ($funding->college->type === 'MDC' ? 
                        ($funding->college->phase === '1' ? 8 : 12) : 
                        26))
                    <div class="modern-alert modern-alert-warning mt-3">
                        <i class="bi bi-exclamation-triangle me-2"></i><strong>Note:</strong> The current funding amount differs from the standard amount for this college type and phase.
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endsection 