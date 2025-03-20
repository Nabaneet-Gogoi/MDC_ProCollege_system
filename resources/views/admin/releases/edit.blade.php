@extends('admin.layouts.app')

@section('title', 'Edit Fund Release')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mt-4">Edit Fund Release</h1>
        <div>
            <a href="{{ route('admin.releases.show', $release->release_id) }}" class="btn btn-info me-2">
                <i class="bi bi-eye"></i> View Details
            </a>
            <a href="{{ route('admin.releases.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Releases
            </a>
        </div>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.releases.update', $release->release_id) }}" method="POST" id="releaseForm">
                @csrf
                @method('PUT')
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="funding_id" class="form-label">Select Funding</label>
                        <select name="funding_id" id="funding_id" class="form-select" required>
                            <option value="">Select a funding</option>
                            @foreach($fundings as $funding)
                                <option value="{{ $funding->funding_id }}" 
                                        data-college="{{ $funding->college->name }}"
                                        {{ (old('funding_id', $release->funding_id) == $funding->funding_id) ? 'selected' : '' }}>
                                    {{ $funding->college->name }} - ₹{{ number_format($funding->approved_amt, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h5 class="card-title">Funding Details</h5>
                                <div id="fundingDetails">
                                    <p class="mb-1">College: <span id="collegeName">-</span></p>
                                    <p class="mb-1">Approved Amount: <span id="approvedAmount">-</span></p>
                                    <p class="mb-1">Total Released: <span id="totalReleased">-</span></p>
                                    <p class="mb-1">Remaining Balance: <span id="remainingBalance">-</span></p>
                                    <p class="mb-0">Utilization: <span id="utilizationPercentage">-</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="release_amt" class="form-label">Release Amount</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" step="0.01" class="form-control" id="release_amt" 
                                   name="release_amt" value="{{ old('release_amt', $release->release_amt) }}" 
                                   required>
                        </div>
                        <div class="form-text text-muted">
                            Current Release Amount: ₹{{ number_format($release->release_amt, 2) }}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="release_date" class="form-label">Release Date</label>
                        <input type="date" class="form-control" id="release_date" 
                               name="release_date" value="{{ old('release_date', $release->release_date->format('Y-m-d')) }}" 
                               required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="desc" class="form-label">Description</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3" 
                              required>{{ old('desc', $release->desc) }}</textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Update Release
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
        })
        .catch(error => {
            console.error('Error fetching funding details:', error);
            alert('Error loading funding details. Please try again or select a different funding.');
        });
    }

    // Event listener for funding selection change
    fundingSelect.addEventListener('change', function() {
        updateFundingDetails(this.value);
    });

    // Initialize funding details
    updateFundingDetails(fundingSelect.value);

    // Form validation
    document.getElementById('releaseForm').addEventListener('submit', function(e) {
        const releaseAmt = parseFloat(releaseAmtInput.value);
        const maxAmount = parseFloat(releaseAmtInput.max);

        if (releaseAmt > maxAmount) {
            e.preventDefault();
            alert('Release amount cannot exceed the adjusted remaining balance of ' + formatCurrency(maxAmount));
        }
    });
});
</script>
@endpush 