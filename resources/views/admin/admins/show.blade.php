@extends('admin.layouts.app')

@section('title', 'View Admin')

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

        .modern-btn-secondary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .modern-btn-secondary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .modern-btn-warning {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #8B4513;
        }

        .modern-btn-warning:hover {
            background: linear-gradient(135deg, #fdd835 0%, #fb8c00 100%);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 6px 20px rgba(255, 183, 77, 0.3);
        }

        .modern-btn-danger {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }

        .modern-btn-danger:hover {
            background: linear-gradient(135deg, #f06292 0%, #ffeb3b 100%);
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 6px 20px rgba(240, 98, 146, 0.3);
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

        /* Modern Information Display */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 24px;
        }

        .info-item {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-radius: 12px;
            padding: 16px 20px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .info-item:hover {
            background: linear-gradient(135deg, #e9ecff 0%, #f8f9ff 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.1);
        }

        .info-icon {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 16px;
            flex-shrink: 0;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 12px;
            font-weight: 600;
            color: #6C757D;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 14px;
            font-weight: 600;
            color: #2C3E50;
            word-break: break-all;
        }

        /* Profile Card */
        .profile-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 20px;
            padding: 32px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .profile-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle at 30% 30%, rgba(255,255,255,0.15) 1px, transparent 1px);
            background-size: 15px 15px;
            opacity: 0.5;
            pointer-events: none;
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            background: rgba(255, 255, 255, 0.3);
        }

        .profile-avatar i {
            font-size: 3rem;
            color: white;
        }

        .profile-name {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 6px;
            z-index: 2;
            position: relative;
        }

        .profile-role {
            font-size: 14px;
            opacity: 0.9;
            font-weight: 500;
            z-index: 2;
            position: relative;
        }

        /* Action Section */
        .action-section {
            background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            margin-top: 24px;
        }

        .action-grid {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        /* Modern Alert */
        .modern-alert {
            border-radius: 12px;
            border: none;
            padding: 12px 16px;
            margin-top: 16px;
            box-shadow: 0 3px 16px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modern-alert-warning {
            background: linear-gradient(135deg, #ffecd2 0%, #fcb69f 100%);
            color: #8B4513;
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

            .info-grid {
                grid-template-columns: 1fr;
            }

            .action-grid {
                flex-direction: column;
            }

            .profile-card {
                padding: 24px 16px;
            }
        }
    </style>

    <!-- Modern Header -->
    <div class="modern-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h1>Admin Details</h1>
                <div class="modern-header-subtitle">View administrator account information</div>
            </div>
            <div class="modern-header-toolbar">
                <a href="{{ route('admin.admins.index') }}" class="modern-btn modern-btn-outline">
                    <i class="bi bi-arrow-left"></i> Back to Admins
                </a>
                <a href="{{ route('admin.admins.edit', $admin->admin_id) }}" class="modern-btn modern-btn-warning">
                    <i class="bi bi-pencil"></i> Edit Admin
                </a>
            </div>
        </div>
    </div>

    <!-- Admin Information Card -->
    <div class="modern-card">
        <div class="modern-card-header">
            <div class="modern-card-header-icon">
                <i class="bi bi-person"></i>
            </div>
            <div class="modern-card-title">Administrator Information</div>
            <div class="modern-card-header-decoration"></div>
        </div>
        <div class="modern-card-body">
            <div class="info-grid">
                <!-- Admin Details -->
                <div>
                    <div class="info-item mb-3">
                        <div class="info-icon">
                            <i class="bi bi-hash"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Admin ID</div>
                            <div class="info-value">{{ $admin->admin_id }}</div>
                        </div>
                    </div>
                    
                    <div class="info-item mb-3">
                        <div class="info-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $admin->email }}</div>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Phone Number</div>
                            <div class="info-value">{{ $admin->phone_no }}</div>
                        </div>
                    </div>
                </div>

                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="profile-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <div class="profile-name">{{ $admin->email }}</div>
                    <div class="profile-role">System Administrator</div>
                </div>
            </div>
            
            <!-- Actions Section -->
            <div class="action-section">
                <div class="action-grid">
                    <a href="{{ route('admin.admins.edit', $admin->admin_id) }}" class="modern-btn modern-btn-primary">
                        <i class="bi bi-pencil"></i> Edit Admin
                    </a>
                    <form action="{{ route('admin.admins.destroy', $admin->admin_id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this admin account?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="modern-btn modern-btn-danger" {{ auth()->guard('admin')->user()->admin_id === $admin->admin_id ? 'disabled' : '' }}>
                            <i class="bi bi-trash"></i> Delete Admin
                        </button>
                    </form>
                </div>
                
                @if(auth()->guard('admin')->user()->admin_id === $admin->admin_id)
                    <div class="modern-alert modern-alert-warning">
                        <i class="bi bi-exclamation-triangle-fill"></i> 
                        <span>You cannot delete your own account while logged in.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection 