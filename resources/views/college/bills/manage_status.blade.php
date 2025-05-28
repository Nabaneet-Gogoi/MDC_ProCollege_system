@extends('college.layouts.app')

@section('title', 'Manage Bill Status')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="bi bi-gear me-2 text-primary"></i>Manage Bill Status</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.bills.index') }}" class="btn btn-sm btn-secondary-gradient transition-hover">
                <i class="bi bi-arrow-left"></i> Back to Bills
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show modern-alert" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show modern-alert" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="modern-card">
        <div class="card-header d-flex align-items-center">
            <i class="bi bi-file-earmark-text me-2 text-primary"></i>
            <span class="fw-bold">Bills Status Management</span>
        </div>
        <div class="card-body">
            @if($bills->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped table-hover modern-table">
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
                                    <td class="fw-medium">{{ $bill->bill_no }}</td>
                                    <td>{{ number_format($bill->bill_amt, 2) }}</td>
                                    <td>{{ $bill->bill_date->format('d-m-Y') }}</td>
                                    <td>
                                        <span class="badge-modern 
                                            @if($bill->bill_status == 'pending') badge-warning
                                            @elseif($bill->bill_status == 'approved') badge-success
                                            @elseif($bill->bill_status == 'rejected') badge-danger
                                            @else badge-info @endif">
                                            {{ ucfirst($bill->bill_status) }}
                                        </span>
                                    </td>
                                    <td>{{ Str::limit($bill->funding->college->college_name, 20) }}</td>
                                    <td>
                                        @php
                                            // Calculate average progress with proper null handling
                                            $avgProgress = $bill->progress->avg('completion_percent') ?? 0;
                                            $avgProgress = max(0, min(100, $avgProgress)); // Ensure between 0-100
                                        @endphp
                                        <div class="progress modern-progress" style="height: 8px;">
                                            <div class="progress-bar bg-success shimmer-animation" role="progressbar" 
                                                 style="width: {{ $avgProgress }}%;" 
                                                 aria-valuenow="{{ $avgProgress }}" 
                                                 aria-valuemin="0" 
                                                 aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted">{{ number_format($avgProgress, 0) }}% Complete</small>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary-gradient transition-hover update-status-btn" 
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
                <div class="text-center py-4 empty-state">
                    <i class="bi bi-file-earmark-x display-4 text-muted"></i>
                    <p class="mt-3">No bills found. Create your first bill to get started.</p>
                    <a href="{{ route('college.bills.create') }}" class="btn btn-primary-gradient transition-hover">Submit New Bill</a>
                </div>
            @endif
        </div>
    </div>

    <!-- Single Modal for Status Update (Outside the table) -->
    <div class="modal fade" id="statusUpdateModal" tabindex="-1" aria-labelledby="statusUpdateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content modern-modal">
                <div class="modal-header modern-modal-header">
                    <h5 class="modal-title" id="statusUpdateModalLabel"><i class="bi bi-gear me-2"></i>Update Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="statusUpdateForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body modern-modal-body">
                        <div class="mb-3">
                            <label for="modalStatus" class="form-label fw-medium">Status</label>
                            <select class="form-select modern-select" id="modalStatus" name="status" required>
                                @foreach(App\Models\Bill::getStatusOptions() as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="modalRemarks" class="form-label fw-medium">Remarks</label>
                            <textarea class="form-control modern-input" id="modalRemarks" name="remarks" rows="3"></textarea>
                            <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Add any comments or details about this status change.</small>
                        </div>
                    </div>
                    <div class="modal-footer modern-modal-footer">
                        <button type="button" class="btn btn-secondary-gradient transition-hover" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary-gradient transition-hover">Update Status</button>
                    </div>
                </form>
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
        
        /* Modern Table */
        .modern-table thead th {
            background: rgba(240,242,245,0.5);
            font-weight: 600;
            font-size: 0.85rem;
            border-bottom: 2px solid rgba(0,0,0,0.05);
            padding: 1rem 1.25rem;
        }
        
        .modern-table tbody td {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            font-size: 0.85rem;
        }
        
        /* Modern Progress Bar */
        .modern-progress {
            background-color: #e5e7eb !important;
            border-radius: 10px !important;
            overflow: hidden !important;
        }
        
        .modern-progress .progress-bar {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%) !important;
            border-radius: 10px !important;
            transition: width 0.6s ease !important;
        }
        
        /* Shimmer Animation */
        .shimmer-animation {
            position: relative;
            overflow: hidden;
        }
        
        .shimmer-animation::after {
            content: '';
            position: absolute;
            top: 0;
            right: -100%;
            bottom: 0;
            left: 0;
            background: linear-gradient(
                90deg, 
                rgba(255,255,255,0) 0%, 
                rgba(255,255,255,0.3) 50%, 
                rgba(255,255,255,0) 100%
            );
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            to {
                transform: translateX(200%);
            }
        }
        
        /* Modern Badges */
        .badge-modern {
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 500;
            border-radius: 30px;
            display: inline-block;
            text-align: center;
        }
        
        .badge-success {
            background: var(--success-gradient);
            color: white;
        }
        
        .badge-warning {
            background: var(--warning-gradient);
            color: white;
        }
        
        .badge-danger {
            background: var(--danger-gradient);
            color: white;
        }
        
        .badge-info {
            background: var(--info-gradient);
            color: white;
        }
        
        /* Button Gradients */
        .btn-primary-gradient {
            background: var(--primary-gradient);
            border: none;
            color: white;
        }
        
        .btn-secondary-gradient {
            background: var(--secondary-gradient);
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
        
        /* Modern Alerts */
        .modern-alert {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        
        /* Empty State */
        .empty-state {
            padding: 2rem;
        }
        
        .empty-state i {
            opacity: 0.5;
            margin-bottom: 1rem;
        }
        
        /* Modern Modal Styling */
        .modern-modal {
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            border: none;
        }
        
        .modern-modal-header {
            background: rgba(240,242,245,0.5);
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.25rem 1.5rem;
            border-radius: 0.75rem 0.75rem 0 0;
        }
        
        .modern-modal-body {
            padding: 1.5rem;
        }
        
        .modern-modal-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(0,0,0,0.05);
            background: rgba(248,250,252,0.5);
            border-radius: 0 0 0.75rem 0.75rem;
        }
        
        /* Modern Form Controls for Modal */
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
        
        /* Form Label Styling */
        .form-label {
            font-size: 0.85rem;
            margin-bottom: 0.5rem;
            color: #4b5563;
        }

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
            border-radius: 0.75rem !important;
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
            modalTitle.innerHTML = `<i class="bi bi-gear me-2"></i>Update Status: ${billNo}`;
            
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