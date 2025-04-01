<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\AuditLogService;

class UserAuthController extends Controller
{
    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle user login request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Log successful login
            AuditLogService::logCustomAction(
                'login',
                $user,
                "User {$user->username} logged in successfully",
                null,
                ['ip' => $request->ip(), 'user_agent' => $request->userAgent()]
            );
            
            // Update last login timestamp if the column exists
            if (schema_has_column('users', 'last_login_at')) {
                $user->last_login_at = now();
                $user->save();
            }
            
            // Redirect based on user role
            if ($user->isCollegeUser()) {
                return redirect()->route('college.dashboard');
            } elseif ($user->isRUSAUser()) {
                return redirect()->route('rusa.dashboard');
            }
            
            // Default redirect
            return redirect()->intended('/');
        }

        // Log failed login attempt if username exists
        $user = User::where('username', $request->username)->first();
        if ($user) {
            AuditLogService::logCustomAction(
                'login_failed',
                $user,
                "Failed login attempt for user {$request->username}",
                null,
                ['ip' => $request->ip(), 'user_agent' => $request->userAgent()]
            );
        }

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    /**
     * Handle user logout request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        // Log the logout action if user is authenticated
        if ($user) {
            AuditLogService::logCustomAction(
                'logout',
                $user,
                "User {$user->username} logged out",
                null,
                ['ip' => $request->ip(), 'user_agent' => $request->userAgent()]
            );
        }
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
} 