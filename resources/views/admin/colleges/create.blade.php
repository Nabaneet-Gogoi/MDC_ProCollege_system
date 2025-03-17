@extends('admin.layouts.app')

@section('title', 'Add New College')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Add New College</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.colleges.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Colleges
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-plus-circle me-1"></i> College Information
        </div>
        <div class="card-body">
            <form action="{{ route('admin.colleges.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="college_name" class="form-label">College Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('college_name') is-invalid @enderror" id="college_name" name="college_name" value="{{ old('college_name') }}" required>
                    @error('college_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" id="state" name="state" value="{{ old('state') }}" required>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('district') is-invalid @enderror" id="district" name="district" value="{{ old('district') }}" required>
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
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required onchange="togglePhaseField()">
                                <option value="">Select Type</option>
                                @foreach($typeOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6" id="phaseContainer" style="{{ old('type') === 'professional' ? 'display: none;' : '' }}">
                        <div class="mb-3">
                            <label for="phase" class="form-label">Phase <span class="text-danger">*</span></label>
                            <select class="form-select @error('phase') is-invalid @enderror" id="phase" name="phase" {{ old('type') === 'professional' ? '' : 'required' }}>
                                <option value="">Select Phase</option>
                                @foreach($phaseOptions as $value => $label)
                                    <option value="{{ $value }}" {{ old('phase') == $value ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('phase')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save College
                    </button>
                    <a href="{{ route('admin.colleges.index') }}" class="btn btn-secondary">Cancel</a>
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