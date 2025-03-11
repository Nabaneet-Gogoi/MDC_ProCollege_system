<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated as an admin
        if (!Auth::guard('admin')->check()) {
            // Store intended URL if it's a GET request
            if ($request->isMethod('GET')) {
                session()->put('url.intended', url()->current());
            }
            
            // If not authenticated, redirect to admin login
            return redirect()->route('admin.login')->with('error', 'Please log in to access the admin area.');
        }

        return $next($request);
    }
}
