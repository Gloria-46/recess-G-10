<?php

use Illuminate\Support\Facades\Route;
use Modules\Vendor\App\Http\Controllers\Auth\RegisterController;
use Modules\Vendor\App\Http\Controllers\DashboardController;
use Modules\Vendor\App\Http\Controllers\Auth\LoginController;
use Modules\Vendor\App\Models\Inventory;
use Modules\Vendor\App\Models\Supplier;
use Modules\Vendor\App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Vendor\App\Http\Controllers\MessageController;

// Authentication Routes
// Route::get('/', [LoginController::class, 'show'])->name('login');
// Route::get('/login', [LoginController::class, 'show'])->name('login');
// Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

// Route::get('/register', [RegisterController::class, 'show'])->name('register.form');
// Route::post('/register', [RegisterController::class, 'store'])->name('register');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('auth.signin');
})->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/vendor/dashboard', [DashboardController::class, 'index'])->name('vendor.dashboard');
    Route::resource('suppliers', Modules\Vendor\App\Http\Controllers\SupplierController::class);
    Route::resource('inventories', Modules\Vendor\App\Http\Controllers\InventoryController::class);
    Route::resource('shipments', Modules\Vendor\App\Http\Controllers\ShipmentController::class);
    Route::resource('orders', Modules\Vendor\App\Http\Controllers\OrderController::class);
    Route::patch('orders/{order}/status', [Modules\Vendor\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('materials', Modules\Vendor\App\Http\Controllers\MaterialController::class);
    Route::resource('performance', Modules\Vendor\App\Http\Controllers\PerformanceController::class);
    Route::post('/vendor/messages', [MessageController::class, 'store']);
    Route::post('/vendor/messages/{message}/read', [MessageController::class, 'markAsRead']);
    Route::get('/vendor/chat', [MessageController::class, 'index'])->name('vendor.chat.index');
    Route::get('/vendor/chat/{user}', [MessageController::class, 'chatWithUser'])->name('vendor.chat.with');
    Route::post('/messages', [MessageController::class, 'store'])->name('vendor.messages.store');
    Route::post('/vendor/messages', [MessageController::class, 'store'])->name('vendor.messages.store');
});