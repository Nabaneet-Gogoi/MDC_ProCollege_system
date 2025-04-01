@extends('admin.layouts.app')

@section('title', 'View Audit Log')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Audit Log Details</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('admin.audit-logs.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Logs
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <i class="bi bi-info-circle me-1"></i> Basic Information
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px;">Log ID:</th>
                            <td>{{ $auditLog->id }}</td>
                        </tr>
                        <tr>
                            <th>Admin:</th>
                            <td>
                                @if($auditLog->admin)
                                    {{ $auditLog->admin->name ?? $auditLog->admin->email }}
                                @else
                                    <span class="text-muted">System</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Action:</th>
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
                            <th style="width: 150px;">Model Type:</th>
                            <td>{{ class_basename($auditLog->model_type) }}</td>
                        </tr>
                        <tr>
                            <th>Model ID:</th>
                            <td>{{ $auditLog->model_id ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Date & Time:</th>
                            <td>{{ $auditLog->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-light">
            <i class="bi bi-file-text me-1"></i> Description
        </div>
        <div class="card-body">
            <p>{{ $auditLog->description }}</p>
        </div>
    </div>

    @if($auditLog->properties && count($auditLog->properties) > 0)
        <div class="card mb-4">
            <div class="card-header bg-light">
                <i class="bi bi-list-columns me-1"></i> Changed Properties
            </div>
            <div class="card-body">
                @if(isset($auditLog->properties['old']) && isset($auditLog->properties['attributes']))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Field</th>
                                    <th>Old Value</th>
                                    <th>New Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auditLog->properties['attributes'] as $key => $value)
                                    @if(array_key_exists($key, $auditLog->properties['old']) || $auditLog->action == 'create')
                                        <tr>
                                            <td>{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                            <td>
                                                @if($auditLog->action == 'create')
                                                    <span class="text-muted">N/A</span>
                                                @else
                                                    {{ $auditLog->properties['old'][$key] ?? '' }}
                                                @endif
                                            </td>
                                            <td>{{ $value }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @elseif($auditLog->action == 'delete' && isset($auditLog->properties['old']))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Field</th>
                                    <th>Deleted Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($auditLog->properties['old'] as $key => $value)
                                    <tr>
                                        <td>{{ ucwords(str_replace('_', ' ', $key)) }}</td>
                                        <td>{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <pre class="bg-light p-3 rounded">{{ json_encode($auditLog->properties, JSON_PRETTY_PRINT) }}</pre>
                @endif
            </div>
        </div>
    @endif

    @if(isset($auditLog->ip_address) || isset($auditLog->user_agent))
        <div class="card mb-4">
            <div class="card-header bg-light">
                <i class="bi bi-hdd-network me-1"></i> Request Information
            </div>
            <div class="card-body">
                <div class="row">
                    @if(isset($auditLog->ip_address))
                        <div class="col-md-6">
                            <p><strong>IP Address:</strong> {{ $auditLog->ip_address }}</p>
                        </div>
                    @endif
                    
                    @if(isset($auditLog->user_agent))
                        <div class="col-md-6">
                            <p><strong>User Agent:</strong> {{ $auditLog->user_agent }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection 