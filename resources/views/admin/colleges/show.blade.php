@extends('admin.layouts.app')

@section('title', 'College Details')

@section('content')
    <style>
        .modern-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            color: white;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: 0 6px 24px rgba(102, 126, 234, 0.3);
            position: relative;
            overflow: hidden;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.3;
        }

        .modern-header h1 {
            font-weight: 700;
            font-size: 1.5rem;
            margin: 0;
            z-index: 2;
            position: relative;
        }

        .modern-btn {
            padding: 8px 16px;
            border-radius: 10px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            font-size: 13px;
            position: relative;
            z-index: 1;
            cursor: pointer;
            pointer-events: auto;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .modern-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(79, 172, 254, 0.4);
            color: white;
        }

        .modern-btn-secondary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }

        .modern-btn-secondary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-1px);
            color: white;
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.4);
        }

        .modern-btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .modern-btn-warning:hover {
            background: #e0a800;
            transform: translateY(-1px);
            color: #212529;
        }

        .modern-btn-danger {
            background: #dc3545;
            color: white;
        }

        .modern-btn-danger:hover {
            background: #c82333;
            transform: translateY(-1px);
            color: white;
        }

        .modern-card {
            background: #fff;
            border-radius: 16px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            margin-bottom: 20px;
        }

        .modern-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .modern-card-header {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            padding: 14px 18px;
            font-weight: 600;
            color: #2C3E50;
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
        }

        .modern-card-body {
            padding: 20px 24px;
        }

        .info-item {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-radius: 12px;
            padding: 16px 20px;
            margin-bottom: 16px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
        }

        .info-item:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.1);
        }

        .info-label {
            font-weight: 600;
            color: #6C757D;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .info-value {
            font-weight: 600;
            color: #2C3E50;
            font-size: 15px;
            margin: 0;
        }

        .modern-badge {
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .modern-badge-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modern-badge-success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .modern-badge-info {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #2C3E50;
        }



        @media (max-width: 768px) {
            .modern-header {
                padding: 12px 16px;
                margin-bottom: 16px;
            }
            
            .modern-header h1 {
                font-size: 1.25rem;
            }
            
            .modern-card-body {
                padding: 16px 20px;
            }
            
            .modern-btn {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>

    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h1><i class="bi bi-eye me-2"></i>College Details</h1>
            <div class="d-flex gap-2 flex-wrap align-items-center">
                <a href="{{ route('admin.colleges.edit', $college->college_id) }}" class="modern-btn modern-btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('admin.colleges.destroy', $college->college_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this college? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modern-btn modern-btn-danger">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
                <a href="{{ route('admin.colleges.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Colleges
                </a>
            </div>
        </div>
    </div>

    <div class="modern-card">
        <div class="modern-card-header">
            <i class="bi bi-mortarboard"></i>
            College Information
        </div>
        <div class="modern-card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-label">College ID</div>
                        <p class="info-value">{{ $college->college_id }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-label">College Name</div>
                        <p class="info-value">{{ $college->college_name }}</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-label">State</div>
                        <p class="info-value">{{ $college->state }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-label">District</div>
                        <p class="info-value">{{ $college->district }}</p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-label">College Type</div>
                        <p class="info-value">
                            @if($college->type === 'professional')
                                <span class="modern-badge modern-badge-primary">
                                    <i class="bi bi-mortarboard"></i>
                                    Professional
                                </span>
                            @else
                                <span class="modern-badge modern-badge-success">
                                    <i class="bi bi-hospital"></i>
                                    MDC
                                </span>
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-label">Phase</div>
                        <p class="info-value">
                            @if($college->type === 'MDC' && $college->phase)
                                <span class="modern-badge modern-badge-info">
                                    <i class="bi bi-layers"></i>
                                    Phase {{ $college->phase }}
                                </span>
                            @else
                                <span style="color: #6C757D; font-style: italic;">Not applicable</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-label">Created At</div>
                        <p class="info-value">{{ $college->created_at ? $college->created_at->format('F d, Y h:i A') : 'Not available' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="info-item">
                        <div class="info-label">Last Updated</div>
                        <p class="info-value">{{ $college->updated_at ? $college->updated_at->format('F d, Y h:i A') : 'Not available' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 