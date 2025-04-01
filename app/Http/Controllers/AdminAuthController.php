<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Services\AuditLogService;

class AdminAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Remove this line - middleware should be defined in routes instead
        // $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect to the appropriate admin page based on authentication status.
     * If user is authenticated, redirect to dashboard.
     * Otherwise, redirect to login page.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAdmin()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }
        
        return redirect()->route('admin.login');
    }

    /**
     * Show the admin login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an admin login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the admin in
        $credentials = $request->only('email', 'password');
        $remember = $request->filled('remember');

        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            // Get the admin
            $admin = Auth::guard('admin')->user();
            
            // Log successful login
            AuditLogService::logCustomAction(
                'login',
                $admin,
                "Admin {$admin->email} logged in successfully",
                null,
                ['ip' => $request->ip(), 'user_agent' => $request->userAgent()]
            );
            
            // Update last login timestamp if the column exists
            if (schema_has_column('admins', 'last_login_at')) {
                $admin->last_login_at = now();
                $admin->save();
            }
            
            // Authentication passed
            return redirect()->intended(route('admin.dashboard'));
        }

        // Log failed login attempt if email exists
        $admin = Admin::where('email', $request->email)->first();
        if ($admin) {
            AuditLogService::logCustomAction(
                'login_failed',
                $admin,
                "Failed login attempt for admin {$request->email}",
                null,
                ['ip' => $request->ip(), 'user_agent' => $request->userAgent()]
            );
        }

        // Authentication failed
        return back()
            ->withInput($request->only('email', 'remember'))
            ->withErrors(['email' => 'These credentials do not match our records.']);
    }

    /**
     * Log the admin out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        // Log the logout action if admin is authenticated
        if ($admin) {
            AuditLogService::logCustomAction(
                'logout',
                $admin,
                "Admin {$admin->email} logged out",
                null,
                ['ip' => $request->ip(), 'user_agent' => $request->userAgent()]
            );
        }
        
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')->with('success', 'You have been logged out successfully');
    }
}
