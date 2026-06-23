<?php

use App\Http\Controllers\Websentry\ClientController;
use App\Http\Controllers\Websentry\MonitoringController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MonitoringController::class, 'home'])->name('home');

// KAN-1-task-2: List all clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

// KAN-1-task-3: Create a new client
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

// KAN-1-task-4: Show a single client
Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');


require __DIR__.'/settings.php';
