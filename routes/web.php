<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\ClientController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('clients', ClientController::class);
