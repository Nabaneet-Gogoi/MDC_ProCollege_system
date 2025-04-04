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
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background-color: #28a745; /* Green color for college */
            width: 240px;
            transition: all 0.3s ease-in-out;
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 60px);
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
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px; /* Fixed width for icons to align text properly */
            text-align: center;
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
            background-color: #28a745; /* Green color for college */
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
        }
        .navbar-brand:hover {
            color: #fff;
            background-color: #218838; /* Darker green on hover */
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
            color: #28a745; /* Green for college */
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
        @media (max-width: 768px) {
            .sidebar {
                width: 240px;
                left: -240px; /* Hide by default on mobile */
                top: 56px;
            }
            .sidebar.show {
                left: 0; /* Show when toggled */
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
            <a class="navbar-brand" href="{{ route('college.dashboard') }}">MDC ProCollege System</a>
            <button class="navbar-toggler" type="button" id="sidebarToggle" aria-label="Toggle sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name ?? 'College User' }}
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
                            <i class="bi bi-building-add"></i>College Profile
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
        // Sidebar toggle functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    backdrop.classList.toggle('show');
                    document.body.classList.toggle('sidebar-open');
                });
            }
            
            if (backdrop) {
                backdrop.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    backdrop.classList.remove('show');
                    document.body.classList.remove('sidebar-open');
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html> 