@extends('college.layouts.app')

@section('title', 'College Profile')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">College Profile</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('college.dashboard') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <!-- College Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="bi bi-building me-1"></i>
                        College Information
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">College Name:</div>
                        <div class="col-md-8 fw-bold">{{ $college->college_name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">College Type:</div>
                        <div class="col-md-8">
                            <span class="badge bg-primary">{{ $typeOptions[$college->type] ?? $college->type }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Phase:</div>
                        <div class="col-md-8">
                            @if($college->type === 'MDC')
                                <span class="badge bg-info">{{ $phaseOptions[$college->phase] ?? $college->phase }}</span>
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">State:</div>
                        <div class="col-md-8">{{ $college->state }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">District:</div>
                        <div class="col-md-8">{{ $college->district }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted">Created:</div>
                        <div class="col-md-8">{{ $college->created_at ? $college->created_at->format('F d, Y') : 'Not available' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Funding Information Card -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-cash-coin me-1"></i>
                    Funding Details
                </div>
                <div class="card-body">
                    @if($fundingInfo)
                        <div class="row mb-3">
                            <div class="col-md-5 text-muted">Total Approved:</div>
                            <div class="col-md-7 fw-bold">₹{{ $fundingInfo->approved_amt }} Cr</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5 text-muted">Central Share:</div>
                            <div class="col-md-7">₹{{ $fundingInfo->central_share }} Cr</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5 text-muted">State Share:</div>
                            <div class="col-md-7">₹{{ $fundingInfo->state_share }} Cr</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5 text-muted">Total Released:</div>
                            <div class="col-md-7">₹{{ $releasedAmount }} Cr</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5 text-muted">Release Status:</div>
                            <div class="col-md-7">
                                @php
                                    $releasePercent = 0;
                                    if($fundingInfo->approved_amt > 0) {
                                        $releasePercent = round(($releasedAmount / $fundingInfo->approved_amt) * 100, 2);
                                    }
                                @endphp
                                <div class="progress" style="height: 15px;">
                                    <div class="progress-bar bg-success" role="progressbar" 
                                         style="width: {{ $releasePercent }}%;" 
                                         aria-valuenow="{{ $releasePercent }}" 
                                         aria-valuemin="0" 
                                         aria-valuemax="100">
                                        {{ $releasePercent }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-5 text-muted">Utilization Status:</div>
                            <div class="col-md-7">
                                @if($fundingInfo->utilization_status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif($fundingInfo->utilization_status === 'in_progress')
                                    <span class="badge bg-primary">In Progress</span>
                                @else
                                    <span class="badge bg-warning">Not Started</span>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No funding information available for this college.
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- College Users Card -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <i class="bi bi-people me-1"></i>
                    College Users
                </div>
                <div class="card-body">
                    @if($college->users->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Last Login</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($college->users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($user->role) }}</span>
                                            </td>
                                            <td>{{ $user->last_login_at ? $user->last_login_at->format('M d, Y h:i A') : 'Never' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info">
                            No users are associated with this college yet.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('college.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit College Profile</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="college_name" class="form-label">College Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('college_name') is-invalid @enderror" 
                                id="college_name" name="college_name" value="{{ old('college_name', $college->college_name) }}" required>
                            @error('college_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                id="state" name="state" value="{{ old('state', $college->state) }}" required>
                            @error('state')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="district" class="form-label">District <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('district') is-invalid @enderror" 
                                id="district" name="district" value="{{ old('district', $college->district) }}" required>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <p class="text-muted mb-0">
                                <strong>Note:</strong> College type and phase cannot be changed. If you need to modify these details, please contact the administrator.
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection 