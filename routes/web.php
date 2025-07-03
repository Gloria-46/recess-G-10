<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WarehouseController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/inventory',[WarehouseController::class,'inventory'])->name('warehouse.inventory');
    Route::post('/inventory/add',[WarehouseController::class,'addStock'])->name('warehouse.inventory.add');
    Route::post('/inventory/remove',[WarehouseController::class,'removeStock'])->name('warehouse.inventory.remove');
    Route::post('/inventory/transfer',[WarehouseController::class,'transferStock'])->name('warehouse.inventory.transfer');
    Route::get('/inventory/reports',[WarehouseController::class,'reports'])->name('warehouse.inventory.reports');
    Route::get('/warehouse/transfer', [App\Http\Controllers\WarehouseController::class, 'showTransferForm'])->name('warehouse.transfer.form');
    Route::post('/warehouse/transfer', [App\Http\Controllers\WarehouseController::class, 'handleTransfer'])->name('warehouse.transfer.handle');
});

require __DIR__.'/auth.php';
