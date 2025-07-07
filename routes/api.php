<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Vendor Registration API
Route::prefix('vendor')->group(function () {
    Route::post('/register', [VendorController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    Route::get('/profile', [VendorController::class, 'profile'])->middleware('auth:sanctum');
    Route::put('/profile', [VendorController::class, 'updateProfile'])->middleware('auth:sanctum');
});

// Product API
Route::prefix('products')->group(function () {
    Route::get('/', [VendorController::class, 'getProducts']);
    Route::post('/', [VendorController::class, 'createProduct'])->middleware('auth:sanctum');
    Route::put('/{product}', [VendorController::class, 'updateProduct'])->middleware('auth:sanctum');
    Route::delete('/{product}', [VendorController::class, 'deleteProduct'])->middleware('auth:sanctum');
});

// Order API
Route::prefix('orders')->group(function () {
    Route::get('/', [VendorController::class, 'getOrders'])->middleware('auth:sanctum');
    Route::get('/{order}', [VendorController::class, 'getOrder'])->middleware('auth:sanctum');
    Route::put('/{order}/status', [VendorController::class, 'updateOrderStatus'])->middleware('auth:sanctum');
}); 