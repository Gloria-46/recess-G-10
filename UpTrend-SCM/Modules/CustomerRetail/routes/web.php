<?php

use Illuminate\Support\Facades\Route;
use Modules\CustomerRetail\App\Http\Controllers\Retailer\DashboardController;
use Modules\CustomerRetail\App\Http\Controllers\Retailer\ProductController;
use Modules\CustomerRetail\App\Http\Controllers\Retailer\OrderController;
use Modules\CustomerRetail\App\Http\Controllers\Retailer\ProfileController;
use Modules\CustomerRetail\App\Http\Controllers\Retailer\InventoryController;
use Modules\CustomerRetail\App\Http\Controllers\Customer\MessageController;
use Modules\CustomerRetail\App\Http\Controllers\Retailer\MessageController as RetailMessageController;
use Illuminate\Http\Request;
use Modules\CustomerRetail\App\Models\Retailer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Modules\CustomerRetail\App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Modules\CustomerRetail\App\Models\Order;
use Illuminate\Support\Facades\DB;
use Modules\CustomerRetail\Http\Controllers\CustomerRetailController;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('customerretails', CustomerRetailController::class)->names('customerretail');
});

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
        Route::get('analytics', [\Modules\CustomerRetail\App\Http\Controllers\Retailer\AnalyticsController::class, 'index'])->name('analytics');
        Route::get('analytics/trends', [\Modules\CustomerRetail\App\Http\Controllers\Retailer\AnalyticsController::class, 'trends'])->name('analytics.trends');
    });
});

// Redirect root to retailer login
Route::get('/', function () {
    return redirect()->route('lead');
});

// Main login form (shared for both customers and retailers)
Route::get('/login', function () {
    return view('customerretail::auth.login');
})->name('login');

// Main login POST handler
Route::post('/login', function (Request $request) {
    \Log::info('MODULE CUSTOMER LOGIN ROUTE HIT');
    $credentials = $request->only('email', 'password');

    if (Auth::guard('retailer')->attempt($credentials)) {
        $request->session()->regenerate();
        \Log::info('Logged in as retailer');
        \Log::info('Default Auth::check(): ' . (Auth::check() ? 'YES' : 'NO'));
        \Log::info('Customer Auth::guard(\'customer\')->check(): ' . (Auth::guard('web')->check() ? 'YES' : 'NO'));
        return redirect()->intended(route('retailer.dashboard'));
    }

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        \Log::info('Logged in as customer');
        \Log::info('Default Auth::check(): ' . (Auth::check() ? 'YES' : 'NO'));
        \Log::info('Customer Auth::guard(\'customer\')->check(): ' . (Auth::guard('web')->check() ? 'YES' : 'NO'));
        return redirect()->intended(route('customer.home'));
    }

    \Log::info('Login failed');
    return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
})->name('login.submit');

// Logout route for both guards
Route::post('/logout', function (Request $request) {
    Auth::guard('retailer')->logout();
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/customer/login');
})->name('logout');

// Removed all routes that reference Customer\PageController and Customer\AuthController
// Customer Logout (outside middleware so it's always accessible)
Route::post('/customer/logout', function() {
    Auth::guard('web')->logout();
    return redirect()->route('customer.home');
})->name('customer.logout');
Route::get('/customer/signup', [Modules\CustomerRetail\App\Http\Controllers\Customer\SignupController::class, 'show'])->name('customer.signup');
Route::post('/customer/signup', [Modules\CustomerRetail\App\Http\Controllers\Customer\SignupController::class, 'register'])->name('customer.signup.submit');

// Payment Routes
// Route::get('/customer/payment', [App\Http\Controllers\Customer\PaymentController::class, 'showPaymentForm'])->name('customer.payment.form');
// Route::post('/customer/payment/mobile-money', [App\Http\Controllers\Customer\PaymentController::class, 'processMobileMoney'])->name('customer.payment.mobile-money');
// Route::post('/customer/payment/visa-card', [App\Http\Controllers\Customer\PaymentController::class, 'processVisaCard'])->name('customer.payment.visa-card');
// Route::get('/customer/payment/status/{payment}', [App\Http\Controllers\Customer\PaymentController::class, 'showPaymentStatus'])->name('customer.payment.status');
// Route::get('/customer/payment/check-status/{payment}', [App\Http\Controllers\Customer\PaymentController::class, 'checkPaymentStatus'])->name('customer.payment.check-status');
// Route::post('/customer/payment/cancel/{payment}', [App\Http\Controllers\Customer\PaymentController::class, 'cancelPayment'])->name('customer.payment.cancel');

