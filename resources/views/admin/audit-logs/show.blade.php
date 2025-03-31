@extends('admin.layouts.app')

@section('title', 'View Audit Log')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">View Audit Log #{{ $auditLog->id }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-sm btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Audit Logs
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <i class="bi bi-info-circle me-1"></i> Audit Log Details
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-muted" style="width: 120px;">ID:</th>
                            <td>{{ $auditLog->id }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">Admin:</th>
                            <td>
                                @if($auditLog->admin)
                                    {{ $auditLog->admin->name ?? $auditLog->admin->email }}
                                @else
                                    <span class="text-muted">System</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Action:</th>
                            <td>
                                <span class="badge 
                                    {{ $auditLog->action == 'create' ? 'bg-success' : '' }}
                                    {{ $auditLog->action == 'update' ? 'bg-primary' : '' }}
                                    {{ $auditLog->action == 'delete' ? 'bg-danger' : '' }}
                                    {{ !in_array($auditLog->action, ['create', 'update', 'delete']) ? 'bg-info' : '' }}
                                ">
                                    {{ ucfirst($auditLog->action) }}
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-muted" style="width: 120px;">Model:</th>
                            <td>
                                {{ class_basename($auditLog->model_type) }}
                                @if($auditLog->model_id)
                                    #{{ $auditLog->model_id }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">Date/Time:</th>
                            <td>{{ $auditLog->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">IP Address:</th>
                            <td>{{ $auditLog->ip_address ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <hr>
            
            <div class="row mb-3">
                <div class="col-12">
                    <h5>Description</h5>
                    <p>{{ $auditLog->description }}</p>
                </div>
            </div>

            <div class="row">
                @if($auditLog->old_values)
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-header">
                                <i class="bi bi-arrow-left-circle me-1"></i> Old Values
                            </div>
                            <div class="card-body">
                                <pre class="mb-0" style="max-height: 400px; overflow-y: auto;">{{ json_encode($auditLog->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    </div>
                @endif
                
                @if($auditLog->new_values)
                    <div class="col-md-6">
                        <div class="card bg-light">
                            <div class="card-header">
                                <i class="bi bi-arrow-right-circle me-1"></i> New Values
                            </div>
                            <div class="card-body">
                                <pre class="mb-0" style="max-height: 400px; overflow-y: auto;">{{ json_encode($auditLog->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection 