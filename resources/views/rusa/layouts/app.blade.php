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
        html, body {
            overflow-x: hidden; /* Prevent horizontal scroll */
            width: 100%;
            height: 100%;
            position: relative;
        }
        body {
            background-color: #f8f9fa;
            padding-top: 56px; /* Reduced to ensure proper spacing */
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            position: fixed;
            top: 56px;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #0d6efd; /* Blue color for RUSA */
            width: 240px;
            transition: all 0.3s ease-in-out;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 56px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto;
        }
        .sidebar .nav-link {
            font-weight: 500;
            color: #fff;
            padding: 10px 20px;
            transition: all 0.2s ease;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            padding-left: 25px; /* slightly indent on hover for better UX */
        }
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            border-left: 4px solid #fff;
            padding-left: 16px; /* Adjust for the border */
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px; /* Fixed width for icons to align text properly */
            text-align: center;
        }
        .navbar-brand {
            font-weight: 600;
            padding-left: 10px;
        }
        .stat-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .bg-rusa {
            background-color: #0d6efd;
            color: white;
        }
        .btn-rusa {
            background-color: #0d6efd;
            border-color: #0d6efd;
            color: white;
        }
        .btn-rusa:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
            color: white;
        }
        .content-wrapper {
            margin-left: 240px;
            padding: 20px; /* Consistent padding */
            width: calc(100% - 240px);
            overflow-x: hidden;
            flex: 1;
        }
        @media (max-width: 767.98px) {
            .sidebar {
                width: 60px;
            }
            .sidebar .nav-link span {
                display: none;
            }
            .content-wrapper {
                margin-left: 60px;
                width: calc(100% - 60px);
            }
        }
        .progress {
            height: 10px;
            border-radius: 5px;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }
        /* Ensure tables don't overflow */
        .table-responsive {
            overflow-x: auto;
        }
        /* Make charts responsive */
        canvas {
            max-width: 100%;
        }
        /* Fix navbar size */
        .navbar {
            height: 56px;
        }
        /* Wrapper for page content */
        .wrapper {
            display: flex;
            min-height: calc(100% - 56px);
            height: calc(100% - 56px);
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-rusa">
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