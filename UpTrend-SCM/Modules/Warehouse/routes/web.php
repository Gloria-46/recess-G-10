<?php

use Modules\Warehouse\App\Http\Controllers\ProfileController;
use Modules\Warehouse\App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use Modules\Warehouse\App\Http\Controllers\WarehouseController as AppWarehouseController;
use Modules\Warehouse\App\Http\Controllers\MessageController;
use Modules\Warehouse\App\Http\Controllers\WarehouseController as ModuleWarehouseController;
use Modules\Warehouse\App\Http\Controllers\WarehouseDashboardController;

Route::middleware(['web', 'auth', 'verified'])->group(function () {
    Route::get('/warehouse/dashboard', [WarehouseDashboardController::class, 'index'])->name('warehouse.dashboard');
    Route::resource('warehouses', ModuleWarehouseController::class)->names('warehouse');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/alerts', [ModuleWarehouseController::class, 'alerts'])->name('alerts');
    Route::get('/inventory',[ModuleWarehouseController::class,'inventory'])->name('warehouse.inventory');
    Route::get('/warehouse/stock/{product}/add',[ModuleWarehouseController::class,'showAddStock'])->name('warehouse.stock.add');
    Route::post('/warehouse/stock/{product}/add',[ModuleWarehouseController::class,'addStock'])->name('warehouse.stock.add.store');
    Route::get('/warehouse/stock/{product}/remove',[ModuleWarehouseController::class,'showRemoveStock'])->name('warehouse.stock.remove');
    Route::post('/warehouse/stock/{product}/remove',[ModuleWarehouseController::class,'removeStock'])->name('warehouse.stock.remove.store');
    Route::post('/inventory/transfer',[ModuleWarehouseController::class,'transferStock'])->name('warehouse.inventory.transfer');
    Route::get('/inventory/reports',[ModuleWarehouseController::class,'reports'])->name('warehouse.inventory.reports');
    Route::get('/warehouse/reports', [AppWarehouseController::class, 'reports'])->name('warehouse.reports');
    Route::get('/warehouse/transfer', [AppWarehouseController::class, 'showTransferForm'])->name('warehouse.transfer.form');
    Route::post('/warehouse/transfer', [AppWarehouseController::class, 'handleTransfer'])->name('warehouse.transfer.handle');
    Route::get('/products', [AppWarehouseController::class, 'products'])->name('products.index');
    Route::get('/products/{product}/edit', [AppWarehouseController::class, 'editProduct'])->name('products.edit');
    Route::delete('/products/{product}', [AppWarehouseController::class, 'deleteProduct'])->name('products.delete');
    Route::put('/products/{product}', [AppWarehouseController::class, 'updateProduct'])->name('products.update');
    Route::get('/products/create', [AppWarehouseController::class, 'createProduct'])->name('products.create');
    Route::post('/products', [AppWarehouseController::class, 'storeProduct'])->name('products.store');
    Route::patch('/products/{product}/autosave', [AppWarehouseController::class, 'updateProductAjax'])->name('products.autosave');
    Route::get('/warehouse/transfers', [ModuleWarehouseController::class, 'transfersIndex'])->name('warehouse.transfers.index');
    Route::get('/products/ladies', [ModuleWarehouseController::class, 'productsLadies'])->name('products.ladies');
    Route::get('/products/gentlemen', [ModuleWarehouseController::class, 'productsGentlemen'])->name('products.gentlemen');
    
    // Order Management Routes
    Route::get('/order', [OrderController::class, 'index'])->name('order.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('/orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::post('/orders/{order}/process', [OrderController::class, 'processOrder'])->name('orders.process');
    Route::post('/orders/{order}/ship', [OrderController::class, 'shipOrder'])->name('orders.ship');
    Route::post('/orders/{order}/deliver', [OrderController::class, 'deliverOrder'])->name('orders.deliver');
    Route::resource('supplies', Modules\Warehouse\App\Http\Controllers\SupplyController::class);
    Route::get('orders/retailers', [Modules\Warehouse\App\Http\Controllers\OrderController::class, 'retailers'])->name('orders.retailers');
    Route::get('orders/my-retailer-orders', [Modules\Warehouse\App\Http\Controllers\OrderController::class, 'myRetailerOrders'])->name('orders.myRetailerOrders');
});

require __DIR__.'/auth.php';
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/warehouse/messages', [MessageController::class, 'store']);
    Route::post('/warehouse/messages/{message}/read', [MessageController::class, 'markAsRead']);
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/warehouse/chat', [MessageController::class, 'index'])->name('chat');
    Route::get('/warehouse/chat', [MessageController::class, 'index'])->name('warehouse.chat.index');
    Route::get('/warehouse/chat/{user}', [MessageController::class, 'chatWithUser'])->name('warehouse.chat.with');
});

// Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::middleware(['web', 'auth'])->post('/warehouse/messages', [MessageController::class, 'store'])->name('warehouse.messages.store');
Route::middleware(['web', 'auth'])->get('/warehouse/messages', [MessageController::class, 'index'])->name('warehouse.messages.index');