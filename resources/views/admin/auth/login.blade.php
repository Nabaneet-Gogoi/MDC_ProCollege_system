@extends('layouts.app')

@section('title', 'Admin Login - MDC ProCollege System')

@push('styles')
<style>
    /* Styles specific to login page content */
    .login-page-wrapper {
        display: flex;
        flex-grow: 1; /* Ensure it takes available vertical space */
        align-items: center;
        justify-content: center;
        background-color:rgb(255, 255, 255); /* Original body background */
        padding: 2rem 0; /* Add some padding for smaller screens */
    }
    .login-container {
        background-color: #1e3a8a; /* Dark blue background */
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-radius: 0.5rem;
        padding: 2rem;
        max-width: 28rem;
        width: 90%; /* Responsive width */
        margin: 0 auto; /* Centering if flex container changes */
        border: 2px solid #1e40af; /* Slightly lighter blue border */
    }
    /* Ensure inputs and labels inherit color correctly - white text for admin */
    .login-container label, .login-container h1, .login-container h2 {
        color: #ffffff !important;
    }
    .login-container input {
        background-color: #ffffff;
        color: #000000;
    }
    .login-container button {
        color: #ffffff !important;
    }
    /* Admin badge styling */
    .admin-badge {
        background-color: #dc2626;
        color: #ffffff;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        display: inline-block;
        margin-bottom: 1rem;
    }
    /* Warning message styling */
    .warning-message {
        color: #fbbf24;
        font-size: 0.875rem;
        text-align: center;
        margin-top: 1rem;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="login-page-wrapper">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 m-4 login-container">
        <div class="flex justify-center mb-8">
            <h1 class="text-3xl font-bold text-white">MDC ProCollege System</h1>
        </div>
        
        <div class="text-center">
            <span class="admin-badge">Admin Only</span>
        </div>
        
        <h2 class="text-2xl font-semibold text-center text-white mb-6">Admin Login</h2>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="email" class="block text-sm font-bold text-white">Email Address</label>
                <input id="email" name="email" type="email" autocomplete="email" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('email') }}">
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-white">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-400 rounded">
                    <label for="remember_me" class="ml-2 block text-sm font-medium text-white">Remember me</label>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-lg text-xl font-extrabold bg-blue-700 hover:bg-blue-800 focus:outline-none" style="color: white !important; background-color: #1a56db !important; height: auto; min-height: 50px; margin-top: 20px;">
                    Sign in
                </button>
            </div>
        </form>
        
        <div class="warning-message">
            ⚠️ Access restricted to authorized administrators only.
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-base font-medium text-blue-300 hover:text-blue-200">
                User Login
            </a>
        </div>
    </div>
</div>
@endsection 