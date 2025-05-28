@extends('college.layouts.app')

@section('title', 'Submit New Bill')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="bi bi-plus-circle me-2 text-primary"></i>Submit New Bill</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.index') }}" class="btn btn-sm btn-secondary-gradient transition-hover">
                <i class="bi bi-arrow-left"></i> Back to Bills
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="modern-card mb-4">
                <div class="card-header d-flex align-items-center">
                    <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                    <span class="fw-bold">Bill Details</span>
                </div>
                <div class="card-body">
                    <form action="{{ route('college.bills.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="college_id" value="{{ auth()->user()->college_id }}">
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="funding_id" class="form-label fw-medium">Select Project Funding <span class="text-danger">*</span></label>
                                <select class="form-select modern-select @error('funding_id') is-invalid @enderror" id="funding_id" name="funding_id" required>
                                    <option value="">-- Select Funding --</option>
                                    @foreach($fundings as $funding)
                                        <option value="{{ $funding->funding_id }}" {{ old('funding_id') == $funding->funding_id ? 'selected' : '' }}>
                                            {{ $funding->college->college_name }} - 
                                            Released: ₹{{ $funding->total_released }} Cr, 
                                            Available: ₹{{ number_format($funding->available_released, 2) }} Cr
                                        </option>
                                    @endforeach
                                </select>
                                @error('funding_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Note: Bill amount cannot exceed the available released funds.
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="bill_amt" class="form-label fw-medium">Bill Amount (in Crores) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control modern-input @error('bill_amt') is-invalid @enderror" 
                                    id="bill_amt" name="bill_amt" value="{{ old('bill_amt') }}" required>
                                @error('bill_amt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="bill_date" class="form-label fw-medium">Bill Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control modern-input @error('bill_date') is-invalid @enderror" 
                                    id="bill_date" name="bill_date" value="{{ old('bill_date', date('Y-m-d')) }}" required>
                                @error('bill_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-medium">Bill Description</label>
                            <textarea class="form-control modern-input @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bill_image" class="form-label fw-medium">Bill Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control modern-input @error('bill_image') is-invalid @enderror" 
                                id="bill_image" name="bill_image" accept="image/*" required>
                            @error('bill_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-camera me-1"></i>Please upload a clear image of the physical bill (JPG, PNG, or PDF formats accepted).
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <h5 class="mb-3 section-title"><i class="bi bi-graph-up me-2"></i>Physical Progress Details</h5>
                        
                        <div id="progressContainer">
                            <div class="progress-item modern-card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="category_id_0" class="form-label fw-medium">Work Category <span class="text-danger">*</span></label>
                                            <select class="form-select modern-select category-select" id="category_id_0" name="progress[0][category_id]" required>
                                                <option value="">-- Select Category --</option>
                                                @foreach($categories as $id => $name)
                                                    <option value="{{ $id }}">{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="form-text previous-progress-info" id="previous_progress_info_0">
                                                <!-- Previous progress info will be displayed here -->
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="completion_percent_0" class="form-label fw-medium">Completion Percentage <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" min="0" max="100" class="form-control modern-input" 
                                                    id="completion_percent_0" name="progress[0][completion_percent]" value="0" required>
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="progress_status_0" class="form-label fw-medium">Work Status <span class="text-danger">*</span></label>
                                            <select class="form-select modern-select" id="progress_status_0" name="progress[0][progress_status]" required>
                                                <option value="not_started">Not Started</option>
                                                <option value="in_progress">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <label for="progress_description_0" class="form-label fw-medium">Work Description</label>
                                            <textarea class="form-control modern-input" id="progress_description_0" 
                                                name="progress[0][description]" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-secondary transition-hover" id="addMoreProgress">
                                <i class="bi bi-plus-circle"></i> Add More Progress Items
                            </button>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary-gradient">
                                <i class="bi bi-save"></i> Submit Bill
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Educational Theme Gradients */
        :root {
            --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%);
            --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
            --warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
            --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
            --danger-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            --secondary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
        }
        
        /* Modern Card Styling */
        .modern-card {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05), 0 1px 3px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            background: #fff;
            border: none;
        }
        
        .modern-card .card-header {
            background: rgba(240,242,245,0.5);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1rem 1.5rem;
            font-weight: 500;
        }
        
        .modern-card .card-body {
            padding: 1.5rem;
        }
        
        /* Modern Form Controls */
        .modern-input, .modern-select {
            border-radius: 0.375rem;
            border: 1px solid rgba(0,0,0,0.1);
            padding: 0.75rem 1rem;
            transition: all 0.2s ease;
            box-shadow: 0 1px 2px rgba(0,0,0,0.02);
        }
        
        .modern-input:focus, .modern-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.25);
        }
        
        /* Section Title */
        .section-title {
            color: #1e3c72;
            border-left: 4px solid #3b82f6;
            padding-left: 10px;
        }
        
        /* Button Gradients */
        .btn-primary-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
        }
        
        .btn-secondary-gradient {
            background: var(--secondary-gradient);
            border: none;
            color: white;
        }
        
        .btn-info-gradient {
            background: var(--info-gradient);
            border: none;
            color: white;
        }
        
        /* Transition Effects */
        .transition-hover {
            transition: all 0.3s ease;
        }
        
        .transition-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        /* Alert Styling for Previous Progress */
        .previous-progress-info .alert {
            border-radius: 0.375rem;
            border: none;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        /* Form Label Styling */
        .form-label {
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            color: #4b5563;
        }
        
        .mb-3 {
            margin-bottom: 1.5rem !important;
        }
        
        /* Progress item spacing */
        .progress-item .card-body {
            padding: 1.25rem;
        }
    </style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Store previous progress data in JavaScript object
        const previousProgressData = {
            @foreach($latestProgressByCategory as $categoryId => $progress)
                {{ $categoryId }}: {
                    completion_percent: {{ $progress['completion_percent'] }},
                    progress_status: "{{ $progress['progress_status'] }}",
                    @if(isset($progress['bill_no']))
                    source: "Bill #{{ $progress['bill_no'] }} ({{ $progress['bill_date'] }})"
                    @else
                    source: "Progress Report ({{ $progress['report_date'] }})"
                    @endif
                },
            @endforeach
        };

        // Initialize previous progress info for any pre-selected categories
        document.querySelectorAll('.category-select').forEach((select, index) => {
            if (select.value) {
                updateProgressInfo(select, index);
            }
        });

        // Bill amount validation against available released funds
        const fundingSelect = document.getElementById('funding_id');
        const billAmountInput = document.getElementById('bill_amt');
        
        // Function to validate bill amount
        function validateBillAmount() {
            const selectedOption = fundingSelect.options[fundingSelect.selectedIndex];
            
            if (selectedOption && selectedOption.value) {
                // Extract the available amount from the option text
                const optionText = selectedOption.text;
                const availableMatch = optionText.match(/Available: ₹([\d.]+)/);
                
                if (availableMatch && availableMatch[1]) {
                    const availableAmount = parseFloat(availableMatch[1].replace(/,/g, ''));
                    const billAmount = parseFloat(billAmountInput.value);
                    
                    if (billAmount > availableAmount) {
                        alert('Bill amount cannot exceed the available released funds of ₹' + availableAmount.toFixed(2) + ' Cr');
                        billAmountInput.value = availableAmount.toFixed(2);
                    }
                }
            }
        }
        
        // Add event listeners for validation
        fundingSelect.addEventListener('change', validateBillAmount);
        billAmountInput.addEventListener('change', validateBillAmount);
        billAmountInput.addEventListener('blur', validateBillAmount);
        
        // Form submission validation
        document.querySelector('form').addEventListener('submit', function(event) {
            if (fundingSelect.value) {
                validateBillAmount();
            }
        });

        // Function to update progress info and auto-populate fields based on selected category
        function updateProgressInfo(selectElement, index) {
            const categoryId = selectElement.value;
            const infoElement = document.getElementById(`previous_progress_info_${index}`);
            
            if (!infoElement) {
                console.error(`Cannot find info element for index ${index}`);
                return;
            }
            
            const completionInput = document.getElementById(`completion_percent_${index}`);
            const statusSelect = document.getElementById(`progress_status_${index}`);
            
            if (!completionInput || !statusSelect) {
                console.error(`Cannot find input elements for index ${index}`);
                return;
            }
            
            // Clear previous info
            infoElement.innerHTML = '';
            
            // If we have previous data for this category
            if (categoryId && previousProgressData[categoryId]) {
                const prevData = previousProgressData[categoryId];
                let statusText = '';
                
                switch(prevData.progress_status) {
                    case 'not_started':
                        statusText = 'Not Started';
                        break;
                    case 'in_progress':
                        statusText = 'In Progress';
                        break;
                    case 'completed':
                        statusText = 'Completed';
                        break;
                    default:
                        statusText = prevData.progress_status;
                }
                
                // Display previous progress info
                infoElement.innerHTML = `
                    <div class="alert alert-info py-1 px-2 mt-2 mb-0 small">
                        <i class="bi bi-info-circle"></i> Previous progress: <strong>${prevData.completion_percent}%</strong> 
                        (${statusText}) from ${prevData.source}
                    </div>
                `;
                
                // Auto-populate with at least the previous percentage (can't go backwards)
                if (!completionInput.getAttribute('data-user-changed')) {
                    completionInput.value = prevData.completion_percent;
                    
                    // Set status based on previous status, but don't downgrade status
                    if (prevData.progress_status === 'completed') {
                        statusSelect.value = 'completed';
                    } else if (prevData.progress_status === 'in_progress') {
                        statusSelect.value = 'in_progress';
                    }
                }
            }
        }
        
        // Add event listener for category changes
        document.querySelectorAll('.category-select').forEach((select, index) => {
            select.addEventListener('change', function() {
                updateProgressInfo(this, index);
            });
            
            // Also update on dropdown open and click/focus to make info more accessible
            select.addEventListener('focus', function() {
                if (this.value) {
                    updateProgressInfo(this, index);
                }
            });
        });
        
        // Mark completion percentage as user-changed when modified
        document.addEventListener('input', function(e) {
            if (e.target.id && e.target.id.startsWith('completion_percent_')) {
                e.target.setAttribute('data-user-changed', 'true');
            }
        });
        
        // Add more progress items
        let progressCounter = 1;
        
        document.getElementById('addMoreProgress').addEventListener('click', function() {
            const container = document.getElementById('progressContainer');
            
            const progressItem = document.createElement('div');
            progressItem.className = 'progress-item modern-card mb-3';
            
            // Create the progress item HTML with unique IDs
            progressItem.innerHTML = `
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="category_id_${progressCounter}" class="form-label fw-medium">Work Category <span class="text-danger">*</span></label>
                            <select class="form-select modern-select category-select" id="category_id_${progressCounter}" name="progress[${progressCounter}][category_id]" required>
                                <option value="">-- Select Category --</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <div class="form-text previous-progress-info" id="previous_progress_info_${progressCounter}">
                                <!-- Previous progress info will be displayed here -->
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="completion_percent_${progressCounter}" class="form-label fw-medium">Completion Percentage <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="100" class="form-control modern-input" 
                                    id="completion_percent_${progressCounter}" name="progress[${progressCounter}][completion_percent]" value="0" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="progress_status_${progressCounter}" class="form-label fw-medium">Work Status <span class="text-danger">*</span></label>
                            <select class="form-select modern-select" id="progress_status_${progressCounter}" name="progress[${progressCounter}][progress_status]" required>
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        
                        <div class="col-md-11">
                            <label for="progress_description_${progressCounter}" class="form-label fw-medium">Work Description</label>
                            <textarea class="form-control modern-input" id="progress_description_${progressCounter}" 
                                name="progress[${progressCounter}][description]" rows="2"></textarea>
                        </div>
                        
                        <div class="col-md-1 d-flex align-items-end mb-3">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-progress transition-hover">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(progressItem);
            
            // Get the newly added elements directly after appending to DOM
            const newRow = progressItem.querySelector('.row');
            const newCategorySelect = newRow.querySelector('.category-select');
            const newInfoElement = newRow.querySelector('.previous-progress-info');
            const newCompletionInput = newRow.querySelector('input[type="number"]');
            const newStatusSelect = newRow.querySelector('select:not(.category-select)');
            
            // Store the current counter index to use in event handlers
            const currentIndex = progressCounter;
            
            // Add event listeners for the new elements
            newCategorySelect.addEventListener('change', function() {
                // When category changes, display previous progress info
                const categoryId = this.value;
                
                // Clear previous info
                newInfoElement.innerHTML = '';
                
                if (categoryId && previousProgressData[categoryId]) {
                    const prevData = previousProgressData[categoryId];
                    let statusText = '';
                    
                    switch(prevData.progress_status) {
                        case 'not_started': statusText = 'Not Started'; break;
                        case 'in_progress': statusText = 'In Progress'; break;
                        case 'completed': statusText = 'Completed'; break;
                        default: statusText = prevData.progress_status;
                    }
                    
                    // Display previous progress info
                    newInfoElement.innerHTML = `
                        <div class="alert alert-info py-1 px-2 mt-2 mb-0 small">
                            <i class="bi bi-info-circle"></i> Previous progress: <strong>${prevData.completion_percent}%</strong> 
                            (${statusText}) from ${prevData.source}
                        </div>
                    `;
                    
                    // Auto-populate with at least the previous percentage
                    if (!newCompletionInput.getAttribute('data-user-changed')) {
                        newCompletionInput.value = prevData.completion_percent;
                        
                        // Set status based on previous status
                        if (prevData.progress_status === 'completed') {
                            newStatusSelect.value = 'completed';
                        } else if (prevData.progress_status === 'in_progress') {
                            newStatusSelect.value = 'in_progress';
                        }
                    }
                }
            });
            
            // Mark when user modifies completion percentage
            newCompletionInput.addEventListener('input', function() {
                this.setAttribute('data-user-changed', 'true');
            });
            
            // Increment counter for next item
            progressCounter++;
            
            // Add event listeners for remove buttons
            document.querySelectorAll('.remove-progress').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.progress-item').remove();
                });
            });
        });
    });
</script>
@endsection 