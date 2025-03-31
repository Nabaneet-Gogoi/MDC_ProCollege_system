@extends('admin.layouts.app')

@section('title', 'Audit Logs')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Audit Logs</h1>
    </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <i class="bi bi-funnel-fill me-1"></i> Filter Logs
        </div>
        <div class="card-body">
            <form action="{{ route('admin.audit-logs.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="admin_id" class="form-label">Admin</label>
                    <select class="form-select" id="admin_id" name="admin_id">
                        <option value="">All Admins</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->admin_id }}" {{ request('admin_id') == $admin->admin_id ? 'selected' : '' }}>
                                {{ $admin->name ?? $admin->email }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="action" class="form-label">Action</label>
                    <select class="form-select" id="action" name="action">
                        <option value="">All Actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                {{ ucfirst($action) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="model_type" class="form-label">Model Type</label>
                    <input type="text" class="form-control" id="model_type" name="model_type" value="{{ request('model_type') }}" placeholder="e.g. College, User">
                </div>
                
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Date From</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Date To</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                
                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-search me-1"></i> Filter
                    </button>
                    <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i> Clear Filters
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Audit Logs Table -->
    <div class="card">
        <div class="card-header bg-light">
            <i class="bi bi-list-check me-1"></i> Audit Log Entries
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Admin</th>
                            <th>Action</th>
                            <th>Model</th>
                            <th>Description</th>
                            <th>Date & Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($auditLogs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>
                                    @if($log->admin)
                                        {{ $log->admin->name ?? $log->admin->email }}
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge 
                                        {{ $log->action == 'create' ? 'bg-success' : '' }}
                                        {{ $log->action == 'update' ? 'bg-primary' : '' }}
                                        {{ $log->action == 'delete' ? 'bg-danger' : '' }}
                                        {{ !in_array($log->action, ['create', 'update', 'delete']) ? 'bg-info' : '' }}
                                    ">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td>
                                    {{ class_basename($log->model_type) }} 
                                    @if($log->model_id)
                                        #{{ $log->model_id }}
                                    @endif
                                </td>
                                <td>{{ Str::limit($log->description, 50) }}</td>
                                <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                                <td>
                                    <a href="{{ route('admin.audit-logs.show', $log) }}" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No audit logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $auditLogs->links() }}
            </div>
        </div>
    </div>
@endsection 