@extends('admin.layouts.app')

@section('title', 'Edit College')

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
            z-index: 10;
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

        .modern-btn-cancel {
            background: rgba(108, 117, 125, 0.15);
            color: #495057;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .modern-btn-cancel:hover {
            background: rgba(108, 117, 125, 0.25);
            transform: translateY(-1px);
            color: #495057;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
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

        .modern-form-control, .modern-form-select {
            border-radius: 10px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            padding: 10px 14px;
            transition: all 0.3s ease;
            font-size: 13px;
            font-weight: 500;
        }

        .modern-form-control:focus, .modern-form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .modern-form-control.is-invalid, .modern-form-select.is-invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .form-label {
            font-weight: 600;
            color: #2C3E50;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .invalid-feedback {
            font-size: 11px;
            font-weight: 500;
        }

        .text-danger {
            color: #dc3545 !important;
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
            <h1><i class="bi bi-pencil me-2"></i>Edit College</h1>
            <a href="{{ route('admin.colleges.index') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-arrow-left"></i>
                Back to Colleges
            </a>
        </div>
    </div>

    <div class="modern-card">
        <div class="modern-card-header">
            <i class="bi bi-mortarboard"></i>
            Edit College Information
        </div>
        <div class="modern-card-body">
            <form action="{{ route('admin.colleges.update', $college->college_id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="college_name" class="form-label">College Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control modern-form-control @error('college_name') is-invalid @enderror" id="college_name" name="college_name" value="{{ old('college_name', $college->college_name) }}" required>
                    @error('college_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control modern-form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state', $college->state) }}" required>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                            <input type="text" class="form-control modern-form-control @error('district') is-invalid @enderror" id="district" name="district" value="{{ old('district', $college->district) }}" required>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">College Type <span class="text-danger">*</span></label>
                            <select class="form-select modern-form-select @error('type') is-invalid @enderror" id="type" name="type" required onchange="togglePhaseField()">
                                <option value="">Select Type</option>
                                @foreach($typeOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('type', $college->type) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6" id="phaseContainer" style="{{ $college->type === 'professional' ? 'display: none;' : '' }}">
                        <div class="mb-3">
                            <label for="phase" class="form-label">Phase <span class="text-danger">*</span></label>
                            <select class="form-select modern-form-select @error('phase') is-invalid @enderror" id="phase" name="phase" {{ $college->type === 'MDC' ? 'required' : '' }}>
                                <option value="">Select Phase</option>
                                @foreach($phaseOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('phase', $college->phase) == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('phase')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="bi bi-save"></i> Update College
                    </button>
                    <a href="{{ route('admin.colleges.index') }}" class="modern-btn modern-btn-cancel">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
            
            <script>
                function togglePhaseField() {
                    const typeSelect = document.getElementById('type');
                    const phaseContainer = document.getElementById('phaseContainer');
                    const phaseSelect = document.getElementById('phase');
                    
                    if (typeSelect.value === 'professional') {
                        phaseContainer.style.display = 'none';
                        phaseSelect.removeAttribute('required');
                    } else {
                        phaseContainer.style.display = 'block';
                        phaseSelect.setAttribute('required', 'required');
                    }
                }
                // Initialize on page load
                document.addEventListener('DOMContentLoaded', togglePhaseField);
            </script>
        </div>
    </div>
@endsection 