<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;

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
    Route::resource('admins', AdminController::class)->except(['index']);
});
