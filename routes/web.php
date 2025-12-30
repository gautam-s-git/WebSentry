<?php

use App\Http\Controllers\Websentry\MonitoringController;
use Illuminate\Support\Facades\Route;


Route::get('/',[MonitoringController::class,'home'])->name('home');


require __DIR__.'/settings.php';
