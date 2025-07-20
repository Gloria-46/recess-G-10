<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Modules\CustomerRetail\App\Http\Controllers\Api\RetailerController;
// use Modules\CustomerRetail\Http\Controllers\Api\AuthController;
// use Modules\CustomerRetail\Http\Controllers\CustomerRetailController;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('customerretails', CustomerRetailController::class)->names('customerretail');
// });

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

//     Route::get('/', [RetailerController::class, 'getProducts']);
//     Route::post('/', [RetailerController::class, 'createProduct'])->middleware('auth:sanctum');
//     Route::put('/{product}', [RetailerController::class, 'updateProduct'])->middleware('auth:sanctum');
//     Route::delete('/{product}', [RetailerController::class, 'deleteProduct'])->middleware('auth:sanctum');
// });

// // Order API
// Route::prefix('orders')->group(function () {
//     Route::get('/', [RetailerController::class, 'getOrders'])->middleware('auth:sanctum');
//     Route::get('/{order}', [RetailerController::class, 'getOrder'])->middleware('auth:sanctum');
//     Route::put('/{order}/status', [RetailerController::class, 'updateOrderStatus'])->middleware('auth:sanctum');
// });

// Customer Recommendations API
// Route::middleware('auth:sanctum')->get('/customer/recommendations', [\Modules\CustomerRetail\App\Http\Controllers\Customer\RecommendationController::class, 'index']); 