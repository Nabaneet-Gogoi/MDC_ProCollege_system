@extends('admin.layouts.app')

@section('title', 'Create Fund Release')

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
    
    .steps-indicator {
        display: flex;
        justify-content: center;
        margin-bottom: 24px;
        gap: 16px;
    }
    
    .step {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
    }
    
    .step.active {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        color: white;
    }
    
    .step.inactive {
        background: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }
    
    .help-section {
        background: linear-gradient(135deg, rgba(79, 172, 254, 0.02) 0%, rgba(118, 75, 162, 0.02) 100%);
        border: 1px solid rgba(79, 172, 254, 0.05);
        border-radius: 12px;
        padding: 16px 20px;
        margin-bottom: 24px;
    }
    
    .help-section h6 {
        font-size: 12px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }
    
    .help-section ul {
        font-size: 11px;
        color: #6c757d;
        margin: 0;
        padding-left: 16px;
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
        
        .steps-indicator {
            flex-direction: column;
            align-items: center;
        }
    }
</style>

<div class="container-fluid px-4">
    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h1><i class="bi bi-plus-circle me-2"></i>Create Fund Release</h1>
            <a href="{{ route('admin.releases.index') }}" class="modern-btn modern-btn-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>
    </div>

    <!-- Steps Indicator -->
    <div class="steps-indicator">
        <div class="step active">
            <i class="bi bi-1-circle"></i>
            <span>Select Funding</span>
        </div>
        <div class="step inactive">
            <i class="bi bi-2-circle"></i>
            <span>Set Amount & Date</span>
        </div>
        <div class="step inactive">
            <i class="bi bi-3-circle"></i>
            <span>Add Description</span>
        </div>
    </div>

    <!-- Help Section -->
    <div class="help-section">
        <h6><i class="bi bi-lightbulb me-1"></i>Quick Guide</h6>
        <ul>
            <li>Select an active funding allocation with available balance</li>
            <li>Ensure the release amount doesn't exceed the remaining balance</li>
            <li>Provide a clear description for tracking and audit purposes</li>
            <li>The release date should reflect when funds are actually disbursed</li>
        </ul>
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
            <i class="bi bi-form me-2"></i>Release Information
        </div>
        <div class="card-body modern-card-body">
            <form action="{{ route('admin.releases.store') }}" method="POST" id="releaseForm">
                @csrf
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="funding_id" class="form-label">
                            <i class="bi bi-bank me-1"></i>Select Funding Allocation
                        </label>
                        <select name="funding_id" id="funding_id" class="form-select modern-form-select" required>
                            <option value="">-- Choose funding allocation --</option>
                            @foreach($fundings as $funding)
                                <option value="{{ $funding->funding_id }}" 
                                        data-college="{{ $funding->college->college_name }}"
                                        {{ old('funding_id') == $funding->funding_id ? 'selected' : '' }}>
                                    {{ $funding->college->college_name }} - ₹{{ number_format($funding->approved_amt, 2) }} 
                                    (Balance: ₹{{ number_format($funding->remaining_balance, 2) }})
                                </option>
                            @endforeach
                        </select>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Choose from available funding allocations with remaining balance
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-card">
                            <h5><i class="bi bi-graph-up me-1"></i>Funding Overview</h5>
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
                                   name="release_amt" value="{{ old('release_amt') }}" 
                                   placeholder="0.00" required>
                        </div>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Amount must not exceed the remaining balance
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="release_date" class="form-label">
                            <i class="bi bi-calendar-event me-1"></i>Release Date
                        </label>
                        <input type="date" class="form-control modern-form-control" id="release_date" 
                               name="release_date" value="{{ old('release_date', date('Y-m-d')) }}" required>
                        <div class="form-text">
                            <i class="bi bi-info-circle me-1"></i>
                            Date when funds are actually disbursed
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="desc" class="form-label">
                        <i class="bi bi-text-paragraph me-1"></i>Description
                    </label>
                    <textarea class="form-control modern-form-control" id="desc" name="desc" rows="4" 
                              placeholder="Enter detailed description of this fund release (e.g., purpose, installment number, specific requirements, etc.)"
                              required>{{ old('desc') }}</textarea>
                    <div class="form-text">
                        <i class="bi bi-info-circle me-1"></i>
                        Provide clear details for tracking and audit purposes. Include purpose, installment number, or special conditions.
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.releases.index') }}" class="modern-btn modern-btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Cancel
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary" id="submitBtn">
                        <i class="bi bi-check-circle me-1"></i>Create Release
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
    const steps = document.querySelectorAll('.step');
    
    // Function to format currency
    function formatCurrency(amount) {
        return new Intl.NumberFormat('en-IN', {
            style: 'currency',
            currency: 'INR',
            maximumFractionDigits: 2
        }).format(amount);
    }

    // Function to update steps
    function updateSteps() {
        const hasFunding = fundingSelect.value !== '';
        const hasAmount = releaseAmtInput.value !== '';
        const hasDesc = document.getElementById('desc').value.trim() !== '';
        
        // Step 1: Select Funding
        steps[0].className = 'step ' + (hasFunding ? 'active' : 'inactive');
        
        // Step 2: Set Amount & Date
        steps[1].className = 'step ' + (hasFunding && hasAmount ? 'active' : 'inactive');
        
        // Step 3: Add Description
        steps[2].className = 'step ' + (hasFunding && hasAmount && hasDesc ? 'active' : 'inactive');
    }

    // Function to update funding details
    function updateFundingDetails(fundingId) {
        if (!fundingId) {
            document.getElementById('collegeName').textContent = '-';
            document.getElementById('approvedAmount').textContent = '-';
            document.getElementById('totalReleased').textContent = '-';
            document.getElementById('remainingBalance').textContent = '-';
            document.getElementById('utilizationPercentage').textContent = '-';
            releaseAmtInput.max = '';
            releaseAmtInput.value = '';
            updateSteps();
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
            
            // Update max amount for release_amt input
            releaseAmtInput.max = data.remaining_balance;
            
            // Set suggested release amount (optional)
            if (!releaseAmtInput.value && data.remaining_balance > 0) {
                releaseAmtInput.value = data.remaining_balance;
            }
            
            // Restore opacity
            detailsDiv.style.opacity = '1';
            
            // Update steps
            updateSteps();
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

    // Event listeners
    fundingSelect.addEventListener('change', function() {
        updateFundingDetails(this.value);
    });

    releaseAmtInput.addEventListener('input', function() {
        const value = parseFloat(this.value);
        const max = parseFloat(this.max);
        
        // Visual feedback for amount validation
        if (value > max && max > 0) {
            this.style.borderColor = '#dc3545';
            this.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
        } else {
            this.style.borderColor = '';
            this.style.boxShadow = '';
        }
        
        updateSteps();
    });

    document.getElementById('desc').addEventListener('input', updateSteps);

    // Initialize funding details if a funding is already selected
    if (fundingSelect.value) {
        updateFundingDetails(fundingSelect.value);
    } else {
        updateSteps();
    }

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
                <strong>Invalid Amount:</strong> Release amount cannot exceed the remaining balance of ${formatCurrency(maxAmount)}
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
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-1"></i>Creating...';
        submitBtn.disabled = true;
        
        // Re-enable after 5 seconds in case of issues
        setTimeout(function() {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 5000);
    });

    // Auto-save draft feature (optional enhancement)
    function saveDraft() {
        const formData = {
            funding_id: fundingSelect.value,
            release_amt: releaseAmtInput.value,
            release_date: document.getElementById('release_date').value,
            desc: document.getElementById('desc').value
        };
        
        localStorage.setItem('release_draft', JSON.stringify(formData));
    }

    // Load draft on page load
    function loadDraft() {
        const draft = localStorage.getItem('release_draft');
        if (draft) {
            const data = JSON.parse(draft);
            if (data.funding_id) fundingSelect.value = data.funding_id;
            if (data.release_amt) releaseAmtInput.value = data.release_amt;
            if (data.release_date) document.getElementById('release_date').value = data.release_date;
            if (data.desc) document.getElementById('desc').value = data.desc;
            
            updateFundingDetails(fundingSelect.value);
        }
    }

    // Auto-save every 30 seconds
    setInterval(saveDraft, 30000);
    
    // Load draft on page load
    loadDraft();
    
    // Clear draft on successful submission
    document.getElementById('releaseForm').addEventListener('submit', function() {
        localStorage.removeItem('release_draft');
    });
});
</script>
@endpush 