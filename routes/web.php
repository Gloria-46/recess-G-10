<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Retailer\DashboardController;
use App\Http\Controllers\Retailer\ProductController;
use App\Http\Controllers\Retailer\OrderController;
use App\Http\Controllers\Retailer\ProfileController;
use App\Http\Controllers\Retailer\InventoryController;
use Illuminate\Http\Request;
use App\Models\Retailer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;

// Retailer Authentication Routes
Route::prefix('retailer')->name('retailer.')->group(function () {
    Route::middleware('auth:retailer')->group(function () {
        
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
        Route::get('inventory/product/{product}', [InventoryController::class, 'productInventory'])->name('inventory.product');
        Route::post('inventory/{product}/add-stock', [InventoryController::class, 'addStock'])->name('inventory.addStock');
        Route::post('inventory/add', [InventoryController::class, 'add'])->name('inventory.add');
        Route::get('inventory/batch/{batch}/edit', [InventoryController::class, 'editBatch'])->name('inventory.batch.edit');
        Route::put('inventory/batch/{batch}', [InventoryController::class, 'updateBatch'])->name('inventory.batch.update');
        Route::delete('inventory/batch/{batch}', [InventoryController::class, 'deleteBatch'])->name('inventory.batch.delete');
        Route::get('inventory/add-form', [InventoryController::class, 'addForm'])->name('inventory.addForm');

        // Analytics
        Route::get('analytics', [\App\Http\Controllers\Retailer\AnalyticsController::class, 'index'])->name('analytics');
        Route::get('analytics/trends', [\App\Http\Controllers\Retailer\AnalyticsController::class, 'trends'])->name('analytics.trends');
    });
});

// Redirect root to retailer login
Route::get('/', function () {
    return redirect()->route('retailer.login');
});

// Fallback for default login route
Route::get('login', function() {
    return redirect()->route('retailer.login');
})->name('login');

// Removed all routes that reference Customer\PageController and Customer\AuthController
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

Route::get('/lead', [App\Http\Controllers\LeadController::class, 'index'])->name('lead');

Route::post('retailer/logout', function (\Illuminate\Http\Request $request) {
    Auth::guard('retailer')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); // Redirect to home or login page
})->name('retailer.logout');

// Retailer Login Form
Route::get('retailer/login', function () {
    return view('retailer.auth.login'); // Make sure this Blade view exists
})->name('retailer.login');

// Retailer Login POST
Route::post('retailer/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::guard('retailer')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('retailer.dashboard'));
    }
    return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
})->name('retailer.login.submit');

// Retailer Forgot Password Form
Route::get('retailer/forgot-password', function () {
    return view('retailer.auth.forgot-password');
})->name('retailer.password.request');

// Retailer Send Reset Link (dummy)
Route::post('retailer/forgot-password', function (\Illuminate\Http\Request $request) {
    // Implement sending email logic here if needed
    return back()->with('status', 'If your email exists in our system, a reset link has been sent.');
})->name('retailer.password.email');

// Retailer Reset Password Form
Route::get('retailer/reset-password/{token}', function ($token) {
    $email = request('email');
    return view('retailer.auth.reset-password', ['token' => $token, 'email' => $email]);
})->name('retailer.password.reset');

// Retailer Reset Password POST (dummy)
Route::post('retailer/reset-password', function (\Illuminate\Http\Request $request) {
    // Implement password reset logic here if needed
    return redirect()->route('retailer.login')->with('status', 'Your password has been reset!');
})->name('retailer.password.update');

// Customer Home/Dashboard Route
Route::get('/customer/home', function () {
    $mostViewed = Product::orderByDesc('views')->take(6)->get();
    $mostOrdered = Product::withCount('orders')->orderByDesc('orders_count')->take(6)->get();
    $products = Product::all();
    return view('customer.home', compact('mostViewed', 'mostOrdered', 'products'));
})->name('customer.home');

// Customer Products Route
Route::get('/customer/products', function (\Illuminate\Http\Request $request) {
    $category = $request->query('category');
    if ($category) {
        $products = \App\Models\Product::where('category', $category)->get();
    } else {
        $products = \App\Models\Product::all();
    }
    return view('customer.products', compact('products', 'category'));
})->name('customer.products');

// Customer Product Details Route
Route::get('/customer/products/{product}', function ($productId) {
    $product = \App\Models\Product::findOrFail($productId);
    return view('customer.product_details', compact('product'));
})->name('customer.products.show');

// Customer Cart Route
Route::get('/customer/cart', function () {
    $cartItems = collect(session('cart', []));
    return view('customer.cart', compact('cartItems'));
})->name('customer.cart');

// Customer About Route
Route::get('/customer/about', function () {
    return view('customer.about');
})->name('customer.about');

// Customer Login Form
Route::get('/customer/login', function () {
    return view('customer.auth.login');
})->name('customer.login');

