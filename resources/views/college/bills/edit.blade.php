@extends('college.layouts.app')

@section('title', 'Edit Bill')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="bi bi-pencil-square me-2 text-primary"></i>Edit Bill #{{ $bill->bill_no }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.show', $bill->bill_id) }}" class="btn btn-sm btn-secondary-gradient transition-hover">
                <i class="bi bi-arrow-left"></i> Back to Bill Details
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
                    <form action="{{ route('college.bills.update', $bill->bill_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <!-- Read-only Information -->
                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Bill Number</label>
                                <input type="text" class="form-control modern-input readonly-field" value="{{ $bill->bill_no }}" readonly>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Bill Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">₹</span>
                                    <input type="text" class="form-control modern-input readonly-field" value="{{ $bill->bill_amt }}" readonly>
                                    <span class="input-group-text">Cr</span>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <label class="form-label fw-medium">Project Funding</label>
                                <input type="text" class="form-control modern-input readonly-field" value="{{ $bill->funding->college->college_name }} - ₹{{ $bill->funding->approved_amt }} Cr" readonly>
                                <input type="hidden" name="funding_id" value="{{ $bill->funding_id }}">
                                <input type="hidden" name="bill_amt" value="{{ $bill->bill_amt }}">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="bill_date" class="form-label fw-medium">Bill Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control modern-input @error('bill_date') is-invalid @enderror" 
                                    id="bill_date" name="bill_date" value="{{ old('bill_date', $bill->bill_date->format('Y-m-d')) }}" required>
                                @error('bill_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-medium">Bill Description</label>
                            <textarea class="form-control modern-input @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="3">{{ old('description', $bill->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bill_image" class="form-label fw-medium">Bill Image</label>
                            @if($bill->bill_image)
                                <div class="mb-2">
                                    <label>Current Image:</label>
                                    <div>
                                        <a href="{{ asset('storage/' . $bill->bill_image) }}" target="_blank" class="img-hover-zoom">
                                            <img src="{{ asset('storage/' . $bill->bill_image) }}" alt="Bill Image" class="img-thumbnail" style="max-height: 100px;">
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <input type="file" class="form-control modern-input @error('bill_image') is-invalid @enderror" 
                                id="bill_image" name="bill_image" accept="image/*">
                            @error('bill_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i> Upload a new image only if you want to replace the existing one.
                            </div>
                        </div>

                        <hr class="my-4">
                        
                        <h5 class="mb-3 section-title"><i class="bi bi-graph-up me-2"></i>Physical Progress Details</h5>
                        
                        <div id="progressContainer">
                            @foreach($bill->progress as $index => $progress)
                                <div class="progress-item modern-card mb-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <input type="hidden" name="progress[{{ $index }}][progress_id]" value="{{ $progress->progress_id }}">
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="category_id_{{ $index }}" class="form-label fw-medium">Work Category <span class="text-danger">*</span></label>
                                                <select class="form-select modern-select category-select" id="category_id_{{ $index }}" name="progress[{{ $index }}][category_id]" required>
                                                    <option value="">-- Select Category --</option>
                                                    @foreach($categories as $id => $name)
                                                        <option value="{{ $id }}" {{ old("progress.{$index}.category_id", $progress->category_id) == $id ? 'selected' : '' }}>
                                                            {{ $name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="completion_percent_{{ $index }}" class="form-label fw-medium">Completion Percentage <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <input type="number" step="0.01" min="0" max="100" class="form-control modern-input" 
                                                        id="completion_percent_{{ $index }}" name="progress[{{ $index }}][completion_percent]" 
                                                        value="{{ old("progress.{$index}.completion_percent", $progress->completion_percent) }}" required>
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-4 mb-3">
                                                <label for="progress_status_{{ $index }}" class="form-label fw-medium">Work Status <span class="text-danger">*</span></label>
                                                <select class="form-select modern-select" id="progress_status_{{ $index }}" name="progress[{{ $index }}][progress_status]" required>
                                                    <option value="not_started" {{ old("progress.{$index}.progress_status", $progress->progress_status) == 'not_started' ? 'selected' : '' }}>Not Started</option>
                                                    <option value="in_progress" {{ old("progress.{$index}.progress_status", $progress->progress_status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="completed" {{ old("progress.{$index}.progress_status", $progress->progress_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-11">
                                                <label for="progress_description_{{ $index }}" class="form-label fw-medium">Work Description</label>
                                                <textarea class="form-control modern-input" id="progress_description_{{ $index }}" 
                                                    name="progress[{{ $index }}][description]" rows="2">{{ old("progress.{$index}.description", $progress->description) }}</textarea>
                                            </div>
                                            
                                            @if(!$loop->first)
                                                <div class="col-md-1 d-flex align-items-end mb-3">
                                                    <button type="button" class="btn btn-sm btn-outline-danger remove-progress transition-hover">
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
                            <button type="button" class="btn btn-sm btn-outline-secondary transition-hover" id="addMoreProgress">
                                <i class="bi bi-plus-circle"></i> Add More Progress Items
                            </button>
                        </div>
                        
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary-gradient">
                                <i class="bi bi-save"></i> Update Bill
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
        
        /* Read-only Fields */
        .readonly-field {
            background-color: #f7f9fc;
            opacity: 0.8;
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
        
        /* Form Label Styling */
        .form-label {
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            color: #4b5563;
        }
        
        /* Image Hover Zoom Effect */
        .img-hover-zoom {
            overflow: hidden;
            transition: transform 0.3s ease;
            display: inline-block;
        }
        
        .img-hover-zoom:hover img {
            transform: scale(1.05);
        }
        
        .img-hover-zoom img {
            transition: transform 0.3s ease;
        }
        
        /* Form spacing improvements */
        .mb-3 {
            margin-bottom: 1.5rem !important;
        }
        
        .mb-4 {
            margin-bottom: 2rem !important;
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
        // Add more progress items
        let progressCounter = {{ count($bill->progress) }};
        
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