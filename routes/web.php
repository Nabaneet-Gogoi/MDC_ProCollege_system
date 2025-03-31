<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\Admin\CollegeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\FundingController;
use App\Http\Controllers\Admin\ReleaseController;

Route::get('/', function () {
    return view('welcome');
});

// User Authentication Routes
Route::middleware('web')->group(function () {
    Route::get('login', [UserAuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [UserAuthController::class, 'login']);
    Route::post('logout', [UserAuthController::class, 'logout'])->name('logout')->middleware('auth');
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
    
    // Audit Logs (only accessible by superadmins)
    Route::middleware(['superadmin'])->group(function () {
        Route::get('audit-logs', [\App\Http\Controllers\Admin\AuditLogController::class, 'index'])->name('admin.audit-logs.index');
        Route::get('audit-logs/{auditLog}', [\App\Http\Controllers\Admin\AuditLogController::class, 'show'])->name('admin.audit-logs.show');
    });
    
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
    
    // Bills Management
    Route::resource('bills', 'App\Http\Controllers\Admin\BillController')->names([
        'index' => 'admin.bills.index',
        'create' => 'admin.bills.create',
        'store' => 'admin.bills.store',
        'show' => 'admin.bills.show',
        'edit' => 'admin.bills.edit',
        'update' => 'admin.bills.update',
        'destroy' => 'admin.bills.destroy',
    ]);
    Route::patch('bills/{id}/status', 'App\Http\Controllers\Admin\BillController@updateStatus')->name('admin.bills.updateStatus');
    Route::get('bills-filter', 'App\Http\Controllers\Admin\BillController@filter')->name('admin.bills.filter');
    
    // Payments Management
    Route::resource('payments', 'App\Http\Controllers\Admin\PaymentController')->names([
        'index' => 'admin.payments.index',
        'create' => 'admin.payments.create',
        'store' => 'admin.payments.store',
        'show' => 'admin.payments.show',
        'edit' => 'admin.payments.edit',
        'update' => 'admin.payments.update',
        'destroy' => 'admin.payments.destroy',
    ]);
    Route::patch('payments/{id}/status', 'App\Http\Controllers\Admin\PaymentController@updateStatus')->name('admin.payments.updateStatus');
    Route::get('payments-filter', 'App\Http\Controllers\Admin\PaymentController@filter')->name('admin.payments.filter');
});

// College User Routes
Route::middleware(['auth', 'role:college'])->prefix('college')->name('college.')->group(function () {
    // Dashboard Route
    Route::get('dashboard', 'App\Http\Controllers\College\DashboardController@index')->name('dashboard');
    
    // Fund Utilization Route
    Route::get('utilization', 'App\Http\Controllers\College\DashboardController@fundUtilization')->name('utilization');
    
    // Profile Routes
    Route::get('profile', 'App\Http\Controllers\College\ProfileController@index')->name('profile.index');
    Route::put('profile/update', 'App\Http\Controllers\College\ProfileController@update')->name('profile.update');
    Route::get('profile/change-password', 'App\Http\Controllers\College\ProfileController@showChangePasswordForm')->name('profile.change-password');
    Route::put('profile/update-password', 'App\Http\Controllers\College\ProfileController@updatePassword')->name('profile.update-password');
    
    // Bills Routes
    Route::resource('bills', 'App\Http\Controllers\College\BillController');
    
    // Bill Status Management Routes
    Route::get('bills-status', 'App\Http\Controllers\College\BillController@manageStatus')->name('bills.status.manage');
    Route::patch('bills-status/{id}', 'App\Http\Controllers\College\BillController@updateStatus')->name('bills.status.update');
    
    // Payments tracking
    Route::resource('payments', 'App\Http\Controllers\College\PaymentController')->only([
        'index', 'show', 'create', 'store'
    ]);
    Route::get('payments-filter', 'App\Http\Controllers\College\PaymentController@filter')->name('payments.filter');
    
    // Payment Status Management Routes
    Route::get('payments-status', 'App\Http\Controllers\College\PaymentController@manageStatus')->name('payments.status.manage');
    Route::patch('payments-status/{id}', 'App\Http\Controllers\College\PaymentController@updateStatus')->name('payments.status.update');
});

// RUSA User Routes
Route::middleware(['auth', 'role:RUSA'])->prefix('rusa')->name('rusa.')->group(function () {
    // Dashboard Route
    Route::get('dashboard', 'App\Http\Controllers\RUSA\DashboardController@index')->name('dashboard');
    
    // Fund Utilization Route
    Route::get('utilization', 'App\Http\Controllers\RUSA\DashboardController@fundUtilization')->name('utilization');
    
    // Progress Reports Route
    Route::get('progress', 'App\Http\Controllers\RUSA\DashboardController@progressReports')->name('progress');
    
    // Colleges Monitoring Routes
    Route::get('colleges', 'App\Http\Controllers\RUSA\RUSAController@colleges')->name('colleges');
    Route::get('colleges/{id}', 'App\Http\Controllers\RUSA\RUSAController@collegeDetails')->name('colleges.details');
    Route::get('colleges/{id}/print', 'App\Http\Controllers\RUSA\RUSAController@printCollegeDetails')->name('colleges.print');
    
    // Bills Monitoring Routes
    Route::get('bills', 'App\Http\Controllers\RUSA\RUSAController@bills')->name('bills');
    
    // Payments Monitoring Routes
    Route::get('payments', 'App\Http\Controllers\RUSA\RUSAController@payments')->name('payments');
});

// Bill Print Route (accessible to both admin and college users)
Route::get('bills/{id}/print', 'App\Http\Controllers\BillPrintController@printBill')
    ->name('bills.print')
    ->middleware('auth');

// Payment Print Route (accessible to both admin and college users)
Route::get('payments/{id}/print', 'App\Http\Controllers\PaymentPrintController@printPayment')
    ->name('payments.print')
    ->middleware('auth');
