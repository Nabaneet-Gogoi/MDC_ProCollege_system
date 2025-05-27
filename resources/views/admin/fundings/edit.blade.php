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

        .modern-header .modern-btn-secondary {
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

        /* Info Card Styling */
        .info-card {
            background: linear-gradient(135deg, #e0f2fe 0%, #f3e5f5 100%);
            border: 1px solid rgba(102, 126, 234, 0.15);
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }

        .info-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 8px 12px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 12px;
            margin-bottom: 12px;
            display: inline-block;
        }

        /* Modern Form Controls */
        .modern-form-control, .modern-form-select {
            border-radius: 8px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            padding: 8px 12px;
            font-size: 12px;
            font-weight: 500;
            transition: all 0.3s ease;
            background: white;
        }

        .modern-form-control:focus, .modern-form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        .modern-form-control.is-invalid, .modern-form-select.is-invalid {
            border-color: #dc3545;
        }

        .form-label {
            font-weight: 600;
            font-size: 12px;
            color: #2C3E50;
            margin-bottom: 6px;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        /* Modern Button System */
        .modern-btn {
            border-radius: 8px;
            font-weight: 600;
            font-size: 12px;
            padding: 10px 18px;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .modern-btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(79, 172, 254, 0.3);
            color: white;
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

        .modern-btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #20c5de 100%);
            color: white;
        }

        .modern-btn-info:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(23, 162, 184, 0.3);
            color: white;
        }

        /* Alert Styling */
        .modern-alert {
            border-radius: 10px;
            border: none;
            padding: 12px 16px;
            margin-bottom: 20px;
        }

        .modern-alert-danger {
            background: linear-gradient(135deg, #ff6b6b 0%, #ee5a52 100%);
            color: white;
        }

        /* Invalid Feedback */
        .invalid-feedback {
            font-size: 11px;
            font-weight: 500;
            margin-top: 4px;
        }

        /* College Info Display */
        .college-info {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
        }

        .college-info-item {
            flex: 1;
            min-width: 200px;
            padding: 12px;
            background: rgba(102, 126, 234, 0.05);
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .college-info-item strong {
            display: block;
            color: #2C3E50;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .college-info-item span {
            color: #6C757D;
            font-size: 12px;
            font-weight: 500;
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
                padding: 8px 14px;
            }

            .college-info {
                flex-direction: column;
            }

            .college-info-item {
                min-width: auto;
            }
        }
    </style>

    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap position-relative">
            <h1><i class="bi bi-pencil me-2"></i>Edit Funding Allocation</h1>
            <a href="{{ route('admin.fundings.index') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="modern-card">
        <div class="modern-card-header">
            <i class="bi bi-currency-dollar me-2"></i>Edit Funding for {{ $funding->college->college_name }}
        </div>
        <div class="modern-card-body">
            @if($errors->any())
                <div class="modern-alert modern-alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.fundings.update', $funding->funding_id) }}" method="POST" id="editFundingForm">
                @csrf
                @method('PUT')

                <div class="info-card">
                    <div class="info-card-header">
                        <i class="bi bi-building me-1"></i>College Information
                    </div>
                    <div class="college-info">
                        <div class="college-info-item">
                            <strong>College:</strong>
                            <span>{{ $funding->college->college_name }}</span>
                        </div>
                        <div class="college-info-item">
                            <strong>Type:</strong>
                            <span>
                                @if($funding->college->type === 'professional')
                                    Professional College
                                @else
                                    Model Degree College (MDC)
                                @endif
                            </span>
                        </div>
                        <div class="college-info-item">
                            <strong>Phase:</strong>
                            <span>Phase {{ $funding->college->phase }}</span>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="funding_name" class="form-label">Funding Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control modern-form-control @error('funding_name') is-invalid @enderror" id="funding_name" name="funding_name" value="{{ old('funding_name', $funding->funding_name ?? '') }}" required>
                    @error('funding_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="approved_amt" class="form-label">Approved Amount (Cr) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control modern-form-control @error('approved_amt') is-invalid @enderror" id="approved_amt" name="approved_amt" value="{{ old('approved_amt', $funding->approved_amt) }}" required>
                        @error('approved_amt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="central_share" class="form-label">Central Share (Cr) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control modern-form-control @error('central_share') is-invalid @enderror" id="central_share" name="central_share" value="{{ old('central_share', $funding->central_share) }}" required>
                        @error('central_share')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="state_share" class="form-label">State Share (Cr) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control modern-form-control @error('state_share') is-invalid @enderror" id="state_share" name="state_share" value="{{ old('state_share', $funding->state_share) }}" required>
                        @error('state_share')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="utilization_status" class="form-label">Utilization Status <span class="text-danger">*</span></label>
                    <select class="form-select modern-form-select @error('utilization_status') is-invalid @enderror" id="utilization_status" name="utilization_status" required>
                        <option value="not_started" {{ old('utilization_status', $funding->utilization_status) == 'not_started' ? 'selected' : '' }}>Not Started</option>
                        <option value="in_progress" {{ old('utilization_status', $funding->utilization_status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('utilization_status', $funding->utilization_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('utilization_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="button" id="recalculateBtn" class="modern-btn modern-btn-info">
                        <i class="bi bi-calculator"></i> Reset to Standard Values
                    </button>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="bi bi-save"></i> Update Funding
                    </button>
                </div>
            </form>
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

        // Enhanced form interaction
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('#editFundingForm');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            form.addEventListener('submit', function() {
                submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Updating...';
                submitBtn.disabled = true;
            });
        });
    </script>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const recalculateBtn = document.getElementById('recalculateBtn');
        const approvedAmtInput = document.getElementById('approved_amt');
        const centralShareInput = document.getElementById('central_share');
        const stateShareInput = document.getElementById('state_share');
        
        // Reset to standard values button
        recalculateBtn.addEventListener('click', function() {
            recalculateBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Calculating...';
            recalculateBtn.disabled = true;
            
            // Make AJAX call to calculate funding
            fetch('/admin/calculate-funding', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ college_id: '{{ $funding->college_id }}' })
            })
            .then(response => response.json())
            .then(data => {
                // Update form values
                approvedAmtInput.value = data.approved_amt;
                centralShareInput.value = data.central_share;
                stateShareInput.value = data.state_share;
                
                // Reset button
                recalculateBtn.innerHTML = '<i class="bi bi-calculator"></i> Reset to Standard Values';
                recalculateBtn.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while calculating funding. Please try again.');
                
                // Reset button
                recalculateBtn.innerHTML = '<i class="bi bi-calculator"></i> Reset to Standard Values';
                recalculateBtn.disabled = false;
            });
        });
    });
</script>
@endsection 