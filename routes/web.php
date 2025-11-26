<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ClientController;


Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('clients', ClientController::class);

use App\Http\Controllers\Service\ServiceController;

Route::resource('services', ServiceController::class)->only([
    'index', 'create', 'store'
]);

Route::patch('services/{service}/status', [ServiceController::class, 'updateStatus'])
    ->name('services.update-status');

use App\Http\Controllers\InteractionLog\InteractionLogController;

Route::post('interaction-logs', [InteractionLogController::class, 'store'])
    ->name('interaction-logs.store');
