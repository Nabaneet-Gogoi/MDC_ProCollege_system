@extends('rusa.layouts.app')

@section('title', 'Payments')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Payments Monitoring</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <div class="btn-group me-2">
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-file-earmark-excel"></i> Export
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-printer"></i> Print
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Payments</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rusa.payments') }}" method="GET" class="row g-3">
                        <div class="col-md-3">
                            <label for="college" class="form-label">College</label>
                            <select class="form-select" id="college" name="college_id">
                                <option value="">All Colleges</option>
                                @foreach(App\Models\College::orderBy('college_name')->get() as $college)
                                    <option value="{{ $college->college_id }}" {{ request('college_id') == $college->college_id ? 'selected' : '' }}>
                                        {{ $college->college_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processed" {{ request('status') == 'processed' ? 'selected' : '' }}>Processed</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="from_date" class="form-label">From Date</label>
                            <input type="date" class="form-control" id="from_date" name="from_date" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="to_date" class="form-label">To Date</label>
                            <input type="date" class="form-control" id="to_date" name="to_date" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-md-12">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search" name="search" 
                                    placeholder="Search payments..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Search
                                </button>
                                <a href="{{ route('rusa.payments') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Payments List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Payments ({{ $payments->total() }})</h5>
                </div>
                <div class="card-body">
                    @if(isset($payments) && count($payments) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover" id="paymentsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bill</th>
                                        <th>College</th>
                                        <th>Amount (₹ Cr)</th>
                                        <th>Payment Date</th>
                                        <th>Status</th>
                                        <th>Reference</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->bill->bill_no }}</td>
                                            <td>{{ $payment->bill->college->college_name }}</td>
                                            <td>{{ number_format($payment->payment_amt, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                            <td>
                                                @if($payment->payment_status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($payment->payment_status == 'processed')
                                                    <span class="badge bg-primary">Processed</span>
                                                @elseif($payment->payment_status == 'completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif($payment->payment_status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $payment->transaction_reference ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('payments.print', $payment->payment_id) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                    <i class="bi bi-printer"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="d-flex justify-content-center mt-4">
                            {{ $payments->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-credit-card-2-front display-4 text-muted"></i>
                            <p class="lead mt-3">No payments found</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Table search functionality
    document.getElementById('searchTable').addEventListener('keyup', function() {
        const searchTerm = this.value.toLowerCase();
        const table = document.getElementById('paymentsTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const rowText = rows[i].textContent.toLowerCase();
            rows[i].style.display = rowText.includes(searchTerm) ? '' : 'none';
        }
    });
</script>
@endsection 