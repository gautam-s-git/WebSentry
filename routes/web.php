<?php

use App\Http\Controllers\Websentry\MonitoringController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canRegister' => Features::enabled(Features::registration()),
//     ]);
// })->name('home');

// Route::get('dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/',[MonitoringController::class,'home'])->name('home');

// Route::group(['prefix'=>'websentry'],function(){



// });

require __DIR__.'/settings.php';
