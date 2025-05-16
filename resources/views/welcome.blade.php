@extends('layouts.app')

@section('title', 'Welcome to RUSA MDC and Professional Colleges Bill Receipt and Payment Record Keeping System')

@section('content')
<style>
    /* Styles specific to welcome page content */
    .welcome-content {
        text-align: center;
        flex-grow: 1; /* Pushes footer down */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 40px 20px;
    }

    .welcome-content h1 { /* "Welcome to RUSA..." */
        font-size: 2rem;
        font-weight: 600; /* Semibold */
        margin-bottom: 0.75rem;
        color: #212529; /* Dark grey text */
    }

    .welcome-content p { /* "Please log in..." */
        font-size: 1rem;
        color: #6c757d; /* Muted grey text */
        margin-bottom: 1.5rem;
    }

    .login-button {
        background-color: #1976D2; /* Same blue as navbar */
        color: white;
        padding: 10px 25px;
        text-decoration: none;
        border-radius: 4px; /* Slightly rounded corners */
        font-size: 1rem;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
    }

    .login-button:hover {
        background-color: #155a9e; /* Darker blue on hover */
    }
</style>

<div class="welcome-content">
    <h1>Welcome to RUSA - MDC and Professional Colleges Bill Receipt and Payment Record Keeping System</h1>
    <p>Please log in to continue.</p>
    @if (Route::has('login'))
        <a href="{{ route('login') }}" class="login-button">Login</a>
    @endif
</div>
@endsection