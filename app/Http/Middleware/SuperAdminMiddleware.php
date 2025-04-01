<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     * Only allow superadmins to access protected routes.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated as admin
        if (!Auth::guard('admin')->check()) {
            // Store intended URL if it's a GET request
            if ($request->isMethod('GET')) {
                session()->put('url.intended', url()->current());
            }
            
            return redirect()->route('admin.login')
                ->with('error', 'Please log in to access the admin area.');
        }
        
        // Check if the admin has superadmin role
        $admin = Auth::guard('admin')->user();
        if ($admin->role !== 'superadmin') {
            return redirect()->route('admin.dashboard')
                ->with('error', 'You do not have permission to access that page.');
        }
        
        return $next($request);
    }
}
