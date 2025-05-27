@extends('admin.layouts.app')

@section('title', 'Manage Admins')

@section('content')
    <style>
        /* Modern Header Design */
        .modern-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            color: white;
            padding: 20px 24px;
            margin-bottom: 24px;
            box-shadow: 0 8px 32px rgba(102, 126, 234, 0.2);
            position: relative;
            overflow: hidden;
        }

        .modern-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.6;
            pointer-events: none;
        }

        .modern-header h1 {
            font-weight: 700;
            font-size: 1.75rem;
            margin: 0;
            z-index: 2;
            position: relative;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .modern-header-subtitle {
            font-size: 0.9rem;
            margin: 4px 0 0 0;
            opacity: 0.9;
            font-weight: 400;
            z-index: 2;
            position: relative;
        }

        .modern-header-toolbar {
            display: flex;
            gap: 12px;
            align-items: center;
            z-index: 2;
            position: relative;
        }

        /* Modern Button Styles */
        .modern-btn {
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            border: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            cursor: pointer;
        }

        .modern-btn-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .modern-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.3);
            color: white;
        }

        .modern-btn-outline {
            background: rgba(255, 255, 255, 0.15);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .modern-btn-outline:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
            color: white;
        }

        .modern-btn-sm {
            padding: 6px 10px;
            font-size: 12px;
            border-radius: 8px;
            min-width: 32px;
            height: 32px;
            justify-content: center;
        }

        /* Modern Alert Styles */
        .modern-alert {
            border-radius: 16px;
            border: none;
            padding: 16px 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            animation: slideInDown 0.5s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modern-alert-success {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .modern-alert-error {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .modern-alert .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Modern Card Styles */
        .modern-card {
            background: #fff;
            border-radius: 20px;
            border: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            margin-bottom: 24px;
        }

        .modern-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .modern-card-header {
            background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
            padding: 16px 24px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
            display: flex;
            align-items: center;
            gap: 12px;
            position: relative;
        }

        .modern-card-header-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 18px;
            flex-shrink: 0;
        }

        .modern-card-title {
            font-size: 16px;
            font-weight: 700;
            color: #2C3E50;
            margin: 0;
            flex: 1;
        }

        .modern-card-header-decoration {
            width: 60px;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 2px;
            position: absolute;
            bottom: 0;
            left: 24px;
        }

        .modern-card-body {
            padding: 24px;
        }

        /* Modern Form Styles */
        .modern-form-control, .modern-form-select {
            border-radius: 12px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            padding: 12px 16px;
            transition: all 0.3s ease;
            font-size: 14px;
            font-weight: 500;
            background: #fff;
        }

        .modern-form-control:focus, .modern-form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
            transform: translateY(-1px);
        }

        .modern-form-label {
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 8px;
            font-size: 14px;
            display: block;
        }

        /* Modern Table Styles */
        .modern-table-container {
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .modern-table {
            width: 100%;
            margin: 0;
            background: white;
        }

        .modern-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .modern-table thead th {
            padding: 16px 20px;
            font-size: 13px;
            font-weight: 700;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: none;
            text-align: left;
        }

        .modern-table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(102, 126, 234, 0.08);
        }

        .modern-table tbody tr:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
            transform: scale(1.005);
        }

        .modern-table tbody tr:last-child {
            border-bottom: none;
        }

        .modern-table tbody td {
            padding: 16px 20px;
            font-size: 14px;
            color: #2C3E50;
            border: none;
            vertical-align: middle;
            font-weight: 500;
        }

        .modern-table-id {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: #667eea;
            background: rgba(102, 126, 234, 0.1);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 12px;
        }

        .modern-table-email {
            color: #2C3E50;
            font-weight: 600;
        }

        .modern-table-phone {
            color: #6C757D;
            font-family: 'Courier New', monospace;
        }

        /* Action Button Group */
        .modern-action-group {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .modern-action-btn {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
        }

        .modern-action-btn-info {
            background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            color: #2C3E50;
        }

        .modern-action-btn-warning {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #8B4513;
        }

        .modern-action-btn-danger {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .modern-action-btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* Empty State */
        .modern-empty-state {
            text-align: center;
            padding: 48px 20px;
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-radius: 20px;
            border: 2px dashed rgba(102, 126, 234, 0.2);
            margin: 20px 0;
        }

        .modern-empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 24px;
            border-radius: 20px;
            background: linear-gradient(135deg, #e9ecff 0%, #f8f9ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #667eea;
            font-size: 32px;
        }

        .modern-empty-title {
            font-size: 20px;
            font-weight: 700;
            color: #2C3E50;
            margin-bottom: 8px;
        }

        .modern-empty-text {
            font-size: 14px;
            color: #6C757D;
            margin-bottom: 24px;
        }

        /* Pagination Styles */
        .pagination {
            gap: 6px;
        }

        .page-link {
            border-radius: 10px;
            border: 1px solid rgba(102, 126, 234, 0.2);
            color: #667eea;
            font-weight: 600;
            padding: 8px 12px;
            transition: all 0.3s ease;
        }

        .page-link:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-color: #667eea;
            transform: translateY(-1px);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
        }



        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 16px;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            opacity: 0.05;
            background-image: radial-gradient(circle, #667eea 2px, transparent 2px);
            background-size: 15px 15px;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-icon-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 24px;
            font-weight: 700;
            color: #2C3E50;
            line-height: 1;
            margin-bottom: 4px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            color: #6C757D;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .modern-header {
                padding: 16px 20px;
            }

            .modern-header h1 {
                font-size: 1.5rem;
            }

            .modern-header-toolbar {
                flex-direction: column;
                gap: 8px;
                align-items: stretch;
            }

            .modern-card-body {
                padding: 20px 16px;
            }

            .modern-table thead th,
            .modern-table tbody td {
                padding: 12px 16px;
                font-size: 13px;
            }

            .stats-container {
                grid-template-columns: 1fr;
            }

            .modern-action-group {
                flex-direction: column;
                gap: 4px;
            }
        }
    </style>

    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h1>Admin Management</h1>
                <div class="modern-header-subtitle">Manage administrator accounts and permissions</div>
            </div>
            <div class="modern-header-toolbar">
                <a href="{{ route('admin.admins.create') }}" class="modern-btn modern-btn-primary">
                    <i class="bi bi-plus-circle"></i> Add New Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="modern-alert modern-alert-success" role="alert">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <div>
                <strong>Success!</strong> {{ session('success') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="modern-alert modern-alert-error" role="alert">
            <i class="bi bi-exclamation-triangle-fill fs-5"></i>
            <div>
                <strong>Error!</strong> {{ session('error') }}
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-icon stat-icon-primary">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-content">
                <div class="stat-number">{{ $admins->total() }}</div>
                <div class="stat-label">Total Admins</div>
            </div>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <div class="modern-card-header-icon">
                <i class="bi bi-funnel"></i>
            </div>
            <div class="modern-card-title">
                Filter & Search Admins
                @if(request('email') || request('phone_no'))
                    <span class="badge bg-primary ms-2">{{ (request('email') ? 1 : 0) + (request('phone_no') ? 1 : 0) }} filter(s) active</span>
                @endif
            </div>
            <div class="modern-card-header-decoration"></div>
        </div>
        <div class="modern-card-body">
            <form action="{{ route('admin.admins.index') }}" method="GET">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="modern-form-label">
                            <i class="bi bi-envelope me-2"></i>Email Address
                        </label>
                        <input type="text" class="modern-form-control" id="email" name="email" 
                               value="{{ request('email') }}" placeholder="Search by email address">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone_no" class="modern-form-label">
                            <i class="bi bi-telephone me-2"></i>Phone Number
                        </label>
                        <input type="text" class="modern-form-control" id="phone_no" name="phone_no" 
                               value="{{ request('phone_no') }}" placeholder="Search by phone number">
                    </div>
                </div>
                
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.admins.index') }}" class="modern-btn modern-btn-outline">
                        <i class="bi bi-x-circle"></i> Clear Filters
                    </a>
                    <button type="submit" class="modern-btn modern-btn-primary">
                        <i class="bi bi-search"></i> Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Admins Table Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <div class="modern-card-header-icon">
                <i class="bi bi-people"></i>
            </div>
            <div class="modern-card-title">Administrator Accounts</div>
            <div class="modern-card-header-decoration"></div>
        </div>
        <div class="modern-card-body p-0">
            @if($admins->count() > 0)
                <div class="modern-table-container">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Admin ID</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <td>
                                        <span class="modern-table-id">{{ $admin->admin_id }}</span>
                                    </td>
                                    <td>
                                        <div class="modern-table-email">{{ $admin->email }}</div>
                                    </td>
                                    <td>
                                        <div class="modern-table-phone">{{ $admin->phone_no }}</div>
                                    </td>
                                    <td>
                                        <div class="modern-action-group">
                                            <a href="{{ route('admin.admins.show', $admin->admin_id) }}" 
                                               class="modern-action-btn modern-action-btn-info" 
                                               title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.admins.edit', $admin->admin_id) }}" 
                                               class="modern-action-btn modern-action-btn-warning" 
                                               title="Edit Admin">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form action="{{ route('admin.admins.destroy', $admin->admin_id) }}" 
                                                  method="POST" class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this admin account?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="modern-action-btn modern-action-btn-danger" 
                                                        title="Delete Admin">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="modern-empty-state">
                    <div class="modern-empty-icon">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="modern-empty-title">No Administrators Found</div>
                    <div class="modern-empty-text">
                        No admin accounts match your current search criteria. Try adjusting your filters or create a new admin account.
                    </div>
                    <a href="{{ route('admin.admins.create') }}" class="modern-btn modern-btn-primary">
                        <i class="bi bi-plus-circle"></i> Create First Admin
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($admins->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $admins->withQueryString()->links() }}
        </div>
    @endif

    <!-- JavaScript for Enhanced Interactions -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-dismiss alerts
            const alerts = document.querySelectorAll('.modern-alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 5000);
            });

            // Add loading state to action buttons
            const actionForms = document.querySelectorAll('form[method="POST"]');
            actionForms.forEach(form => {
                form.addEventListener('submit', function() {
                    const button = form.querySelector('button[type="submit"]');
                    if (button) {
                        button.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i>';
                        button.disabled = true;
                    }
                });
            });
        });

        // Add spin animation for loading
        const style = document.createElement('style');
        style.textContent = `
            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            .spin {
                animation: spin 1s linear infinite;
            }
             `;
     document.head.appendChild(style);
     </script>
@endsection 