// Customer Login POST
Route::post('/customer/login', function (Request $request) {
    $credentials = $request->only('email', 'password');
    if (Auth::guard('customer')->attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended(route('customer.home'));
    }
    return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
})->name('customer.login.submit');

// Customer Profile Route
Route::get('/customer/profile', function () {
    $user = Auth::guard('customer')->user();
    return view('customer.profile', compact('user'));
})->name('customer.profile');

// Customer Profile Edit Route
Route::get('/customer/profile/edit', function () {
    $user = Auth::guard('customer')->user();
    return view('customer.profile_edit', compact('user'));
})->name('customer.profile.edit');

// Customer Profile Update Route
Route::post('/customer/profile/edit', function (\Illuminate\Http\Request $request) {
    $user = Auth::guard('customer')->user();
    if ($user) {
        // Example: update name and email (customize as needed)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();
        return back()->with('success', 'Profile updated successfully!');
    }
    return back()->with('error', 'You must be logged in to update your profile.');
})->name('customer.profile.update');

// Customer Product Search Route
Route::get('/customer/products/search', function (\Illuminate\Http\Request $request) {
    $query = $request->input('q');
    $products = \App\Models\Product::where('name', 'like', "%{$query}%")->get();
    return view('customer.products', compact('products', 'query'));
})->name('customer.products.search');

// Customer Contact Route
Route::get('/customer/contact', function () {
    return view('customer.contact');
})->name('customer.contact');

// Customer Contact Send Route
Route::post('/customer/contact', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'message' => 'required|string',
    ]);

    $mailContent = "Name: {$request->name}\nEmail: {$request->email}\nMessage: {$request->message}";

    // Send email to support
    Mail::raw($mailContent, function ($message) use ($request) {
        $message->to('uptrendclothing09@gmail.com')
                ->subject('Customer Support Request');
        $message->replyTo($request->email, $request->name);
    });

    // Send a copy to the customer
    Mail::raw($mailContent, function ($message) use ($request) {
        $message->to($request->email)
                ->subject('Copy of Your Support Request to Uptrend Clothing');
        $message->replyTo('uptrendclothing09@gmail.com', 'Uptrend Clothing Support');
    });

    return back()->with('success', 'Your message has been sent! A copy has also been sent to your email.');
})->name('customer.contact.send');

// Customer Cart Add Route
Route::post('/customer/cart/add/{product}', function ($productId, \Illuminate\Http\Request $request) {
    $product = Product::findOrFail($productId);

    $cart = session()->get('cart', []);
    $cart[] = [
        'id' => $product->id,
        'name' => $product->name,
        'price' => $product->price,
        'size' => $request->input('size'),
        'color' => $request->input('color'),
        'image' => $product->image,
    ];
    session(['cart' => $cart]);

    return redirect()->back()->with('success', 'Product added to cart!');
})->name('customer.cart.add');

// Customer Cart Bulk Add Route
Route::post('/customer/cart/bulk-add/{product}', function ($productId) {
    // Implement bulk add logic here if needed
    return redirect()->back()->with('success', 'Products added to cart!');
})->name('customer.cart.bulkAdd');

// Customer Category Filter Routes
Route::get('/customer/products/category/{category}', function ($category) {
    $products = \App\Models\Product::where('category', $category)->get();
    return view('customer.products', compact('products', 'category'));
})->name('customer.products.category');

// Customer Orders Route
Route::get('/customer/orders', function () {
    $user = Auth::guard('customer')->user();
    $orders = collect();
    if ($user) {
        $orders = Order::where('user_id', $user->id)->latest()->paginate(10);
    }
    return view('customer.orders', compact('orders'));
})->name('customer.orders');

// Customer Orders Details Route
Route::get('/customer/orders/{order}', function ($orderId) {
    $user = Auth::guard('customer')->user();
    $order = Order::where('id', $orderId)
        ->where('user_id', $user ? $user->id : null)
        ->firstOrFail();
    return view('customer.order_details', compact('order'));
})->name('customer.orders.show');

// Customer Cart Update Route
Route::post('/customer/cart/update/{product}', function ($productId, \Illuminate\Http\Request $request) {
    $cart = session()->get('cart', []);
    foreach ($cart as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] = max(1, (int) $request->input('quantity', 1));
            break;
        }
    }
    session(['cart' => $cart]);
    return redirect()->back()->with('success', 'Cart updated!');
})->name('customer.cart.update');

// Customer Cart Remove Route
Route::post('/customer/cart/remove/{product}', function ($productId) {
    $cart = session()->get('cart', []);
    $cart = array_filter($cart, function ($item) use ($productId) {
        return $item['id'] != $productId;
    });
    session(['cart' => array_values($cart)]);
    return redirect()->back()->with('success', 'Item removed from cart!');
})->name('customer.cart.remove');

// Customer Cart Checkout Route
Route::post('/customer/cart/checkout', function () {
    session()->forget('cart');
    return redirect()->route('customer.cart')->with('success', 'Checkout complete! Thank you for your order.');
})->name('customer.cart.checkout');
