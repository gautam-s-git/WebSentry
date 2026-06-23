<?php

use App\Http\Controllers\Websentry\ClientController;
use App\Http\Controllers\Websentry\MonitoringController;
use App\Http\Controllers\Websentry\WebsiteController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MonitoringController::class, 'home'])->name('home');

// KAN-1-task-2: List all clients
Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

// KAN-1-task-3: Create a new client
Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');

// KAN-1-task-4: Show a single client
Route::get('/clients/{id}', [ClientController::class, 'show'])->name('clients.show');

// KAN-1-task-5: Update a client
Route::put('/clients/{id}', [ClientController::class, 'update'])->name('clients.update');

// KAN-1-task-6: Delete a client
Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('clients.destroy');

// KAN-1-task-7: List all websites
Route::get('/websites', [WebsiteController::class, 'index'])->name('websites.index');

// KAN-1-task-8: Create a new website
Route::post('/websites', [WebsiteController::class, 'store'])->name('websites.store');

// KAN-1-task-9: Show a single website
Route::get('/websites/{id}', [WebsiteController::class, 'show'])->name('websites.show');

// KAN-1-task-10: Update a website
Route::put('/websites/{id}', [WebsiteController::class, 'update'])->name('websites.update');


require __DIR__.'/settings.php';
