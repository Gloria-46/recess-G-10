<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
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
    Route::get('/alerts', [WarehouseController::class, 'alerts'])->name('alerts');
    Route::get('/inventory',[WarehouseController::class,'inventory'])->name('warehouse.inventory');
    Route::get('/warehouse/stock/{product}/add',[WarehouseController::class,'showAddStock'])->name('warehouse.stock.add');
    Route::post('/warehouse/stock/{product}/add',[WarehouseController::class,'addStock'])->name('warehouse.stock.add.store');
    Route::get('/warehouse/stock/{product}/remove',[WarehouseController::class,'showRemoveStock'])->name('warehouse.stock.remove');
    Route::post('/warehouse/stock/{product}/remove',[WarehouseController::class,'removeStock'])->name('warehouse.stock.remove.store');
    Route::post('/inventory/transfer',[WarehouseController::class,'transferStock'])->name('warehouse.inventory.transfer');
    Route::get('/inventory/reports',[WarehouseController::class,'reports'])->name('warehouse.inventory.reports');
    Route::get('/warehouse/reports', [App\Http\Controllers\WarehouseController::class, 'reports'])->name('warehouse.reports');
    Route::get('/warehouse/transfer', [App\Http\Controllers\WarehouseController::class, 'showTransferForm'])->name('warehouse.transfer.form');
    Route::post('/warehouse/transfer', [App\Http\Controllers\WarehouseController::class, 'handleTransfer'])->name('warehouse.transfer.handle');
    Route::get('/products', [App\Http\Controllers\WarehouseController::class, 'products'])->name('products.index');
    Route::get('/products/{product}/edit', [App\Http\Controllers\WarehouseController::class, 'editProduct'])->name('products.edit');
    Route::delete('/products/{product}', [App\Http\Controllers\WarehouseController::class, 'deleteProduct'])->name('products.delete');
    Route::put('/products/{product}', [App\Http\Controllers\WarehouseController::class, 'updateProduct'])->name('products.update');
    Route::get('/products/create', [App\Http\Controllers\WarehouseController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [App\Http\Controllers\WarehouseController::class, 'storeProduct'])->name('products.store');
    Route::patch('/products/{product}/autosave', [App\Http\Controllers\WarehouseController::class, 'updateProductAjax'])->name('products.autosave');
    Route::get('/warehouse/transfers', [WarehouseController::class, 'transfersIndex'])->name('warehouse.transfers.index');
    Route::get('/products/ladies', [WarehouseController::class, 'productsLadies'])->name('products.ladies');
    Route::get('/products/gentlemen', [WarehouseController::class, 'productsGentlemen'])->name('products.gentlemen');
    
    // Order Management Routes
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/orders/{order}/process', [OrderController::class, 'processOrder'])->name('orders.process');
    Route::post('/orders/{order}/ship', [OrderController::class, 'shipOrder'])->name('orders.ship');
    Route::post('/orders/{order}/deliver', [OrderController::class, 'deliverOrder'])->name('orders.deliver');
    Route::resource('supplies', App\Http\Controllers\SupplyController::class);
    Route::get('orders/retailers', [App\Http\Controllers\OrderController::class, 'retailers'])->name('orders.retailers');
    Route::get('orders/my-retailer-orders', [App\Http\Controllers\OrderController::class, 'myRetailerOrders'])->name('orders.myRetailerOrders');
});

require __DIR__.'/auth.php';
