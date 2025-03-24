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
                                            {{ $funding->college->college_name }} - ₹{{ $funding->approved_amt }} Cr (Balance: ₹{{ $funding->remaining_balance }} Cr)
                                        </option>
                                    @endforeach
                                </select>
                                @error('funding_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
            progressCounter++;
            
            // Add event listeners for remove buttons
            document.querySelectorAll('.remove-progress').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.progress-item').remove();
                });
            });
        });
        
        // Funding amount validation
        const fundingSelect = document.getElementById('funding_id');
        const billAmountInput = document.getElementById('bill_amt');
        
        billAmountInput.addEventListener('change', validateBillAmount);
        fundingSelect.addEventListener('change', validateBillAmount);
        
        function validateBillAmount() {
            const selectedOption = fundingSelect.options[fundingSelect.selectedIndex];
            if (!selectedOption.value) return;
            
            // Extract the balance amount from the option text
            const optionText = selectedOption.text;
            const balanceMatch = optionText.match(/Balance: ₹([\d.]+)/);
            
            if (balanceMatch && balanceMatch[1]) {
                const balance = parseFloat(balanceMatch[1]);
                const billAmount = parseFloat(billAmountInput.value);
                
                if (billAmount > balance) {
                    alert('Bill amount cannot exceed the remaining balance of ₹' + balance + ' Cr');
                    billAmountInput.value = balance;
                }
            }
        }
    });
</script>
@endsection 