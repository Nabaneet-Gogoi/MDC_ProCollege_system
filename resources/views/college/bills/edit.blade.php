@extends('college.layouts.app')

@section('title', 'Edit Bill')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Bill #{{ $bill->bill_no }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.show', $bill->bill_id) }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Bill Details
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
                    <form action="{{ route('college.bills.update', $bill->bill_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Read-only Information -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label">Bill Number</label>
                                <input type="text" class="form-control" value="{{ $bill->bill_no }}" readonly>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label">Bill Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control" value="{{ $bill->bill_amt }}" readonly>
                                    <span class="input-group-text">Cr</span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label">Project Funding</label>
                                <input type="text" class="form-control" value="{{ $bill->funding->college->college_name }} - ₹{{ $bill->funding->approved_amt }} Cr" readonly>
                                <input type="hidden" name="funding_id" value="{{ $bill->funding_id }}">
                                <input type="hidden" name="bill_amt" value="{{ $bill->bill_amt }}">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="bill_date" class="form-label">Bill Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('bill_date') is-invalid @enderror" 
                                    id="bill_date" name="bill_date" value="{{ old('bill_date', $bill->bill_date->format('Y-m-d')) }}" required>
                                @error('bill_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Bill Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="3">{{ old('description', $bill->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bill_image" class="form-label">Bill Image</label>
                            @if($bill->bill_image)
                                <div class="mb-2">
                                    <label>Current Image:</label>
                                    <div>
                                        <a href="{{ asset('storage/' . $bill->bill_image) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $bill->bill_image) }}" alt="Bill Image" class="img-thumbnail" style="max-height: 100px;">
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <input type="file" class="form-control @error('bill_image') is-invalid @enderror" 
                                id="bill_image" name="bill_image" accept="image/*">
                            @error('bill_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Upload a new image only if you want to replace the existing one.
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <h5 class="mb-3">Physical Progress Details</h5>
                        
                        <div id="progressContainer">
                            @foreach($bill->progress as $index => $progress)
                                <div class="progress-item card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" name="progress[{{ $index }}][progress_id]" value="{{ $progress->progress_id }}">
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="category_id_{{ $index }}" class="form-label">Work Category <span class="text-danger">*</span></label>
                                                <select class="form-select category-select" id="category_id_{{ $index }}" name="progress[{{ $index }}][category_id]" required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach($categories as $id => $name)
                                                        <option value="{{ $id }}" {{ old("progress.{$index}.category_id", $progress->category_id) == $id ? 'selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="completion_percent_{{ $index }}" class="form-label">Completion Percentage <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" min="0" max="100" class="form-control" 
                                                        id="completion_percent_{{ $index }}" name="progress[{{ $index }}][completion_percent]" 
                                                        value="{{ old("progress.{$index}.completion_percent", $progress->completion_percent) }}" required>
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="progress_status_{{ $index }}" class="form-label">Work Status <span class="text-danger">*</span></label>
                                                <select class="form-select" id="progress_status_{{ $index }}" name="progress[{{ $index }}][progress_status]" required>
                                                    <option value="not_started" {{ old("progress.{$index}.progress_status", $progress->progress_status) == 'not_started' ? 'selected' : '' }}>Not Started</option>
                                                    <option value="in_progress" {{ old("progress.{$index}.progress_status", $progress->progress_status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="completed" {{ old("progress.{$index}.progress_status", $progress->progress_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-11">
                                                <label for="progress_description_{{ $index }}" class="form-label">Work Description</label>
                                                <textarea class="form-control" id="progress_description_{{ $index }}" 
                                                    name="progress[{{ $index }}][description]" rows="2">{{ old("progress.{$index}.description", $progress->description) }}</textarea>
                                            </div>
                                            
                                            @if(!$loop->first)
                                                <div class="col-md-1 d-flex align-items-end mb-3">
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-progress">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mb-3">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="addMoreProgress">
                                <i class="bi bi-plus-circle"></i> Add More Progress Items
                            </button>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Bill
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
        let progressCounter = {{ count($bill->progress) }};
        
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
            addRemoveEventListeners();
        });
        
        // Function to add event listeners to remove buttons
        function addRemoveEventListeners() {
            document.querySelectorAll('.remove-progress').forEach(button => {
                button.addEventListener('click', function() {
                    this.closest('.progress-item').remove();
                });
            });
        }
        
        // Add event listeners to existing remove buttons
        addRemoveEventListeners();
    });
</script>
@endsection 