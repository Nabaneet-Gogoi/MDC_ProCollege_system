<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        $user = Auth::user();
        
        // Check if user has the specified role
        if ($role === 'college' && $user->isCollegeUser()) {
            return $next($request);
        }
        
        if ($role === 'RUSA' && $user->isRUSAUser()) {
            return $next($request);
        }
        
        // Redirect or abort based on unauthorized access
        if ($user->isCollegeUser()) {
            return redirect()->route('college.dashboard')->with('error', 'You do not have permission to access that resource.');
        }
        
        return abort(403, 'Unauthorized action.');
    }
} 