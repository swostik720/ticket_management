<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\HeadOfficeController;
use App\Http\Controllers\HomeController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    // Password reset routes
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Admin and Head of Department routes
    Route::middleware('role:admin,head_of_department')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/tickets/{id}', [AdminController::class, 'showTicket'])->name('tickets.show');
        Route::post('/tickets/{id}/assign', [TicketController::class, 'assign'])->name('tickets.assign');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{id}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
        Route::get('/departments', [AdminController::class, 'departments'])->name('departments');
        Route::get('/departments/create', [AdminController::class, 'createDepartment'])->name('departments.create');
        Route::post('/departments', [AdminController::class, 'storeDepartment'])->name('departments.store');
        Route::get('/branches', [AdminController::class, 'branches'])->name('branches');
        Route::get('/branches/create', [AdminController::class, 'createBranch'])->name('branches.create');
        Route::post('/branches', [AdminController::class, 'storeBranch'])->name('branches.store');
    });

    // Head Office Staff routes
    Route::middleware('role:head_office_staff')->prefix('head-office')->name('head_office.')->group(function () {
        Route::get('/dashboard', [HeadOfficeController::class, 'dashboard'])->name('dashboard');
        Route::get('/tickets/create', [HeadOfficeController::class, 'createTicket'])->name('tickets.create');
        Route::post('/tickets', [HeadOfficeController::class, 'storeTicket'])->name('tickets.store');
        Route::get('/tickets/{id}', [HeadOfficeController::class, 'showTicket'])->name('tickets.show');
        Route::post('/tickets/{id}/status', [TicketController::class, 'updateStatus'])->name('tickets.status');
    });

    // Staff routes
    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{id}', [StaffController::class, 'showTicket'])->name('tickets.show');
    });

    // Common ticket routes
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
});
