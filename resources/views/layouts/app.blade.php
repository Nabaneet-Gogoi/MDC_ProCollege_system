@php
use Illuminate\Support\Facades\Auth;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title', 'RUSA MDC and Professional Colleges Bill Receipt and Payment Record Keeping System')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            body, html {
                margin: 0;
                padding: 0;
                font-family: 'Roboto', sans-serif;
                background-color: #ffffff;
                color: #333;
                min-height: 100vh;
                display: flex;
                flex-direction: column;
            }

            /* Header Styling */
            .app-header {
                display: flex;
                align-items: center;
                justify-content: space-between; /* Distributes space between logos and text block */
                padding: 15px 5%; /* Padding on sides */
                background-color: #ffffff;
                /* border-bottom: 1px solid #eee; /* Optional subtle border */
            }

            .app-header .logo-left {
                height: 80px; /* Adjust as needed */
                width: auto;
                margin-right: 15px; /* Space between left logo and text */
            }

            .app-header .header-text {
                text-align: center;
                flex-grow: 1; /* Allows text to take available space if needed */
            }

            .app-header .header-text h1 { /* "Ministry of Human Resource Development" */
                font-size: 1.1em; /* Relative font size */
                margin: 0 0 3px 0;
                font-weight: 700; /* Bold */
                color: #000000;
            }

            .app-header .header-text p { /* "Department of Higher Education..." */
                font-size: 0.85em;
                margin: 0 0 5px 0;
                color: #333333;
            }

            .app-header .header-text .rusa-title { /* "RASHTRIYA UCHCHATAR SHIKSHA ABHIYAN" */
                font-size: 1.2em;
                font-weight: 700; /* Bold */
                color: #1E5BAD; /* Blue color, adjust to match image */
                margin-top: 4px;
                text-transform: uppercase;
            }

            .app-header .logo-right {
                height: 70px; /* Adjust as needed */
                width: auto;
                margin-left: 15px; /* Space between text and right logo */
            }

            /* Blue Navigation Bar */
            .blue-navbar {
                width: 100%;
                background-color: #1976D2; /* Blue color from image */
                padding: 10px 5%; /* Consistent side padding */
                box-sizing: border-box;
            }

            .blue-navbar a {
                color: white;
                padding: 0; /* Remove extra padding for plain text links */
                text-decoration: none;
                font-size: 0.95rem;
                margin-right: 20px; /* Space between links */
            }

            .blue-navbar a:hover {
                text-decoration: underline;
            }

            /* Main Content Area Styling (Generic, can be overridden by specific pages) */
            .page-content {
                flex-grow: 1;
                padding: 20px 5%; /* Default padding */
                display: flex; /* Added to allow content to control its own alignment if needed */
                flex-direction: column; /* Default flow */
            }


            /* Footer Styling */
            .app-footer {
                width: 100%;
                padding: 15px 0; /* Adjusted padding */
                background-color: #343a40; /* Dark grey/black background */
                text-align: center;
                color: #e9ecef; /* Lighter text color for better readability on dark background */
                font-size: 0.9rem; /* Slightly increased base font size for footer */
            }

            .app-footer .admin-login-link {
                color: #ced4da; /* Slightly muted but still readable link color */
                text-decoration: none;
                margin-left: 15px; /* Space from copyright text */
                font-size: 0.85rem; /* Readable but discrete size for admin link */
                transition: color 0.2s ease-in-out;
            }

            .app-footer .admin-login-link:hover {
                color: #f8f9fa; /* Brighten link on hover */
                text-decoration: underline;
            }
        </style>
        @vite('resources/css/app.css') 
        @stack('styles') <!-- For page-specific styles -->
    </head>
    <body>
        <header class="app-header">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/55/Emblem_of_India.svg/150px-Emblem_of_India.svg.png" alt="Emblem of India" class="logo-left">
            <div class="header-text">
                <h1>Ministry of Human Resource Development</h1>
                <p>Department of Higher Education, Government of India</p>
                <div class="rusa-title">RASHTRIYA UCHCHATAR SHIKSHA ABHIYAN</div>
            </div>
            <img src="{{ asset('img/RUSA-logo.png') }}" alt="RUSA Logo" class="logo-right">
        </header>

        <nav class="blue-navbar">
            <a href="{{ url('/') }}">Home</a>
            @if (Route::has('login'))
                <a href="{{ route('login') }}">Login</a>
            @endif
            @auth
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                @if (Route::has('register')) {{-- Assuming you might have a register route --}}
                    {{-- <a href="{{ route('register') }}">Register</a> --}}
                @endif
            @endauth
        </nav>

        <main class="page-content">
            @yield('content')
        </main>

        <footer class="app-footer">
            <span>© RUSA 2025</span>
            @if (Route::has('admin.login'))
                <a href="{{ route('admin.login') }}" class="admin-login-link">Admin Login</a>
            @endif
        </footer>
        @stack('scripts') <!-- For page-specific scripts -->
    </body>
</html> 