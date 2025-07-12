<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RetailerController;
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

// Retailer Registration API
Route::prefix('retailer')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    Route::get('/profile', [RetailerController::class, 'profile'])->middleware('auth:sanctum');
    Route::put('/profile', [RetailerController::class, 'updateProfile'])->middleware('auth:sanctum');
});

// Product API
Route::prefix('products')->group(function () {
    Route::get('/', [RetailerController::class, 'getProducts']);
    Route::post('/', [RetailerController::class, 'createProduct'])->middleware('auth:sanctum');
    Route::put('/{product}', [RetailerController::class, 'updateProduct'])->middleware('auth:sanctum');
    Route::delete('/{product}', [RetailerController::class, 'deleteProduct'])->middleware('auth:sanctum');
});

// Order API
Route::prefix('orders')->group(function () {
    Route::get('/', [RetailerController::class, 'getOrders'])->middleware('auth:sanctum');
    Route::get('/{order}', [RetailerController::class, 'getOrder'])->middleware('auth:sanctum');
    Route::put('/{order}/status', [RetailerController::class, 'updateOrderStatus'])->middleware('auth:sanctum');
});

// Customer Recommendations API
Route::middleware('auth:sanctum')->get('/customer/recommendations', [\App\Http\Controllers\Customer\RecommendationController::class, 'index']); 