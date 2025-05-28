@extends('college.layouts.app')

@section('title', 'Manage Bill Status')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manage Bill Status</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Bills
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <i class="bi bi-file-earmark-text me-1"></i>
            Bills Status Management
        </div>
        <div class="card-body">
            @if($bills->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Bill Number</th>
                                <th>Amount (₹ Cr)</th>
                                <th>Date</th>
                                <th>Current Status</th>
                                <th>Project</th>
                                <th>Physical Progress</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bills as $bill)
                                <tr>
                                    <td>{{ $bill->bill_no }}</td>
                                    <td>{{ number_format($bill->bill_amt, 2) }}</td>
                                    <td>{{ $bill->bill_date->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($bill->bill_status == 'pending') bg-warning
                                            @elseif($bill->bill_status == 'approved') bg-success
                                            @elseif($bill->bill_status == 'rejected') bg-danger
                                            @else bg-primary @endif">
                                            {{ ucfirst($bill->bill_status) }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($bill->funding->college->college_name, 20) }}</td>
                                    <td>
                                        @php
                                            // Calculate average progress
                                            $avgProgress = $bill->progress->avg('completion_percent');
                                        @endphp
                                        <div class="progress" style="height: 5px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{ $avgProgress }}%;" 
                                                aria-valuenow="{{ $avgProgress }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small>{{ number_format($avgProgress, 0) }}% Complete</small>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary update-status-btn" 
                                                data-bill-id="{{ $bill->bill_id }}"
                                                data-bill-no="{{ $bill->bill_no }}"
                                                data-bill-status="{{ $bill->bill_status }}"
                                                data-bill-remarks="{{ $bill->college_remarks }}">
                                            <i class="bi bi-pencil-square"></i> Update Status
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="d-flex justify-content-center mt-4">
                    {{ $bills->links() }}
                </div>
            @else
                <div class="text-center py-4">
                    <i class="bi bi-file-earmark-x display-4 text-muted"></i>
                    <p class="mt-3">No bills found. Create your first bill to get started.</p>
                    <a href="{{ route('college.bills.create') }}" class="btn btn-primary">Submit New Bill</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Single Modal for Status Update (Outside the table) -->
    <div class="modal fade" id="statusUpdateModal" tabindex="-1" aria-labelledby="statusUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusUpdateModalLabel">Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="statusUpdateForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="modalStatus" class="form-label">Status</label>
                            <select class="form-select" id="modalStatus" name="status" required>
                                @foreach(App\Models\Bill::getStatusOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modalRemarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="modalRemarks" name="remarks" rows="3"></textarea>
                            <small class="text-muted">Add any comments or details about this status change.</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 

@section('styles')
<style>
/* Fix modal z-index and backdrop issues */
.modal {
    z-index: 1055 !important;
}

.modal-backdrop {
    z-index: 1054 !important;
}

/* Ensure modal content is clickable */
.modal-dialog {
    z-index: 1056 !important;
    position: relative;
}

.modal-content {
    background-color: #fff !important;
    border: 1px solid rgba(0,0,0,.2) !important;
    border-radius: 0.375rem !important;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    pointer-events: auto !important;
}

/* Ensure all modal elements are clickable */
.modal-header,
.modal-body,
.modal-footer {
    pointer-events: auto !important;
}

/* Fix button clickability */
.modal .btn {
    pointer-events: auto !important;
    z-index: 1 !important;
    position: relative !important;
}

.modal .btn-close {
    pointer-events: auto !important;
    z-index: 1 !important;
}

.modal .form-control,
.modal .form-select {
    pointer-events: auto !important;
    z-index: 1 !important;
}

/* Override any conflicting sidebar styles */
.sidebar {
    z-index: 100 !important;
}

/* Make sure modal appears above sidebar */
@media (max-width: 768px) {
    .modal {
        z-index: 1055 !important;
    }
    
    .modal-backdrop {
        z-index: 1054 !important;
    }
}
</style>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, setting up modal functionality');
    
    // Get modal elements
    const modal = document.getElementById('statusUpdateModal');
    const form = document.getElementById('statusUpdateForm');
    const modalTitle = document.getElementById('statusUpdateModalLabel');
    const statusSelect = document.getElementById('modalStatus');
    const remarksTextarea = document.getElementById('modalRemarks');
    
    if (!modal || !form) {
        console.error('Modal or form not found');
        return;
    }
    
    // Initialize Bootstrap modal
    const bsModal = new bootstrap.Modal(modal);
    
    // Add click event listeners to update status buttons
    document.querySelectorAll('.update-status-btn').forEach(function(button) {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Update status button clicked');
            
            // Get data from button attributes
            const billId = this.dataset.billId;
            const billNo = this.dataset.billNo;
            const billStatus = this.dataset.billStatus;
            const billRemarks = this.dataset.billRemarks || '';
            
            console.log('Bill data:', { billId, billNo, billStatus, billRemarks });
            
            // Update modal title
            modalTitle.textContent = `Update Status: ${billNo}`;
            
            // Set form action
            form.action = `/college/bills-status/${billId}`;
            
            // Set current values
            statusSelect.value = billStatus;
            remarksTextarea.value = billRemarks;
            
            // Show modal
            bsModal.show();
        });
    });
    
    // Ensure modal is working
    modal.addEventListener('show.bs.modal', function (event) {
        console.log('Modal is showing');
        event.target.style.pointerEvents = 'auto';
    });
    
    modal.addEventListener('shown.bs.modal', function (event) {
        console.log('Modal is shown');
        // Focus on the status select
        statusSelect.focus();
    });
    
    modal.addEventListener('hidden.bs.modal', function (event) {
        console.log('Modal is hidden');
        // Clean up
        form.reset();
    });
    
    // Debug: Log when any modal-related element is clicked
    document.addEventListener('click', function(e) {
        if (e.target.closest('.modal') || e.target.matches('[data-bs-toggle="modal"]')) {
            console.log('Modal-related element clicked:', e.target);
        }
    });
});
</script>
@endsection 