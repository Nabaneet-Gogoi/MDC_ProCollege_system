@extends('college.layouts.app')

@section('title', 'Submit New Bill')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Submit New Bill</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Bills
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="bi bi-file-earmark-text me-1"></i>
                    Bill Details
                </div>
                <div class="card-body">
                    <form action="{{ route('college.bills.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <input type="hidden" name="college_id" value="{{ auth()->user()->college_id }}">
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="funding_id" class="form-label">Select Project Funding <span class="text-danger">*</span></label>
                                <select class="form-select @error('funding_id') is-invalid @enderror" id="funding_id" name="funding_id" required>
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
                                    Note: Bill amount cannot exceed the available released funds.
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label for="bill_amt" class="form-label">Bill Amount (in Crores) <span class="text-danger">*</span></label>
                                <input type="number" step="0.01" class="form-control @error('bill_amt') is-invalid @enderror" 
                                    id="bill_amt" name="bill_amt" value="{{ old('bill_amt') }}" required>
                                @error('bill_amt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4">
                                <label for="bill_date" class="form-label">Bill Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('bill_date') is-invalid @enderror" 
                                    id="bill_date" name="bill_date" value="{{ old('bill_date', date('Y-m-d')) }}" required>
                                @error('bill_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Bill Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bill_image" class="form-label">Bill Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('bill_image') is-invalid @enderror" 
                                id="bill_image" name="bill_image" accept="image/*" required>
                            @error('bill_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Please upload a clear image of the physical bill (JPG, PNG, or PDF formats accepted).
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <h5 class="mb-3">Physical Progress Details</h5>
                        
                        <div id="progressContainer">
                            <div class="progress-item card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="category_id_0" class="form-label">Work Category <span class="text-danger">*</span></label>
                                            <select class="form-select category-select" id="category_id_0" name="progress[0][category_id]" required>
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
                                            <label for="completion_percent_0" class="form-label">Completion Percentage <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" min="0" max="100" class="form-control" 
                                                    id="completion_percent_0" name="progress[0][completion_percent]" value="0" required>
                                                <span class="input-group-text">%</span>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label for="progress_status_0" class="form-label">Work Status <span class="text-danger">*</span></label>
                                            <select class="form-select" id="progress_status_0" name="progress[0][progress_status]" required>
                                                <option value="not_started">Not Started</option>
                                                <option value="in_progress">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>
                                        
                                        <div class="col-md-12">
                                            <label for="progress_description_0" class="form-label">Work Description</label>
                                            <textarea class="form-control" id="progress_description_0" 
                                                name="progress[0][description]" rows="2"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="addMoreProgress">
                                <i class="bi bi-plus-circle"></i> Add More Progress Items
                            </button>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Submit Bill
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
            progressItem.className = 'progress-item card mb-3';
            
            // Create the progress item HTML with unique IDs
            progressItem.innerHTML = `
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="category_id_${progressCounter}" class="form-label">Work Category <span class="text-danger">*</span></label>
                            <select class="form-select category-select" id="category_id_${progressCounter}" name="progress[${progressCounter}][category_id]" required>
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
                            <label for="completion_percent_${progressCounter}" class="form-label">Completion Percentage <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01" min="0" max="100" class="form-control" 
                                    id="completion_percent_${progressCounter}" name="progress[${progressCounter}][completion_percent]" value="0" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="progress_status_${progressCounter}" class="form-label">Work Status <span class="text-danger">*</span></label>
                            <select class="form-select" id="progress_status_${progressCounter}" name="progress[${progressCounter}][progress_status]" required>
                                <option value="not_started">Not Started</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                        </div>
                        
                        <div class="col-md-11">
                            <label for="progress_description_${progressCounter}" class="form-label">Work Description</label>
                            <textarea class="form-control" id="progress_description_${progressCounter}" 
                                name="progress[${progressCounter}][description]" rows="2"></textarea>
                        </div>
                        
                        <div class="col-md-1 d-flex align-items-end mb-3">
                            <button type="button" class="btn btn-sm btn-outline-danger remove-progress">
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