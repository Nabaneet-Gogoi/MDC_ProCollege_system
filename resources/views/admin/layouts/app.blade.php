<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard') - MDC ProCollege System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 60px;
        }
        .sidebar {
            position: fixed;
            top: 60px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            width: 240px;
            transition: all 0.3s ease-in-out;
            box-shadow: 4px 0 20px rgba(102, 126, 234, 0.15);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 20%, rgba(255,255,255,0.1) 1px, transparent 1px);
            background-size: 30px 30px;
            opacity: 0.3;
            pointer-events: none;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 60px);
            padding-top: 1rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            font-weight: 600;
            color: rgba(255, 255, 255, 0.9);
            padding: 14px 20px;
            margin: 6px 12px;
            border-radius: 12px;
            transition: all 0.3s ease;
            position: relative;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(4px);
            color: white;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25) 0%, rgba(255, 255, 255, 0.15) 100%);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            transform: translateX(4px);
        }
        .sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: -1px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: linear-gradient(180deg, #ffffff 0%, rgba(255, 255, 255, 0.8) 100%);
            border-radius: 0 2px 2px 0;
        }
        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover i {
            transform: scale(1.1);
        }
        
        /* Sidebar scrollbar styling */
        .sidebar-sticky::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-sticky::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 3px;
        }
        .sidebar-sticky::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
            transition: background 0.3s ease;
        }
        .sidebar-sticky::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
        .navbar {
            box-shadow: 0 .15rem 1.75rem 0 rgba(58, 59, 69, .15);
            background-color: #fff;
            padding: 0;
            height: 60px;
        }
        .navbar .container-fluid {
            padding-left: 0;
        }
        .navbar-brand {
            padding: 15px;
            font-size: 1rem;
            font-weight: 800;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            margin-right: 1rem;
            height: 60px;
            display: flex;
            align-items: center;
            width: 240px;
            justify-content: center;
            text-align: center;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }
        .navbar-brand::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 80% 20%, rgba(255,255,255,0.15) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.5;
        }
        .navbar-brand:hover {
            color: #fff;
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }
        .content {
            padding: 20px;
            min-height: calc(100vh - 60px);
            transition: margin 0.3s ease-in-out;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            font-weight: 700;
            color: #4e73df;
        }
        /* Add a backdrop for the sidebar on mobile */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }
        @media (min-width: 769px) {
            .content {
                margin-left: 240px; /* Match sidebar width */
            }
            .col-lg-2 {
                width: 240px; /* Ensure sidebar column width is consistent */
            }
            #sidebar {
                display: block !important; /* Always show sidebar on larger screens */
            }
        }
        /* Navbar dropdown styling */
        .navbar .dropdown-menu {
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            padding: 8px;
            margin-top: 8px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(102, 126, 234, 0.1);
        }
        .navbar .dropdown-item {
            border-radius: 8px;
            padding: 10px 16px;
            transition: all 0.3s ease;
            color: #2C3E50;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar .dropdown-item:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateX(4px);
        }
        .navbar .dropdown-item i {
            width: 18px;
            text-align: center;
            opacity: 0.8;
        }
        .navbar .dropdown-divider {
            margin: 8px 0;
            opacity: 0.1;
            border-color: #667eea;
        }
        .navbar .nav-link.dropdown-toggle {
            color: #2C3E50;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 10px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .navbar .nav-link.dropdown-toggle:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, #e9ecff 100%);
            color: #667eea;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 240px;
                left: -240px; /* Hide by default on mobile */
                top: 56px;
            }
            .sidebar.show {
                left: 0; /* Show when toggled */
                box-shadow: 4px 0 30px rgba(102, 126, 234, 0.25);
            }
            .content {
                margin-left: 0;
                width: 100%;
                padding: 15px;
            }
            .sidebar-sticky {
                height: auto;
                max-height: calc(100vh - 56px);
            }
            .navbar-brand {
                width: auto;
                max-width: 200px;
                margin-right: 0;
                font-size: 0.9rem;
                padding: 15px 10px;
            }
            body {
                padding-top: 56px; /* Smaller padding on mobile */
            }
            /* Show backdrop when sidebar is open */
            .sidebar-backdrop.show {
                display: block;
            }
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">MDC ProCollege System</a>
            <button class="navbar-toggler" type="button" id="sidebarToggle" aria-label="Toggle sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> Admin
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Backdrop for mobile sidebar -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <div class="container-fluid">
        <div class="row">
            <nav id="sidebar" class="d-md-block sidebar">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.colleges.*') ? 'active' : '' }}" href="{{ route('admin.colleges.index') }}">
                                <i class="bi bi-building-add"></i> Colleges
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}" href="{{ route('admin.admins.index') }}">
                                <i class="bi bi-people"></i> Admins
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                                <i class="bi bi-person-badge"></i> Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.fundings.*') ? 'active' : '' }}" href="{{ route('admin.fundings.index') }}">
                                <i class="bi bi-currency-rupee"></i> Funding
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.releases.*') ? 'active' : '' }}" href="{{ route('admin.releases.index') }}">
                                <i class="bi bi-cash-coin"></i> Fund Releases
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}" href="{{ route('admin.payments.index') }}">
                                <i class="bi bi-currency-rupee"></i> Payments
                            </a>
                        </li>
                        @if(auth()->guard('admin')->user() && auth()->guard('admin')->user()->role === 'superadmin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.audit-logs.*') ? 'active' : '' }}" href="{{ route('admin.audit-logs.index') }}">
                                <i class="bi bi-journal-text"></i> Audit Logs
                            </a>
                        </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="bi bi-gear"></i> Settings
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main class="content col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            
            // Toggle sidebar on button click
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('show');
                backdrop.classList.toggle('show');
            });
            
            // Close sidebar when clicking on backdrop
            backdrop.addEventListener('click', function() {
                sidebar.classList.remove('show');
                backdrop.classList.remove('show');
            });
            
            // Close sidebar when clicking on a link (mobile only)
            const sidebarLinks = sidebar.querySelectorAll('.nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 769) {
                        sidebar.classList.remove('show');
                        backdrop.classList.remove('show');
                    }
                });
            });
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 769) {
                    backdrop.classList.remove('show');
                }
            });
        });
    </script>
    @yield('scripts')
</body>
</html> 