Route::get('/lead', [Modules\CustomerRetail\App\Http\Controllers\LeadController::class, 'index'])->name('lead');

Route::post('retailer/logout', function (\Illuminate\Http\Request $request) {
    Auth::guard('retailer')->logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/'); // Redirect to home or login page
})->name('retailer.logout');

// Retailer Login Form
Route::get('/retailer/login', function () {
    return view('auth.signin');
})->name('retailer.login');

// Retailer Login POST
// Route::post('retailer/login', function (Request $request) {
//     $credentials = $request->only('email', 'password');
//     if (Auth::guard('retailer')->attempt($credentials)) {
//         $request->session()->regenerate();
//         return redirect()->intended(route('retailer.dashboard'));
//     }
//     return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
// })->name('retailer.login.submit');

// Retailer Forgot Password Form
Route::get('retailer/forgot-password', function () {
    return view('customerretail::retailer.auth.forgot-password');
})->name('retailer.password.request');

// Retailer Send Reset Link (dummy)
Route::post('retailer/forgot-password', function (\Illuminate\Http\Request $request) {
    // Implement sending email logic here if needed
    return back()->with('status', 'If your email exists in our system, a reset link has been sent.');
})->name('retailer.password.email');

// Retailer Reset Password Form
Route::get('retailer/reset-password/{token}', function ($token) {
    $email = request('email');
    return view('customerretail::retailer.auth.reset-password', ['token' => $token, 'email' => $email]);
})->name('retailer.password.reset');

// Retailer Reset Password POST (dummy)
Route::post('retailer/reset-password', function (\Illuminate\Http\Request $request) {
    // Implement password reset logic here if needed
    return redirect()->route('customerretail::retailer.login')->with('status', 'Your password has been reset!');
})->name('retailer.password.update');

// Customer Home/Dashboard Route (accessible to both guests and authenticated users)
Route::get('/customer/dashboard', function () {
    $mostViewed = \Modules\CustomerRetail\App\Models\Product::orderByDesc('views')->take(6)->get();
    $mostOrdered = \Modules\CustomerRetail\App\Models\Product::withCount('orders')->orderByDesc('orders_count')->take(6)->get();
    $products = \Modules\CustomerRetail\App\Models\Product::all();
    $previouslyOrdered = collect();
    $recommendations = collect();

    if (Auth::guard('web')->check()) {
        $user = Auth::user();
        $previouslyOrdered = \Modules\CustomerRetail\App\Models\Product::whereIn('id', function($query) use ($user) {
            $query->select('product_id')
                ->from('customer_order_items')
                ->whereIn('order_id', function($q) use ($user) {
                    $q->select('id')
                        ->from('customer_orders')
                        ->where('user_id', $user->id);
                });
        })->get();

        // Fetch recommendations for the user
        $recommendationIds = DB::table('user_recommendations')
            ->where('user_id', $user->id)
            ->orderByDesc('score')
            ->limit(5)
            ->pluck('product_id');

        $recommendations = \Modules\CustomerRetail\App\Models\Product::whereIn('id', $recommendationIds)->get();

        return view('customerretail::customer.home', compact('mostViewed', 'mostOrdered', 'products', 'previouslyOrdered', 'recommendations'));
    } else {
        // For guests, you can show empty or generic recommendations
        return view('customerretail::customer.guest', compact('mostViewed', 'mostOrdered', 'products', 'previouslyOrdered', 'recommendations'));
    }
})->name('customer.dashboard');

// Alias route for customer.home (fixes RouteNotFoundException)
Route::get('/customer/home', function () {
    return redirect()->route('customer.dashboard');
})->name('customer.home');

