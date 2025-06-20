<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ShipmentController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [DashboardController::class, 'index']);
Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments.index');
