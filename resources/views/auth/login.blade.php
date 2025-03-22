<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MDC ProCollege System</title>
    @vite('resources/css/app.css')
    <style>
        /* Fallback styles in case Tailwind isn't loaded properly */
        body { background-color: #f3f4f6; font-family: system-ui, -apple-system, sans-serif; }
        label, button, input, h1, h2 { color: #000; }
        .login-container { background-color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-radius: 0.5rem; padding: 2rem; max-width: 28rem; margin: 2rem auto; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
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
</body>
</html> 