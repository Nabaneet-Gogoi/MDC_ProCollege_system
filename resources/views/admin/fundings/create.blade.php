@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create Funding Allocation</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.fundings.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-currency-dollar me-1"></i> New Funding Allocation
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.fundings.store') }}" method="POST" id="fundingForm">
                @csrf

                <div class="mb-3">
                    <label for="college_id" class="form-label">College <span class="text-danger">*</span></label>
                    <select class="form-select @error('college_id') is-invalid @enderror" id="college_id" name="college_id" required>
                        <option value="">-- Select College --</option>
                        @foreach($colleges as $college)
                            <option value="{{ $college->college_id }}" data-type="{{ $college->type }}" data-phase="{{ $college->phase }}">
                                {{ $college->college_name }} ({{ ucfirst($college->type) }}
                                @if($college->type === 'MDC')
                                    - Phase {{ $college->phase }}
                                @endif)
                            </option>
                        @endforeach
                    </select>
                    @error('college_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="funding_name" class="form-label">Funding Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('funding_name') is-invalid @enderror" id="funding_name" name="funding_name" value="{{ old('funding_name') }}" required>
                    @error('funding_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="card bg-light mb-3" id="fundingInfo" style="display: none;">
                    <div class="card-header">Funding Information</div>
                    <div class="card-body">
                        <p>Based on the selected college type and phase:</p>
                        <ul id="fundingDetails">
                            <li>College Type: <span id="collegeType"></span></li>
                            <li>Phase: <span id="collegePhase"></span></li>
                            <li>Standard Funding: <span id="standardFunding"></span></li>
                            <li>Central Share: <span id="centralShare"></span></li>
                            <li>State Share: <span id="stateShare"></span></li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="approved_amt" class="form-label">Approved Amount (Cr) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('approved_amt') is-invalid @enderror" id="approved_amt" name="approved_amt" value="{{ old('approved_amt') }}" required>
                        @error('approved_amt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="central_share" class="form-label">Central Share (Cr) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('central_share') is-invalid @enderror" id="central_share" name="central_share" value="{{ old('central_share') }}" required>
                        @error('central_share')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="state_share" class="form-label">State Share (Cr) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('state_share') is-invalid @enderror" id="state_share" name="state_share" value="{{ old('state_share') }}" required>
                        @error('state_share')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="utilization_status" class="form-label">Utilization Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('utilization_status') is-invalid @enderror" id="utilization_status" name="utilization_status" required>
                        <option value="not_started" {{ old('utilization_status') == 'not_started' ? 'selected' : '' }}>Not Started</option>
                        <option value="in_progress" {{ old('utilization_status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('utilization_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('utilization_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" id="calculateBtn" class="btn btn-info me-md-2">
                        <i class="bi bi-calculator"></i> Auto-Calculate
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save Funding
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const collegeSelect = document.getElementById('college_id');
        const calculateBtn = document.getElementById('calculateBtn');
        const fundingInfo = document.getElementById('fundingInfo');
        const collegeType = document.getElementById('collegeType');
        const collegePhase = document.getElementById('collegePhase');
        const standardFunding = document.getElementById('standardFunding');
        const centralShare = document.getElementById('centralShare');
        const stateShare = document.getElementById('stateShare');
        const approvedAmtInput = document.getElementById('approved_amt');
        const centralShareInput = document.getElementById('central_share');
        const stateShareInput = document.getElementById('state_share');
        
        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!csrfToken) {
            console.error('CSRF token not found: https://laravel.com/docs/10.x/csrf#csrf-x-csrf-token');
        }
        
        // Hide funding info by default
        fundingInfo.style.display = 'none';
        
        // Function to calculate funding based on selected college
        function calculateFunding(collegeId) {
            if (!collegeId) return;
            
            console.log('Calculating funding for college ID:', collegeId);
            
            // Create form data for simple post
            const formData = new FormData();
            formData.append('college_id', collegeId);
            formData.append('_token', csrfToken);
            
            // Make AJAX call to calculate funding using XMLHttpRequest for compatibility
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route("admin.fundings.calculate") }}', true);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.onload = function() {
                if (xhr.status === 200) {
                    try {
                        const data = JSON.parse(xhr.responseText);
                        console.log('Funding data received:', data);
                        
                        // Update funding info display
                        const selectedOption = collegeSelect.options[collegeSelect.selectedIndex];
                        const type = selectedOption.dataset.type;
                        const phase = selectedOption.dataset.phase;
                        
                        collegeType.textContent = type === 'professional' ? 'Professional College' : 'Model Degree College (MDC)';
                        collegePhase.textContent = phase ? 'Phase ' + phase : 'N/A';
                        standardFunding.textContent = '₹ ' + data.approved_amt + ' crores';
                        centralShare.textContent = '₹ ' + data.central_share + ' crores (' + 
                            (data.central_share / data.approved_amt * 100).toFixed(0) + '%)';
                        stateShare.textContent = '₹ ' + data.state_share + ' crores (' + 
                            (data.state_share / data.approved_amt * 100).toFixed(0) + '%)';
                        
                        // Update form values
                        approvedAmtInput.value = data.approved_amt;
                        centralShareInput.value = data.central_share;
                        stateShareInput.value = data.state_share;
                        
                        // Show funding info card
                        fundingInfo.style.display = 'block';
                    } catch (e) {
                        console.error('Error parsing JSON response:', e);
                        alert('Error processing server response. Please try again.');
                    }
                } else {
                    console.error('Server returned error:', xhr.status, xhr.statusText);
                    alert('An error occurred while calculating funding. Please try again.');
                }
            };
            
            xhr.onerror = function() {
                console.error('Network error occurred');
                alert('A network error occurred. Please check your connection and try again.');
            };
            
            xhr.send(formData);
        }
        
        // Auto-Calculate button as fallback
        calculateBtn.addEventListener('click', function() {
            const collegeId = collegeSelect.value;
            
            if (!collegeId) {
                alert('Please select a college first');
                return;
            }
            
            calculateFunding(collegeId);
        });
        
        // Auto-calculate when college selection changes
        collegeSelect.addEventListener('change', function() {
            console.log('College selected:', this.value);
            
            // Clear form values first
            approvedAmtInput.value = '';
            centralShareInput.value = '';
            stateShareInput.value = '';
            fundingInfo.style.display = 'none';
            
            // If a college is selected, calculate funding
            if (this.value) {
                calculateFunding(this.value);
            }
        });
    });
</script>
@endsection 