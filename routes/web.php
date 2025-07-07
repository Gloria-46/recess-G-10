<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\AuthController;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Vendor\OrderController;
use App\Http\Controllers\Vendor\ProfileController;
use App\Http\Controllers\Vendor\InventoryController;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('vendor.login');

// Vendor Authentication Routes
Route::prefix('vendor')->name('vendor.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);

    // Authenticated routes
    Route::middleware('auth:vendor')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        
        // Dashboard
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Products
        Route::resource('products', ProductController::class);
        
        // Orders
        Route::resource('orders', OrderController::class);
        Route::get('orders/pending-count', [OrderController::class, 'pendingCount'])->name('orders.pendingCount');
        
        // Profile
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::post('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

        // Inventory
        Route::get('inventory', [InventoryController::class, 'index'])->name('inventory');
        Route::post('inventory/{product}/add-stock', [InventoryController::class, 'addStock'])->name('inventory.addStock');
        Route::post('inventory/add', [InventoryController::class, 'add'])->name('inventory.add');
        Route::get('inventory/batch/{batch}/edit', [InventoryController::class, 'editBatch'])->name('inventory.batch.edit');
        Route::put('inventory/batch/{batch}', [InventoryController::class, 'updateBatch'])->name('inventory.batch.update');
        Route::delete('inventory/batch/{batch}', [InventoryController::class, 'deleteBatch'])->name('inventory.batch.delete');
        Route::get('inventory/add-form', [InventoryController::class, 'addForm'])->name('inventory.addForm');

        // Analytics
        Route::get('analytics', [\App\Http\Controllers\Vendor\AnalyticsController::class, 'index'])->name('analytics');
        Route::get('analytics/trends', [\App\Http\Controllers\Vendor\AnalyticsController::class, 'trends'])->name('analytics.trends');
    });

    // Password Reset routes
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// Redirect root to vendor login
Route::get('/', function () {
    return redirect()->route('vendor.login');
});

// API route for vendor registration (for Java server)
Route::post('/api/vendor/register', function(Request $request) {
    $validated = $request->validate([
        'business_name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:vendors',
        'password' => 'required|string|min:8',
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string',
    ]);

    $vendor = Vendor::create([
        'business_name' => $validated['business_name'],
        'email' => $validated['email'],
        'password' => Illuminate\Support\Facades\Hash::make($validated['password']),
        'phone' => $validated['phone'] ?? null,
        'address' => $validated['address'] ?? null,
        'about' => '',
        'profile_image' => null,
        'is_active' => true,
        'status' => 'validated',
        'visit_date' => now()->addDays(3),
    ]);

    return response()->json(['success' => true, 'vendor_id' => $vendor->id], 201);
});

// Fallback for default login route
Route::get('login', function() {
    return redirect()->route('vendor.login');
})->name('login');

// Customer Dashboard Routes
Route::get('/customer/home', [App\Http\Controllers\Customer\HomeController::class, 'index'])->name('customer.home');
Route::get('/customer/products', [App\Http\Controllers\Customer\ProductController::class, 'index'])->name('customer.products');
Route::get('/customer/products/search', [App\Http\Controllers\Customer\ProductController::class, 'search'])->name('customer.products.search');
Route::get('/customer/products/{product}', [App\Http\Controllers\Customer\ProductController::class, 'show'])->name('customer.products.show');
Route::get('/customer/profile', [App\Http\Controllers\Customer\ProfileController::class, 'index'])->name('customer.profile');
Route::get('/customer/profile/edit', [App\Http\Controllers\Customer\ProfileController::class, 'edit'])->name('customer.profile.edit');
Route::post('/customer/profile/edit', [App\Http\Controllers\Customer\ProfileController::class, 'update'])->name('customer.profile.update');
Route::get('/customer/about', [App\Http\Controllers\Customer\PageController::class, 'about'])->name('customer.about');
Route::get('/customer/contact', [App\Http\Controllers\Customer\PageController::class, 'contact'])->name('customer.contact');
Route::post('/customer/contact', [App\Http\Controllers\Customer\PageController::class, 'sendContact'])->name('customer.contact.send');

Route::middleware(\App\Http\Middleware\RedirectIfNotCustomer::class)->group(function () {
    Route::get('/customer/cart', [App\Http\Controllers\Customer\CartController::class, 'index'])->name('customer.cart');
    Route::post('/customer/cart/add/{product}', [App\Http\Controllers\Customer\CartController::class, 'add'])->name('customer.cart.add');
    Route::post('/customer/cart/update/{key}', [App\Http\Controllers\Customer\CartController::class, 'update'])->name('customer.cart.update');
    Route::post('/customer/cart/checkout', [App\Http\Controllers\Customer\CartController::class, 'checkout'])->name('customer.cart.checkout');
    Route::post('/customer/cart/remove/{key}', [App\Http\Controllers\Customer\CartController::class, 'remove'])->name('customer.cart.remove');
    Route::post('/customer/cart/bulk-add/{product}', [App\Http\Controllers\Customer\CartController::class, 'bulkAdd'])->name('customer.cart.bulkAdd');
    
    // Customer Orders
    Route::get('/customer/orders', [App\Http\Controllers\Customer\OrderController::class, 'index'])->name('customer.orders');
    Route::get('/customer/orders/{order}', [App\Http\Controllers\Customer\OrderController::class, 'show'])->name('customer.orders.show');
});

// Customer Logout (outside middleware so it's always accessible)
Route::post('/customer/logout', function() {
    Auth::guard('customer')->logout();
    return redirect()->route('customer.home');
})->name('customer.logout');
Route::get('/customer/signup', [App\Http\Controllers\Customer\SignupController::class, 'show'])->name('customer.signup');
Route::post('/customer/signup', [App\Http\Controllers\Customer\SignupController::class, 'register'])->name('customer.signup.submit');

// Payment Routes
Route::get('/customer/payment', [App\Http\Controllers\Customer\PaymentController::class, 'showPaymentForm'])->name('customer.payment.form');
Route::post('/customer/payment/mobile-money', [App\Http\Controllers\Customer\PaymentController::class, 'processMobileMoney'])->name('customer.payment.mobile-money');
Route::post('/customer/payment/visa-card', [App\Http\Controllers\Customer\PaymentController::class, 'processVisaCard'])->name('customer.payment.visa-card');
Route::get('/customer/payment/status/{payment}', [App\Http\Controllers\Customer\PaymentController::class, 'showPaymentStatus'])->name('customer.payment.status');
Route::get('/customer/payment/check-status/{payment}', [App\Http\Controllers\Customer\PaymentController::class, 'checkPaymentStatus'])->name('customer.payment.check-status');
Route::post('/customer/payment/cancel/{payment}', [App\Http\Controllers\Customer\PaymentController::class, 'cancelPayment'])->name('customer.payment.cancel');

// Customer Authentication
Route::get('/customer/login', [App\Http\Controllers\Customer\AuthController::class, 'showLoginForm'])->name('customer.login');
Route::post('/customer/login', [App\Http\Controllers\Customer\AuthController::class, 'login'])->name('customer.login.submit');

Route::get('/lead', [App\Http\Controllers\LeadController::class, 'index'])->name('lead');
