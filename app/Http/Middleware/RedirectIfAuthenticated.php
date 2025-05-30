<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                if ($guard === 'admin') {
                    return redirect()->route('admin.dashboard');
                }
                
                // Redirect based on user role
                $user = Auth::guard($guard)->user();
                if ($user->isCollegeUser()) {
                    // College user will be redirected to college dashboard
                    return redirect()->route('college.dashboard');
                } elseif ($user->isRUSAUser()) {
                    // RUSA user will be redirected to RUSA dashboard
                    return redirect()->route('rusa.dashboard');
                }
                
                // Default redirect
                return redirect('/');
            }
        }

        return $next($request);
    }
}
