@extends('admin.layouts.app')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Funding Allocation</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.fundings.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <i class="bi bi-currency-dollar me-1"></i> Edit Funding for {{ $funding->college->college_name }}
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

            <form action="{{ route('admin.fundings.update', $funding->funding_id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card bg-light mb-3">
                    <div class="card-header">College Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <p><strong>College:</strong> {{ $funding->college->college_name }}</p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Type:</strong> 
                                    @if($funding->college->type === 'professional')
                                        Professional College
                                    @else
                                        Model Degree College (MDC)
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <p><strong>Phase:</strong> Phase {{ $funding->college->phase }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="approved_amt" class="form-label">Approved Amount (Cr) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('approved_amt') is-invalid @enderror" id="approved_amt" name="approved_amt" value="{{ old('approved_amt', $funding->approved_amt) }}" required>
                        @error('approved_amt')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="central_share" class="form-label">Central Share (Cr) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('central_share') is-invalid @enderror" id="central_share" name="central_share" value="{{ old('central_share', $funding->central_share) }}" required>
                        @error('central_share')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="state_share" class="form-label">State Share (Cr) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('state_share') is-invalid @enderror" id="state_share" name="state_share" value="{{ old('state_share', $funding->state_share) }}" required>
                        @error('state_share')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="utilization_status" class="form-label">Utilization Status <span class="text-danger">*</span></label>
                    <select class="form-select @error('utilization_status') is-invalid @enderror" id="utilization_status" name="utilization_status" required>
                        <option value="not_started" {{ old('utilization_status', $funding->utilization_status) == 'not_started' ? 'selected' : '' }}>Not Started</option>
                        <option value="in_progress" {{ old('utilization_status', $funding->utilization_status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ old('utilization_status', $funding->utilization_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    @error('utilization_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" id="recalculateBtn" class="btn btn-info me-md-2">
                        <i class="bi bi-calculator"></i> Reset to Standard Values
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Update Funding
                    </button>
                </div>
            </form>
        </div>
    </div>
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
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while calculating funding. Please try again.');
            });
        });
    });
</script>
@endsection 