// Customer products routes (accessible to both guests and authenticated users)
Route::get('/customer/products', function (\Illuminate\Http\Request $request) {
    $category = $request->query('category');
    if ($category) {
        $products = \Modules\CustomerRetail\App\Models\Product::where('category', $category)->get();
    } else {
        $products = \Modules\CustomerRetail\App\Models\Product::all();
    }
    $user = Auth::guard('web')->user();
    $previouslyOrdered = collect();
    if ($user) {
        $previouslyOrdered = \Modules\CustomerRetail\App\Models\Product::whereIn('id', function($query) use ($user) {
            $query->select('product_id')
                ->from('customer_order_items')
                ->whereIn('order_id', function($q) use ($user) {
                    $q->select('id')
                        ->from('customer_orders')
                        ->where('user_id', $user->id);
                });
        })->get();
    }
    return view('customerretail::customer.products', compact('products', 'category', 'previouslyOrdered'));
})->name('customer.products');

Route::get('/customer/products/{product}', function ($productId) {
    $product = \Modules\CustomerRetail\App\Models\Product::findOrFail($productId);
    return view('customerretail::customer.product_details', compact('product'));
})->name('customer.products.show');

// Customer-only routes (require login)
Route::middleware(['auth'])->group(function () {

    Route::get('/customer/cart', function () {
        $cartItems = collect(session('cart', []));
        return view('customerretail::customer.cart', compact('cartItems'));
    })->name('customer.cart');

    Route::post('/customer/cart/add/{product}', function ($productId, \Illuminate\Http\Request $request) {
        $product = \Modules\CustomerRetail\App\Models\Product::findOrFail($productId);

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
        $product = \Modules\CustomerRetail\App\Models\Product::findOrFail($productId);
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

        $user = Auth::guard('web')->user();
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
        $firstProduct = \Modules\CustomerRetail\App\Models\Product::find($cartItems->first()['id']);
        $retailerId = $firstProduct ? $firstProduct->retailer_id : null;

        $order = \Modules\CustomerRetail\App\Models\Order::create([
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
        event(new \Modules\CustomerRetail\App\Events\OrderPlaced($order));

        // Trigger real-time recommendations update
        try {
            $process = new Symfony\Component\Process\Process(['python', base_path('ml_recommend.py')]);
            $process->start(); // async, does not block checkout
        } catch (\Exception $e) {
            // Optionally log error
        }

        foreach ($cartItems as $item) {
            \Modules\CustomerRetail\App\Models\OrderItem::create([
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
        $user = Auth::guard('web')->user();
        $orders = collect();
        if ($user) {
            $orders = \Modules\CustomerRetail\App\Models\Order::where('user_id', $user->id)->latest()->paginate(10);
        }
        return view('customerretail::customer.orders', compact('orders'));
    })->name('customer.orders');

    Route::get('/customer/orders/{order}', function ($orderId) {
        $user = Auth::guard('web')->user();
        $order = \Modules\CustomerRetail\App\Models\Order::where('id', $orderId)
            ->where('user_id', $user ? $user->id : null)
            ->firstOrFail();
        return view('customerretail::customer.order_details', compact('order'));
    })->name('customer.orders.show');

    // Customer Profile Route
    Route::get('/customer/profile', function () {
        $user = Auth::guard('web')->user();
        return view('customerretail::customer.profile', compact('user'));
    })->name('customer.profile');

    // Customer Profile Edit Route
    Route::get('/customer/profile/edit', function () {
        $user = Auth::guard('web')->user();
        return view('customerretail::customer.profile_edit', compact('user'));
    })->name('customer.profile.edit');

    // Customer Profile Update Route
    Route::post('/customer/profile/edit', function (\Illuminate\Http\Request $request) {
        $user = Auth::guard('web')->user();
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
        $products = \Modules\CustomerRetail\App\Models\Product::where('name', 'like', "%{$query}%")->get();
        return view('customerretail::customer.products', compact('products', 'query'));
    })->name('customer.products.search');
});

// Customer About Route
Route::get('/customer/about', function () {
    return view('customerretail::customer.about');
})->name('customer.about');

// Customer Login Form
Route::get('/customer/login', function () {
    return view('customerretail::customer.login');
})->name('customer.login');

// Customer Login POST
Route::post('/customer/login', function (Request $request) {
    \Log::info('MODULE CUSTOMER LOGIN ROUTE HIT');
    \Log::info('guards.customer: ' . print_r(config('auth.guards.customer'), true));
    \Log::info('providers.users: ' . print_r(config('auth.providers.users'), true));
    \Log::info('providers.customers: ' . print_r(config('auth.providers.customers'), true));
    $credentials = $request->only('email', 'password');
    if (Auth::guard('retailer')->attempt($credentials)) {
        $request->session()->regenerate();
        \Log::info('Logged in as retailer');
        \Log::info('Default Auth::check(): ' . (Auth::check() ? 'YES' : 'NO'));
        \Log::info('Customer Auth::guard(\'customer\')->check(): ' . (Auth::guard('web')->check() ? 'YES' : 'NO'));
        return redirect()->intended(route('retailer.dashboard'));
    }
    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        \Log::info('Logged in as customer');
        \Log::info('Default Auth::check(): ' . (Auth::check() ? 'YES' : 'NO'));
        \Log::info('Customer Auth::guard(\'customer\')->check(): ' . (Auth::guard('web')->check() ? 'YES' : 'NO'));
        return redirect()->intended(route('customer.home'));
    }
    \Log::info('Login failed');
    return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
})->name('customer.login.submit');



// Customer Contact Route
Route::get('/customer/contact', function () {
    return view('customerretail::customer.contact');
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

Route::get('/retailer/profile', [\Modules\CustomerRetail\App\Http\Controllers\Retailer\ProfileController::class, 'show'])->name('retailer.profile.show');
Route::get('/retailer/profile/edit', [\Modules\CustomerRetail\App\Http\Controllers\Retailer\ProfileController::class, 'edit'])->name('retailer.profile.edit');

Route::middleware(['auth:customer'])->get('/customer/recommendations', [\Modules\CustomerRetail\App\Http\Controllers\Customer\RecommendationController::class, 'index'])->name('customer.recommendations');

Route::middleware('auth')->group(function () {
    Route::post('/messages', [MessageController::class, 'store']);
    Route::post('/messages/{message}/read', [MessageController::class, 'markAsRead']);

    // Customer Chat Routes (require login)
    Route::get('/customer/chat', [\Modules\CustomerRetail\App\Http\Controllers\Customer\MessageController::class, 'index'])->name('customer.chat.index');
    Route::get('/customer/chat/{user}', [\Modules\CustomerRetail\App\Http\Controllers\Customer\MessageController::class, 'chatWithUser'])->name('customer.chat.with');
    Route::post('/customer/chat/send', [\Modules\CustomerRetail\App\Http\Controllers\Customer\MessageController::class, 'store'])->name('customer.chat.send');
    // Add any other chat-related routes here
});

// Retailer Chat Routes
Route::middleware('auth:retailer')->group(function () {
    Route::get('/retailer/chat', [\Modules\CustomerRetail\App\Http\Controllers\Retailer\MessageController::class, 'index'])->name('retailer.chat.index');
    Route::get('/retailer/chat/{user}', [\Modules\CustomerRetail\App\Http\Controllers\Retailer\MessageController::class, 'chatWithUser'])->name('retailer.chat.with');
});

// Customer message routes
Route::middleware('auth:customer')->get('/customer/messages', [\Modules\CustomerRetail\App\Http\Controllers\Customer\MessageController::class, 'index'])->name('customer.messages.index');
Route::middleware('auth:customer')->post('/customer/messages', [\Modules\CustomerRetail\App\Http\Controllers\Customer\MessageController::class, 'store'])->name('customer.messages.store');

// Retailer message routes
Route::middleware('auth:retailer')->get('/retailer/messages', [\Modules\CustomerRetail\App\Http\Controllers\Retailer\MessageController::class, 'index'])->name('retailer.messages.index');
Route::middleware('auth:retailer')->post('/retailer/messages', [\Modules\CustomerRetail\App\Http\Controllers\Retailer\MessageController::class, 'store'])->name('retailer.messages.store');

// Retailer Registration Form
Route::get('/retailer/register', function () {
    return view('customerretail::retailer.auth.register');
})->name('retailer.register');

// Retailer Registration POST
Route::post('/retailer/register', [\Modules\CustomerRetail\App\Http\Controllers\Customer\SignupController::class, 'register'])->name('retailer.register.submit');

Route::get('/customer/support', function () {
    return view('customerretail::customer.support');
})->name('customer.support');
