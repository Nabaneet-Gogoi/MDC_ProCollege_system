<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use App\Http\Middleware\AdminAuthentication;
use App\Http\Middleware\CheckUserRole;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register global middleware
        $this->app['router']->middlewareGroup('web', [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ShareErrorsFromSession::class,
            VerifyCsrfToken::class,
            SubstituteBindings::class,
        ]);

        $this->app['router']->middlewareGroup('api', [
            ThrottleRequests::class.':api',
            SubstituteBindings::class,
        ]);

        // Register route middleware
        $this->app['router']->aliasMiddleware('auth', Authenticate::class);
        $this->app['router']->aliasMiddleware('auth.basic', AuthenticateWithBasicAuth::class);
        $this->app['router']->aliasMiddleware('can', Authorize::class);
        $this->app['router']->aliasMiddleware('guest', RedirectIfAuthenticated::class);
        $this->app['router']->aliasMiddleware('password.confirm', RequirePassword::class);
        $this->app['router']->aliasMiddleware('signed', ValidateSignature::class);
        $this->app['router']->aliasMiddleware('throttle', ThrottleRequests::class);
        $this->app['router']->aliasMiddleware('verified', EnsureEmailIsVerified::class);
        
        // Register our custom admin middleware
        $this->app['router']->aliasMiddleware('admin.auth', AdminAuthentication::class);
        $this->app['router']->aliasMiddleware('role', CheckUserRole::class);
    }
} 