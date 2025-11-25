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
