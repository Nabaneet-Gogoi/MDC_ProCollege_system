<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'College Dashboard') - MDC ProCollege System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            /* Educational-themed gradients */
            --primary-gradient: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3b82f6 100%);
            --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
            --warning-gradient: linear-gradient(135deg, #d97706 0%, #f59e0b 50%, #fbbf24 100%);
            --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
            --danger-gradient: linear-gradient(135deg, #dc2626 0%, #ef4444 50%, #f87171 100%);
            --secondary-gradient: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #a855f7 100%);
            
            /* Spacing system */
            --spacing-xs: 4px;
            --spacing-sm: 8px;
            --spacing-md: 12px;
            --spacing-lg: 16px;
            --spacing-xl: 20px;
            --spacing-2xl: 24px;
            
            /* Border radius system */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 15px;
            --radius-xl: 20px;
            
            /* Shadow system */
            --shadow-sm: 0 2px 4px rgba(0, 0, 0, 0.1);
            --shadow-md: 0 4px 8px rgba(0, 0, 0, 0.12);
            --shadow-lg: 0 8px 16px rgba(0, 0, 0, 0.15);
            --shadow-xl: 0 12px 24px rgba(0, 0, 0, 0.18);
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            padding-top: 60px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Modern Sidebar */
        .sidebar {
            position: fixed;
            top: 60px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            background: var(--primary-gradient);
            backdrop-filter: blur(10px);
            width: 240px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-xl);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            pointer-events: none;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 60px);
            padding-top: var(--spacing-md);
            overflow-x: hidden;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: rgba(255, 255, 255, 0.3) transparent;
        }

        .sidebar-sticky::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-sticky::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-sticky::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            padding: var(--spacing-md) var(--spacing-xl);
            margin: 2px var(--spacing-sm);
            border-radius: var(--radius-sm);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid transparent;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            transform: translateX(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: var(--shadow-md);
        }

        .sidebar .nav-link:hover::before {
            left: 100%;
        }

        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            border-left: 4px solid #fff;
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: var(--shadow-lg);
            font-weight: 600;
        }

        .sidebar .nav-link i {
            margin-right: var(--spacing-md);
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
            transition: transform 0.3s ease;
        }

        .sidebar .nav-link:hover i {
            transform: scale(1.1);
        }

        /* Modern Navbar */
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: var(--shadow-md);
            padding: 0;
            height: 60px;
        }

        .navbar .container-fluid {
            padding-left: 0;
        }

        .navbar-brand {
            padding: var(--spacing-lg);
            font-size: 1.1rem;
            font-weight: 800;
            background: var(--primary-gradient);
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
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .navbar-brand::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .navbar-brand:hover {
            color: #fff;
            transform: translateY(-1px);
            box-shadow: var(--shadow-lg);
        }

        .navbar-brand:hover::before {
            left: 100%;
        }

        /* User Dropdown */
        .navbar .nav-link {
            color: #374151 !important;
            font-weight: 500;
            transition: all 0.3s ease;
            padding: var(--spacing-sm) var(--spacing-lg);
            border-radius: var(--radius-sm);
        }

        .navbar .nav-link:hover {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6 !important;
            transform: translateY(-1px);
        }

        .dropdown-menu {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.05);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-xl);
            animation: dropdownSlide 0.3s ease;
        }

        @keyframes dropdownSlide {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-item {
            padding: var(--spacing-sm) var(--spacing-lg);
            transition: all 0.3s ease;
            border-radius: var(--radius-sm);
            margin: 2px var(--spacing-xs);
            font-weight: 500;
        }

        .dropdown-item:hover {
            background: var(--info-gradient);
            color: #fff;
            transform: translateX(4px);
        }

        .dropdown-item i {
            margin-right: var(--spacing-sm);
            width: 16px;
            text-align: center;
        }

        /* Content Area */
        .content {
            padding: var(--spacing-xl);
            min-height: calc(100vh - 60px);
            transition: margin 0.3s ease-in-out;
        }

        /* Modern Cards */
        .card {
            border: none;
            border-radius: var(--radius-lg);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-md);
            margin-bottom: var(--spacing-xl);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--primary-gradient);
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .card-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            font-weight: 700;
            color: #1e3c72;
            padding: var(--spacing-lg);
            border-radius: var(--radius-lg) var(--radius-lg) 0 0;
        }

        /* Modern Toggle Button */
        .navbar-toggler {
            border: none;
            padding: var(--spacing-sm);
            margin-right: var(--spacing-lg);
            background: rgba(59, 130, 246, 0.1);
            border-radius: var(--radius-sm);
            transition: all 0.3s ease;
        }

        .navbar-toggler:hover {
            background: rgba(59, 130, 246, 0.2);
            transform: scale(1.05);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.3);
        }

        /* Sidebar Backdrop */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 99;
            transition: all 0.3s ease;
        }

        /* Responsive Design */
        @media (min-width: 769px) {
            .content {
                margin-left: 240px;
            }
            .col-lg-2 {
                width: 240px;
            }
            #sidebar {
                display: block !important;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 240px;
                left: -240px;
                top: 56px;
            }
            
            .sidebar.show {
                left: 0;
                box-shadow: var(--shadow-xl);
            }
            
            .content {
                margin-left: 0;
                width: 100%;
                padding: var(--spacing-lg);
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
                padding: var(--spacing-lg) var(--spacing-md);
            }
            
            body {
                padding-top: 56px;
            }
            
            .sidebar-backdrop.show {
                display: block;
            }

            .card {
                margin-bottom: var(--spacing-lg);
            }

            .card-header {
                padding: var(--spacing-md);
            }
        }

        /* Enhanced Button Styles */
        .btn-modern {
            border: none;
            border-radius: var(--radius-sm);
            padding: var(--spacing-sm) var(--spacing-lg);
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-modern::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-modern:hover::before {
            left: 100%;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        /* Loading animation for nav links */
        @keyframes shimmer {
            0% { background-position: -200px 0; }
            100% { background-position: 200px 0; }
        }

        .nav-link.loading {
            background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.1) 50%, transparent 100%);
            background-size: 200px 100%;
            animation: shimmer 1.5s infinite;
        }
    </style>
    @yield('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('college.dashboard') }}">
                <i class="bi bi-mortarboard-fill me-2"></i>
                MDC ProCollege System
            </a>
            <button class="navbar-toggler" type="button" id="sidebarToggle" aria-label="Toggle sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-2"></i>{{ Auth::user()->name ?? 'College User' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('college.profile.index') }}"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('college.profile.change-password') }}"><i class="bi bi-key"></i> Change Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
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
                            <a class="nav-link {{ request()->routeIs('college.dashboard') ? 'active' : '' }}" href="{{ route('college.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('college.utilization') ? 'active' : '' }}" href="{{ route('college.utilization') }}">
                                <i class="bi bi-graph-up"></i> Fund Utilization
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('college.bills.*') && !request()->routeIs('college.bills.status.*') ? 'active' : '' }}" href="{{ route('college.bills.index') }}">
                                <i class="bi bi-receipt"></i> Bills
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('college.bills.status.*') ? 'active' : '' }}" href="{{ route('college.bills.status.manage') }}" style="padding-left: 40px;">
                                <i class="bi bi-arrow-right"></i> Bill Status
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('college.payments.*') && !request()->routeIs('college.payments.status.*') ? 'active' : '' }}" href="{{ route('college.payments.index') }}">
                                <i class="bi bi-credit-card"></i> Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('college.payments.status.*') ? 'active' : '' }}" href="{{ route('college.payments.status.manage') }}" style="padding-left: 40px;">
                                <i class="bi bi-arrow-right"></i> Payment Status
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('college.profile.*') ? 'active' : '' }}" href="{{ route('college.profile.index') }}">
                                <i class="bi bi-building-add"></i> College Profile
                            </a>
                        </li>
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
        // Enhanced sidebar toggle functionality with animations
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    backdrop.classList.toggle('show');
                    document.body.classList.toggle('sidebar-open');
                    
                    // Add loading animation to nav links
                    if (sidebar.classList.contains('show')) {
                        const navLinks = sidebar.querySelectorAll('.nav-link');
                        navLinks.forEach((link, index) => {
                            setTimeout(() => {
                                link.style.opacity = '0';
                                link.style.transform = 'translateX(-20px)';
                                setTimeout(() => {
                                    link.style.transition = 'all 0.3s ease';
                                    link.style.opacity = '1';
                                    link.style.transform = 'translateX(0)';
                                }, 50);
                            }, index * 50);
                        });
                    }
                });
            }
            
            if (backdrop) {
                backdrop.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    backdrop.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                });
            }

            // Enhanced hover effects for navigation
            const navLinks = document.querySelectorAll('.sidebar .nav-link');
            navLinks.forEach(link => {
                link.addEventListener('mouseenter', function() {
                    this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                });
                
                link.addEventListener('mouseleave', function() {
                    this.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                });
            });

            // Smooth scrolling for dropdown
            const dropdownToggle = document.getElementById('navbarDropdown');
            if (dropdownToggle) {
                dropdownToggle.addEventListener('click', function() {
                    const dropdown = this.nextElementSibling;
                    if (dropdown) {
                        dropdown.style.transformOrigin = 'top right';
                    }
                });
            }

            // Add page transition effects
            window.addEventListener('beforeunload', function() {
                document.body.style.opacity = '0';
                document.body.style.transform = 'translateY(-20px)';
            });
        });
    </script>
    @yield('scripts')
</body>
</html> 