<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Admin\CollegeController;

Route::get('/', function () {
    return view('welcome');
});

// Public Admin Routes (for guests)
Route::middleware('web')->prefix('admin')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminAuthController::class, 'login']);
});

// Protected Admin Routes (require authentication)
Route::middleware(['web', 'admin.auth'])->prefix('admin')->group(function () {
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    
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
    Route::resource('admins', AdminController::class)->except(['index']);
});
