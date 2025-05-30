<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\DataTypeController;
use App\Http\Controllers\Admin\BackupController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Auth::routes();

// Wyatt Admin Panel Routes
Route::prefix('wyatt')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Users - KHÔNG có name prefix
    Route::resource('users', UserController::class);
    
    // Roles
    Route::resource('roles', RoleController::class);
    
    // Permissions
    Route::resource('permissions', PermissionController::class);
    
    // Settings
    Route::resource('settings', SettingController::class);
    
    // Activity Logs
    Route::resource('activity-logs', ActivityLogController::class)->only(['index', 'show', 'destroy']);
    
    // Menus
    Route::resource('menus', MenuController::class);
    
    // Menu Items
    Route::resource('menu-items', MenuItemController::class);
    
    // Data Types
    Route::resource('data-types', DataTypeController::class);

    // Backups
    Route::resource('backups', BackupController::class);
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');