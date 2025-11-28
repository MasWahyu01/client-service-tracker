<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Service\ServiceController;
use App\Http\Controllers\InteractionLog\InteractionLogController;
use App\Http\Controllers\ActivityLogController;

/*
|--------------------------------------------------------------------------
| Guest Routes (belum login)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->name('login.perform');
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes (sudah login)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Dashboard — semua user yang login bisa lihat
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Routes untuk Super Admin + Staff (bisa kelola data)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:super_admin,staff')->group(function () {

        // Client Management (CRUD lengkap)
        Route::resource('clients', ClientController::class);

        // Services: index, create, store
        Route::resource('services', ServiceController::class)
            ->only(['index', 'create', 'store']);

        // Interaction Logs: create dari Client Detail
        Route::post('interaction-logs', [InteractionLogController::class, 'store'])
            ->name('interaction-logs.store');

        // Quick status update service (AJAX)
        Route::patch('services/{service}/status', [ServiceController::class, 'updateStatus'])
            ->name('services.update-status');
    });

    /*
    |--------------------------------------------------------------------------
    | Routes untuk Super Admin + Staff + Viewer (read-only/report)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:super_admin,staff,viewer')->group(function () {
        // Kalau nanti ada halaman reports, summary, dll, bisa taruh di sini.
        // Dashboard sudah di atas, jadi nggak perlu diulang.
    });

    /*
    |--------------------------------------------------------------------------
    | Routes Khusus Super Admin (Activity Logs, User Management, dll)
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:super_admin')->group(function () {
        Route::get('/activity-logs', [ActivityLogController::class, 'index'])
            ->name('activity-logs.index');
    });
});
