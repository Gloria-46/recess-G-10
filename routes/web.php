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
use Illuminate\Support\Facades\DB;

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
// Route::get('/customer/payment', [App\Http\Controllers\Customer\PaymentController::class, 'showPaymentForm'])->name('customer.payment.form');
// Route::post('/customer/payment/mobile-money', [App\Http\Controllers\Customer\PaymentController::class, 'processMobileMoney'])->name('customer.payment.mobile-money');
// Route::post('/customer/payment/visa-card', [App\Http\Controllers\Customer\PaymentController::class, 'processVisaCard'])->name('customer.payment.visa-card');
// Route::get('/customer/payment/status/{payment}', [App\Http\Controllers\Customer\PaymentController::class, 'showPaymentStatus'])->name('customer.payment.status');
// Route::get('/customer/payment/check-status/{payment}', [App\Http\Controllers\Customer\PaymentController::class, 'checkPaymentStatus'])->name('customer.payment.check-status');
// Route::post('/customer/payment/cancel/{payment}', [App\Http\Controllers\Customer\PaymentController::class, 'cancelPayment'])->name('customer.payment.cancel');

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
    $user = Auth::guard('customer')->user();
    $previouslyOrdered = collect();
    $recommendations = collect();
    if ($user) {
        $previouslyOrdered = \App\Models\Product::whereIn('id', function($query) use ($user) {
            $query->select('product_id')
                ->from('order_items')
                ->whereIn('order_id', function($q) use ($user) {
                    $q->select('id')
                        ->from('orders')
                        ->where('user_id', $user->id);
                });
        })->get();

        // Fetch recommendations for the user
        $recommendationIds = DB::table('user_recommendations')
            ->where('user_id', $user->id)
            ->orderByDesc('score')
            ->limit(5)
            ->pluck('product_id');

        $recommendations = Product::whereIn('id', $recommendationIds)->get();
    }
    return view('customer.home', compact('mostViewed', 'mostOrdered', 'products', 'previouslyOrdered', 'recommendations'));
})->name('customer.home');

// Customer Products Route
Route::get('/customer/products', function (\Illuminate\Http\Request $request) {
    $category = $request->query('category');
    if ($category) {
        $products = \App\Models\Product::where('category', $category)->get();
    } else {
        $products = \App\Models\Product::all();
    }
    $user = Auth::guard('customer')->user();
    $previouslyOrdered = collect();
    if ($user) {
        $previouslyOrdered = \App\Models\Product::whereIn('id', function($query) use ($user) {
            $query->select('product_id')
                ->from('order_items')
                ->whereIn('order_id', function($q) use ($user) {
                    $q->select('id')
                        ->from('orders')
                        ->where('user_id', $user->id);
                });
        })->get();
    }
    return view('customer.products', compact('products', 'category', 'previouslyOrdered'));
})->name('customer.products');

// Customer Product Details Route
Route::get('/customer/products/{product}', function ($productId) {
    $product = \App\Models\Product::findOrFail($productId);
    return view('customer.product_details', compact('product'));
})->name('customer.products.show');

