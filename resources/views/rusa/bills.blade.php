@extends('rusa.layouts.app')

@section('title', 'Bills')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Bills Monitoring</h1>
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
                    <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Bills</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rusa.bills') }}" method="GET" class="row g-3">
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
                                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
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
                                    placeholder="Search bills..." value="{{ request('search') }}">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-search"></i> Search
                                </button>
                                <a href="{{ route('rusa.bills') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bills List -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-receipt me-2"></i>Bills ({{ $bills->total() }})</h5>
                </div>
                <div class="card-body">
                    @if(isset($bills) && count($bills) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Bill No</th>
                                        <th>College</th>
                                        <th>Amount (₹ Cr)</th>
                                        <th>Bill Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bills as $bill)
                                        <tr>
                                            <td>{{ $bill->bill_no }}</td>
                                            <td>{{ $bill->college->college_name }}</td>
                                            <td>{{ number_format($bill->bill_amt, 2) }}</td>
                                            <td>{{ \Carbon\Carbon::parse($bill->bill_date)->format('d M Y') }}</td>
                                            <td>
                                                @if($bill->bill_status == 'pending')
                                                    <span class="badge bg-warning text-dark">Pending</span>
                                                @elseif($bill->bill_status == 'approved')
                                                    <span class="badge bg-success">Approved</span>
                                                @elseif($bill->bill_status == 'rejected')
                                                    <span class="badge bg-danger">Rejected</span>
                                                @elseif($bill->bill_status == 'paid')
                                                    <span class="badge bg-info">Paid</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('bills.print', $bill->bill_id) }}" class="btn btn-sm btn-outline-secondary" target="_blank">
                                                    <i class="bi bi-printer"></i>
                                                </a>
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
                            <i class="bi bi-receipt display-4 text-muted"></i>
                            <p class="lead mt-3">No bills found</p>
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
        const table = document.getElementById('billsTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const rowText = rows[i].textContent.toLowerCase();
            rows[i].style.display = rowText.includes(searchTerm) ? '' : 'none';
        }
    });
</script>
@endsection 