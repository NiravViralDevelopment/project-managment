<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectProgressController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CircleController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\SubstationController;
use App\Http\Controllers\ZoneController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

Route::middleware('guest')->group(function (): void {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('verify-otp', [LoginController::class, 'showVerifyOtpForm'])->name('verify-otp');
    Route::post('verify-otp', [LoginController::class, 'verifyOtp']);
});

Route::middleware('auth')->group(function (): void {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('circles-by-zone', [CircleController::class, 'circlesByZone'])->name('circles.by-zone');
    Route::get('divisions-by-circle', [DivisionController::class, 'divisionsByCircle'])->name('divisions.by-circle');
    Route::get('substations-by-division', [SubstationController::class, 'substationsByDivision'])->name('substations.by-division');
    Route::get('users-by-substation', [UserController::class, 'usersBySubstation'])->name('users.by-substation');

    Route::middleware('permission:manage-users')->group(function (): void {
        Route::resource('users', UserController::class);
    });

    Route::middleware('permission:manage-roles')->group(function (): void {
        Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
        Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');
        Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    });

    Route::middleware('permission:manage-zones')->group(function (): void {
        Route::resource('zones', ZoneController::class);
    });

    Route::middleware('permission:manage-circles')->group(function (): void {
        Route::resource('circles', CircleController::class);
    });

    Route::middleware('permission:manage-divisions')->group(function (): void {
        Route::resource('divisions', DivisionController::class);
    });

    Route::middleware('permission:manage-substations')->group(function (): void {
        Route::resource('substations', SubstationController::class);
    });

    Route::middleware('permission:create-projects')->group(function (): void {
        Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
    });
    Route::middleware('permission:view-projects')->group(function (): void {
        Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('projects/{project}/progress', [ProjectProgressController::class, 'show'])->name('projects.progress.show');
        Route::get('projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
    });
    Route::middleware('permission:edit-projects')->group(function (): void {
        Route::get('projects/{project}/progress/edit', [ProjectProgressController::class, 'edit'])->name('projects.progress.edit');
        Route::put('projects/{project}/progress', [ProjectProgressController::class, 'update'])->name('projects.progress.update');
        Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
    });
    Route::middleware('permission:delete-projects')->group(function (): void {
        Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
    });
});