// Customer Cart Routes (restricted to logged-in customers)
Route::middleware(['auth:customer'])->group(function () {
Route::get('/customer/cart', function () {
    $cartItems = collect(session('cart', []));
    return view('customer.cart', compact('cartItems'));
})->name('customer.cart');

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

        $successMsg = 'Product added to cart! <a href="' . route('customer.cart') . '" class="underline text-blue-700 font-semibold ml-2">View Cart</a>';
        return redirect()->back()->with('success', $successMsg);
    })->name('customer.cart.add');

    Route::post('/customer/cart/bulk-add/{product}', function ($productId, \Illuminate\Http\Request $request) {
        $product = \App\Models\Product::findOrFail($productId);
        $cart = session()->get('cart', []);
        $quantities = $request->input('quantities', []);

        foreach ($quantities as $size => $colors) {
            foreach ($colors as $color => $qty) {
                $qty = (int)$qty;
                if ($qty > 0) {
                    $cart[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'size' => $size,
                        'color' => $color,
                        'quantity' => $qty,
                        'image' => $product->image,
                    ];
                }
            }
        }

        session(['cart' => $cart]);
        $successMsg = 'Products added to cart! <a href="' . route('customer.cart') . '" class="underline text-blue-700 font-semibold ml-2">View Cart</a>';
        return redirect()->back()->with('success', $successMsg);
    })->name('customer.cart.bulkAdd');

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

    Route::post('/customer/cart/remove/{product}', function ($productId) {
        $cart = session()->get('cart', []);
        $cart = array_filter($cart, function ($item) use ($productId) {
            return $item['id'] != $productId;
        });
        session(['cart' => array_values($cart)]);
        return redirect()->back()->with('success', 'Item removed from cart!');
    })->name('customer.cart.remove');

    Route::post('/customer/cart/checkout', function (\Illuminate\Http\Request $request) {
        $cartItems = collect(session('cart', []));
        if ($cartItems->isEmpty()) {
            return redirect()->route('customer.cart')->with('error', 'Your cart is empty.');
        }

        $user = Auth::guard('customer')->user();
        if (!$user) {
            return redirect()->route('customer.login')->with('error', 'You must be logged in to place an order.');
        }
        $customerName = $user->name;
        $customerEmail = $user->email;
        $shippingAddress = $user->address ?: $request->input('shipping_address');
        $totalAmount = $cartItems->sum(function($item) {
            return $item['price'] * ($item['quantity'] ?? 1);
        });

        // Assume all products in cart belong to the same retailer (first product's retailer)
        $firstProduct = \App\Models\Product::find($cartItems->first()['id']);
        $retailerId = $firstProduct ? $firstProduct->retailer_id : null;

        $order = \App\Models\Order::create([
            'retailer_id' => $retailerId,
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'customer_name' => $customerName,
            'customer_email' => $customerEmail,
            'shipping_address' => $shippingAddress,
            'total_amount' => $totalAmount,
            'status' => 'pending',
        ]);

        // Fire event for real-time segmentation
        event(new \App\Events\OrderPlaced($order));

        // Trigger real-time recommendations update
        try {
            $process = new Symfony\Component\Process\Process(['python', base_path('ml_recommend.py')]);
            $process->start(); // async, does not block checkout
        } catch (\Exception $e) {
            // Optionally log error
        }

        foreach ($cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'] ?? 1,
                'price' => $item['price'],
            ]);
        }

        session()->forget('cart');
        return redirect()->route('customer.cart')->with('success', 'Checkout complete! Thank you for your order.');
    })->name('customer.cart.checkout');

    Route::get('/customer/orders', function () {
        $user = Auth::guard('customer')->user();
        $orders = collect();
        if ($user) {
            $orders = \App\Models\Order::where('user_id', $user->id)->latest()->paginate(10);
        }
        return view('customer.orders', compact('orders'));
    })->name('customer.orders');

    Route::get('/customer/orders/{order}', function ($orderId) {
        $user = Auth::guard('customer')->user();
        $order = \App\Models\Order::where('id', $orderId)
            ->where('user_id', $user ? $user->id : null)
            ->firstOrFail();
        return view('customer.order_details', compact('order'));
    })->name('customer.orders.show');
});

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

Route::get('/retailer/profile', [\App\Http\Controllers\Retailer\ProfileController::class, 'show'])->name('retailer.profile.show');
Route::get('/retailer/profile/edit', [\App\Http\Controllers\Retailer\ProfileController::class, 'edit'])->name('retailer.profile.edit');

Route::middleware(['auth:customer'])->get('/customer/recommendations', [\App\Http\Controllers\Customer\RecommendationController::class, 'index'])->name('customer.recommendations');
