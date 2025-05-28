<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RUSA Dashboard') - MDC ProCollege System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        /* RUSA Design System Variables */
        :root {
            --rusa-primary: #FFE03B;
            --rusa-secondary: #FDB813;
            --rusa-tertiary: #F7941D;
            --rusa-accent: #D1322D;
            --rusa-gradient: linear-gradient(135deg, #D1322D 0%, #F7941D 30%, #FDB813 70%, #FFE03B 100%);
            --rusa-gradient-soft: linear-gradient(135deg, rgba(209, 50, 45, 0.8) 0%, rgba(247, 148, 29, 0.8) 30%, rgba(253, 184, 19, 0.8) 70%, rgba(255, 224, 59, 0.8) 100%);
            --success-gradient: linear-gradient(135deg, #059669 0%, #10b981 50%, #34d399 100%);
            --warning-gradient: linear-gradient(135deg, #F7941D 0%, #FDB813 50%, #FFE03B 100%);
            --info-gradient: linear-gradient(135deg, #0891b2 0%, #06b6d4 50%, #22d3ee 100%);
            --danger-gradient: linear-gradient(135deg, #D1322D 0%, #ef4444 50%, #f87171 100%);
            --secondary-gradient: linear-gradient(135deg, #FFE03B 0%, #FDB813 50%, #F7941D 100%);
            
            /* Shadows */
            --rusa-shadow: 0 4px 15px rgba(255, 224, 59, 0.3);
            --rusa-shadow-hover: 0 8px 25px rgba(255, 224, 59, 0.4);
            --card-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            --card-shadow-hover: 0 4px 20px rgba(0, 0, 0, 0.15);
            
            /* Spacing */
            --spacing-xs: 4px;
            --spacing-sm: 8px;
            --spacing-md: 12px;
            --spacing-lg: 16px;
            --spacing-xl: 20px;
            --spacing-xxl: 24px;
            
            /* Border Radius */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 15px;
            --radius-xl: 20px;
        }

        html, body {
            overflow-x: hidden;
            width: 100%;
            height: 100%;
            position: relative;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding-top: 56px;
            display: flex;
            flex-direction: column;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            background: var(--rusa-gradient);
            width: 240px;
            transition: all 0.3s ease-in-out;
            box-shadow: 2px 0 15px rgba(255, 224, 59, 0.2);
        }
        
        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(2px);
        }
        
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 56px);
            padding-top: var(--spacing-md);
            overflow-x: hidden;
            overflow-y: auto;
            z-index: 1;
        }
        
        .sidebar .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, 0.95);
            padding: var(--spacing-md) var(--spacing-xl);
            transition: all 0.3s ease;
            border-radius: 0;
            position: relative;
            backdrop-filter: blur(1px);
        }
        
        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: rgba(255, 255, 255, 0.3);
            transition: width 0.3s ease;
        }
        
        .sidebar .nav-link:hover {
            background: rgba(255, 255, 255, 0.15);
            padding-left: 25px;
            color: #fff;
            transform: translateX(4px);
        }
        
        .sidebar .nav-link:hover::before {
            width: 4px;
        }
        
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.25);
            color: #fff;
            font-weight: 600;
            border-left: 4px solid #fff;
            padding-left: 16px;
            backdrop-filter: blur(3px);
        }
        
        .sidebar .nav-link i {
            margin-right: var(--spacing-md);
            width: 20px;
            text-align: center;
            filter: drop-shadow(0 1px 2px rgba(0, 0, 0, 0.2));
        }
        
        .navbar {
            height: 56px;
            background: var(--rusa-gradient) !important;
            box-shadow: 0 2px 15px rgba(255, 224, 59, 0.3);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .navbar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
            backdrop-filter: blur(2px);
        }
        
        .navbar-brand {
            font-weight: 700;
            padding-left: var(--spacing-md);
            color: #fff !important;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }
        
        .navbar .nav-link {
            color: rgba(255, 255, 255, 0.95) !important;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .navbar .nav-link:hover {
            color: #fff !important;
            transform: translateY(-1px);
        }
        
        .dropdown-menu {
            border: none;
            border-radius: var(--radius-md);
            box-shadow: var(--card-shadow);
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
        
        .dropdown-item:hover {
            background: var(--rusa-gradient-soft);
            color: #fff;
            transform: translateX(2px);
        }
        
        /* Enhanced Button Styles */
        .btn-rusa {
            background: var(--rusa-gradient);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: var(--radius-md);
            box-shadow: var(--rusa-shadow);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(2px);
        }
        
        .btn-rusa:hover {
            transform: translateY(-2px);
            box-shadow: var(--rusa-shadow-hover);
            color: #fff;
        }
        
        .btn-rusa-secondary {
            background: var(--secondary-gradient);
            border: none;
            color: #fff;
            font-weight: 600;
            border-radius: var(--radius-md);
            box-shadow: 0 4px 15px rgba(247, 148, 29, 0.3);
            transition: all 0.3s ease;
        }
        
        .btn-rusa-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(247, 148, 29, 0.4);
            color: #fff;
        }
        
        .btn-outline-rusa {
            border: 2px solid var(--rusa-primary);
            color: var(--rusa-accent);
            background: transparent;
            font-weight: 600;
            border-radius: var(--radius-md);
            transition: all 0.3s ease;
        }
        
        .btn-outline-rusa:hover {
            background: var(--rusa-gradient);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: var(--rusa-shadow);
        }
        
        /* Enhanced Card Styles */
        .rusa-card {
            border: none;
            border-radius: var(--radius-lg);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            overflow: hidden;
            position: relative;
        }
        
        .rusa-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--rusa-gradient);
        }
        
        .rusa-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--card-shadow-hover);
        }
        
        .rusa-card.compact {
            padding: var(--spacing-md);
        }
        
        .rusa-stat-card {
            border: none;
            border-radius: var(--radius-lg);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
            backdrop-filter: blur(10px);
        }
        
        .rusa-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 4px;
            background: var(--rusa-gradient);
        }
        
        .rusa-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }
        
        .content-wrapper {
            margin-left: 240px;
            padding: var(--spacing-lg);
            width: calc(100% - 240px);
            overflow-x: hidden;
            flex: 1;
            min-height: calc(100vh - 56px);
        }
        
        /* Progress Elements */
        .progress {
            height: 12px;
            border-radius: var(--radius-sm);
            background: rgba(0, 0, 0, 0.05);
            overflow: hidden;
            position: relative;
        }
        
        .progress-bar {
            transition: width 1s ease-in-out;
            position: relative;
            overflow: hidden;
        }
        
        .progress-bar::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            bottom: 0;
            right: -100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
            animation: shimmer 2s infinite;
        }
        
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        
        /* Table Enhancements */
        .table-hover tbody tr:hover {
            background-color: rgba(255, 224, 59, 0.08);
            transform: translateX(2px);
            transition: all 0.2s ease;
        }
        
        .table-responsive {
            overflow-x: auto;
            border-radius: var(--radius-md);
            box-shadow: var(--card-shadow);
        }
        
        /* Badge Improvements */
        .badge {
            border-radius: var(--radius-sm);
            font-weight: 600;
            padding: 0.4em 0.8em;
        }
        
        /* Responsive Design */
        @media (max-width: 767.98px) {
            .sidebar {
                width: 60px;
            }
            .sidebar .nav-link span {
                display: none;
            }
            .sidebar .nav-link {
                padding: var(--spacing-md);
                text-align: center;
            }
            .content-wrapper {
                margin-left: 60px;
                width: calc(100% - 60px);
                padding: var(--spacing-md);
            }
        }
        
        /* Utility Classes */
        .ultra-compact {
            padding: var(--spacing-sm) !important;
        }
        
        .compact-text {
            font-size: 0.8rem;
            line-height: 1.3;
        }
        
        .gradient-text {
            background: var(--rusa-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }
        
        /* Animation Classes */
        .animate-fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .wrapper {
            display: flex;
            min-height: calc(100% - 56px);
            height: calc(100% - 56px);
        }
        
        /* Modern scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--rusa-gradient);
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: var(--rusa-gradient);
            opacity: 0.8;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('rusa.dashboard') }}">
                <i class="bi bi-buildings"></i> MDC ProCollege | RUSA
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->username ?? 'RUSA User' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
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

    <!-- Sidebar and Content Wrapper -->
    <div class="wrapper">
        <!-- Sidebar Navigation -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rusa.dashboard') ? 'active' : '' }}" href="{{ route('rusa.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rusa.utilization') ? 'active' : '' }}" href="{{ route('rusa.utilization') }}">
                            <i class="bi bi-currency-rupee"></i> <span>Fund Utilization</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rusa.progress') ? 'active' : '' }}" href="{{ route('rusa.progress') }}">
                            <i class="bi bi-graph-up"></i> <span>Progress Reports</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rusa.colleges') ? 'active' : '' }}" href="{{ route('rusa.colleges') }}">
                            <i class="bi bi-building"></i> <span>Colleges</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rusa.bills') ? 'active' : '' }}" href="{{ route('rusa.bills') }}">
                            <i class="bi bi-receipt"></i> <span>Bills</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rusa.payments') ? 'active' : '' }}" href="{{ route('rusa.payments') }}">
                            <i class="bi bi-credit-card"></i> <span>Payments</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="content-wrapper">
            @yield('content')
        </main>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html> 