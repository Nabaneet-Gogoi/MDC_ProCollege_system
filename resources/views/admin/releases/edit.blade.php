@extends('admin.layouts.app')

@section('title', 'Edit Fund Release')

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
    
    .modern-btn-info {
        background: #17a2b8;
        color: white;
        box-shadow: 0 3px 10px rgba(23, 162, 184, 0.3);
    }
    
    .modern-btn-info:hover {
        box-shadow: 0 4px 16px rgba(23, 162, 184, 0.4);
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
    
    .modern-form-control {
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 8px 12px;
        font-size: 13px;
        transition: all 0.3s ease;
    }
    
    .modern-form-control:focus {
        border: 1px solid #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
        outline: none;
    }
    
    .modern-form-select {
        border-radius: 10px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        padding: 8px 12px;
        font-size: 13px;
        transition: all 0.3s ease;
    }
    
    .modern-form-select:focus {
        border: 1px solid #4facfe;
        box-shadow: 0 0 0 0.2rem rgba(79, 172, 254, 0.25);
        outline: none;
    }
    
    .form-label {
        font-weight: 600;
        font-size: 12px;
        color: #2c3e50;
        margin-bottom: 6px;
    }
    
    .info-card {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
        border: 1px solid rgba(79, 172, 254, 0.1);
        border-radius: 12px;
        padding: 16px 20px;
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border-color: rgba(79, 172, 254, 0.2);
    }
    
    .info-card h5 {
        font-size: 13px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 12px;
    }
    
    .info-card p {
        font-size: 11px;
        margin-bottom: 6px;
        color: #495057;
    }
    
    .info-card p:last-child {
        margin-bottom: 0;
    }
    
    .modern-alert {
        border-radius: 12px;
        border: none;
        font-size: 13px;
        font-weight: 500;
        padding: 12px 16px;
    }
    
    .form-text {
        font-size: 11px;
        color: #6c757d;
        margin-top: 4px;
    }
    
    .input-group-text {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        border: 1px solid rgba(0, 0, 0, 0.1);
        border-radius: 10px 0 0 10px;
        font-size: 13px;
        font-weight: 600;
        color: #2c3e50;
    }
    
    .input-group .modern-form-control {
        border-radius: 0 10px 10px 0;
        border-left: none;
    }
    
    .input-group .modern-form-control:focus {
        border-left: 1px solid #4facfe;
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
        
        .info-card {
            padding: 12px 16px;
        }
    }
</style>

<div class="container-fluid px-4">
    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h1><i class="bi bi-pencil-square me-2"></i>Edit Fund Release</h1>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('admin.releases.show', $release->release_id) }}" class="modern-btn modern-btn-info">
                    <i class="bi bi-eye me-1"></i> View Details
                </a>
                <a href="{{ route('admin.releases.index') }}" class="modern-btn modern-btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Back to List
                </a>
            </div>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger modern-alert">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle-fill me-2 mt-1"></i>
                <div>
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="card modern-card">
        <div class="card-header modern-card-header">
            <i class="bi bi-form me-2"></i>Edit Release Information
        </div>
        <div class="card-body modern-card-body">
            <form action="{{ route('admin.releases.update', $release->release_id) }}" method="POST" id="releaseForm">
                @csrf
                @method('PUT')
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="funding_id" class="form-label">
                            <i class="bi bi-bank me-1"></i>Select Funding
                        </label>
                        <select name="funding_id" id="funding_id" class="form-select modern-form-select" required>
                            <option value="">Choose funding allocation...</option>
                            @foreach($fundings as $funding)
                                <option value="{{ $funding->funding_id }}" 
                                        data-college="{{ $funding->college->college_name }}"
                                        {{ (old('funding_id', $release->funding_id) == $funding->funding_id) ? 'selected' : '' }}>
                                    {{ $funding->college->college_name }} - ₹{{ number_format($funding->approved_amt, 2) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>Current: {{ $release->funding->college->college_name }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <h5><i class="bi bi-graph-up me-1"></i>Funding Details</h5>
                            <div id="fundingDetails">
                                <p><strong>College:</strong> <span id="collegeName">-</span></p>
                                <p><strong>Approved Amount:</strong> <span id="approvedAmount">-</span></p>
                                <p><strong>Total Released:</strong> <span id="totalReleased">-</span></p>
                                <p><strong>Remaining Balance:</strong> <span id="remainingBalance">-</span></p>
                                <p><strong>Utilization:</strong> <span id="utilizationPercentage">-</span></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="release_amt" class="form-label">
                            <i class="bi bi-currency-rupee me-1"></i>Release Amount
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" step="0.01" class="form-control modern-form-control" id="release_amt" 
                                   name="release_amt" value="{{ old('release_amt', $release->release_amt) }}" 
                                   required>
                        </div>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Current Amount: <strong>₹{{ number_format($release->release_amt, 2) }}</strong>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="release_date" class="form-label">
                            <i class="bi bi-calendar-event me-1"></i>Release Date
                        </label>
                        <input type="date" class="form-control modern-form-control" id="release_date" 
                               name="release_date" value="{{ old('release_date', $release->release_date->format('Y-m-d')) }}" 
                               required>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Current Date: <strong>{{ $release->release_date->format('d M Y') }}</strong>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="desc" class="form-label">
                        <i class="bi bi-text-paragraph me-1"></i>Description
                    </label>
                    <textarea class="form-control modern-form-control" id="desc" name="desc" rows="4" 
                              placeholder="Enter detailed description of this fund release..."
                              required>{{ old('desc', $release->desc) }}</textarea>
                    <div class="form-text">
                        <i class="bi bi-info-circle me-1"></i>
                        Provide details about the purpose, installment number, or any specific requirements.
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.releases.show', $release->release_id) }}" class="modern-btn modern-btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                        <i class="bi bi-check-circle me-1"></i>Update Release
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fundingSelect = document.getElementById('funding_id');
    const releaseAmtInput = document.getElementById('release_amt');
    const submitBtn = document.getElementById('submitBtn');
    const currentReleaseAmt = {{ $release->release_amt }};
    
    // Function to format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            maximumFractionDigits: 2
        }).format(amount);
    }

    // Function to update funding details
    function updateFundingDetails(fundingId) {
        if (!fundingId) {
            document.getElementById('collegeName').textContent = '-';
            document.getElementById('approvedAmount').textContent = '-';
            document.getElementById('totalReleased').textContent = '-';
            document.getElementById('remainingBalance').textContent = '-';
            document.getElementById('utilizationPercentage').textContent = '-';
            return;
        }

        // Show loading state
        const detailsDiv = document.getElementById('fundingDetails');
        detailsDiv.style.opacity = '0.6';

        // Use the correct route for funding details
        fetch('{{ url("admin/funding-details") }}/' + fundingId, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            console.log('Funding details received:', data);
            
            // Update display
            document.getElementById('collegeName').textContent = data.college_name;
            document.getElementById('approvedAmount').textContent = formatCurrency(data.approved_amt);
            document.getElementById('totalReleased').textContent = formatCurrency(data.total_released);
            document.getElementById('remainingBalance').textContent = formatCurrency(data.remaining_balance);
            document.getElementById('utilizationPercentage').textContent = `${data.utilization_percentage}%`;
            
            // For edit, we need to consider the current release amount in the max calculation
            // if it's the same funding
            const adjustedBalance = fundingId === '{{ $release->funding_id }}' 
                ? data.remaining_balance + currentReleaseAmt 
                : data.remaining_balance;
            
            releaseAmtInput.max = adjustedBalance;
            
            // Restore opacity
            detailsDiv.style.opacity = '1';
        })
        .catch(error => {
            console.error('Error fetching funding details:', error);
            
            // Show error message
            const errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-warning modern-alert mt-3';
            errorAlert.innerHTML = `
                <i class="bi bi-exclamation-triangle me-2"></i>
                <strong>Error loading funding details.</strong> Please try selecting a different funding or refresh the page.
            `;
            
            // Remove any existing error alerts
            const existingAlerts = document.querySelectorAll('.alert-warning');
            existingAlerts.forEach(alert => alert.remove());
            
            // Add error alert after the funding select
            fundingSelect.parentNode.appendChild(errorAlert);
            
            // Restore opacity
            detailsDiv.style.opacity = '1';
        });
    }

    // Event listener for funding selection change
    fundingSelect.addEventListener('change', function() {
        updateFundingDetails(this.value);
    });

    // Initialize funding details
    updateFundingDetails(fundingSelect.value);

    // Form validation and submission
    document.getElementById('releaseForm').addEventListener('submit', function(e) {
        const releaseAmt = parseFloat(releaseAmtInput.value);
        const maxAmount = parseFloat(releaseAmtInput.max);

        if (releaseAmt > maxAmount) {
            e.preventDefault();
            
            // Show custom error alert
            const errorAlert = document.createElement('div');
            errorAlert.className = 'alert alert-danger modern-alert';
            errorAlert.innerHTML = `
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Invalid Amount:</strong> Release amount cannot exceed the adjusted remaining balance of ${formatCurrency(maxAmount)}
            `;
            
            // Remove any existing error alerts
            const existingAlerts = document.querySelectorAll('.alert-danger');
            existingAlerts.forEach(alert => alert.remove());
            
            // Add error alert at the top
            this.parentNode.insertBefore(errorAlert, this);
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
            
            return false;
        }

        // Show loading state
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Updating...';
        submitBtn.disabled = true;
        
        // Re-enable after 5 seconds in case of issues
        setTimeout(function() {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });

    // Add input validation feedback
    releaseAmtInput.addEventListener('input', function() {
        const value = parseFloat(this.value);
        const max = parseFloat(this.max);
        
        if (value > max && max > 0) {
            this.style.borderColor = '#dc3545';
            this.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
        } else {
            this.style.borderColor = '';
            this.style.boxShadow = '';
        }
    });
});
</script>
@endpush 