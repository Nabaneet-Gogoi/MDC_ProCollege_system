@extends('layouts.app')

@section('title', 'Login - MDC ProCollege System')

@push('styles')
<style>
    /* Styles specific to login page content */
    .login-page-wrapper {
        display: flex;
        flex-grow: 1; /* Ensure it takes available vertical space */
        align-items: center;
        justify-content: center;
        background-color: #f3f4f6; /* Original body background */
        padding: 2rem 0; /* Add some padding for smaller screens */
    }
    .login-container {
        background-color: white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-radius: 0.5rem;
        padding: 2rem;
        max-width: 28rem;
        width: 90%; /* Responsive width */
        margin: 0 auto; /* Centering if flex container changes */
    }
    /* Ensure inputs and labels inherit color correctly if not overridden by Tailwind */
    .login-container label, .login-container button, .login-container input, .login-container h1, .login-container h2 {
        color: #000;
    }
</style>
@endpush

@section('content')
<div class="login-page-wrapper">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 m-4 login-container">
        <div class="flex justify-center mb-8">
            <h1 class="text-3xl font-bold text-black">MDC ProCollege System</h1>
        </div>
        
        <h2 class="text-2xl font-semibold text-center text-black mb-6">User Login</h2>
        
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            
            <div>
                <label for="username" class="block text-sm font-bold text-black">Username</label>
                <input id="username" name="username" type="text" autocomplete="username" required 
                    class="mt-1 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                    value="{{ old('username') }}">
            </div>

            <div>
                <label for="password" class="block text-sm font-bold text-black">Password</label>
                <input id="password" name="password" type="password" autocomplete="current-password" required
                    class="mt-1 block w-full px-3 py-2 border border-gray-400 rounded-md shadow-sm placeholder-gray-500 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-400 rounded">
                    <label for="remember_me" class="ml-2 block text-sm font-medium text-black">Remember me</label>
                </div>
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-lg text-xl font-extrabold bg-blue-700 hover:bg-blue-800 focus:outline-none" style="color: white !important; background-color: #1a56db !important; height: auto; min-height: 50px; margin-top: 20px;">
                    Sign in
                </button>
            </div>
        </form>
        
        <div class="mt-6 text-center">
            <a href="{{ route('admin.login') }}" class="text-base font-medium text-blue-700 hover:text-blue-800">
                Admin Login
            </a>
        </div>
    </div>
</div>
@endsection 