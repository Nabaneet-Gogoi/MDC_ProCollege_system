<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FundingController;
use App\Http\Controllers\Admin\ReleaseController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Root Route - Redirects based on authentication status
Route::get('/admin', [AdminAuthController::class, 'redirectAdmin'])->name('admin.index');

// Public Admin Routes (for guests)
Route::middleware('web')->prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
});

// Protected Admin Routes (require authentication)
Route::middleware(['web', 'admin.auth'])->prefix('admin')->group(function () {
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    // College Management
    Route::resource('colleges', CollegeController::class)->names([
        'index' => 'admin.colleges.index',
        'create' => 'admin.colleges.create',
        'store' => 'admin.colleges.store',
        'show' => 'admin.colleges.show',
        'edit' => 'admin.colleges.edit',
        'update' => 'admin.colleges.update',
        'destroy' => 'admin.colleges.destroy',
    ]);
    
    // Admin Management
    Route::resource('admins', AdminController::class)->names([
        'index' => 'admin.admins.index',
        'create' => 'admin.admins.create',
        'store' => 'admin.admins.store',
        'show' => 'admin.admins.show',
        'edit' => 'admin.admins.edit',
        'update' => 'admin.admins.update',
        'destroy' => 'admin.admins.destroy',
    ]);
    
    // User Management
    Route::resource('users', UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy',
    ]);
    
    // Funding Management
    Route::resource('fundings', FundingController::class)->names([
        'index' => 'admin.fundings.index',
        'create' => 'admin.fundings.create',
        'store' => 'admin.fundings.store',
        'show' => 'admin.fundings.show',
        'edit' => 'admin.fundings.edit',
        'update' => 'admin.fundings.update',
        'destroy' => 'admin.fundings.destroy',
    ]);
    
    // Calculate funding for a college based on type and phase
    Route::post('calculate-funding', [FundingController::class, 'calculateFunding'])->name('admin.fundings.calculate');
    
    // Release Management
    Route::resource('releases', ReleaseController::class)->names([
        'index' => 'admin.releases.index',
        'create' => 'admin.releases.create',
        'store' => 'admin.releases.store',
        'show' => 'admin.releases.show',
        'edit' => 'admin.releases.edit',
        'update' => 'admin.releases.update',
        'destroy' => 'admin.releases.destroy',
    ]);
    
    // Get funding details for release form
    Route::post('get-funding-details', [ReleaseController::class, 'getFundingDetails'])->name('admin.releases.getFundingDetails');
    // Add GET route for funding details as well
    Route::get('funding-details/{id}', [ReleaseController::class, 'getFundingDetailsById'])->name('admin.releases.getFundingDetailsById');
});
