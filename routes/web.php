<?php

use App\Http\Controllers\Websentry\ClientController;
use App\Http\Controllers\Websentry\MonitoringController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MonitoringController::class, 'home'])->name('home');

// KAN-1-task-2: List all clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');


require __DIR__.'/settings.php';
