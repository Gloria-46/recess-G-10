<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\Inventory;
use App\Models\Supplier;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Authentication Routes
Route::get('/', [LoginController::class, 'show'])->name('login');
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

Route::get('/register', [RegisterController::class, 'show'])->name('register.form');
Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', function () {
        return view('home');
    })->name('home');

});
    Route::resource('suppliers', App\Http\Controllers\SupplierController::class);
    Route::resource('inventories', App\Http\Controllers\InventoryController::class);
    Route::resource('shipments', App\Http\Controllers\ShipmentController::class);
    Route::resource('orders', App\Http\Controllers\OrderController::class);
    Route::patch('orders/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('materials', App\Http\Controllers\MaterialController::class);
    Route::resource('performance', App\Http\Controllers\PerformanceController::class);










