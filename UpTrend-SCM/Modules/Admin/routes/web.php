<?php

use Illuminate\Support\Facades\Route;
use Modules\Admin\Http\Controllers\UserController;
use Modules\Admin\Http\Controllers\MessageController;
use Modules\Admin\Http\Controllers\Auth\RegisterController;
use Modules\Admin\Http\Controllers\Auth\ResetPasswordController;
use Modules\Admin\Http\Controllers\Auth\ForgotPasswordController;
use Modules\Admin\Http\Controllers\StaffController;
use Modules\Admin\Http\Controllers\ProductionStageController;
use Modules\Admin\Http\Controllers\AdminController;
use Modules\Admin\Http\Controllers\Auth\LoginController;
use Modules\Admin\Http\Controllers\ProfileController;
use Modules\Admin\Http\Controllers\AllowedEmailController;
use Modules\CustomerRetail\App\Models\OrderItem as RetailOrderItem;
use Modules\CustomerRetail\App\Models\Product as RetailProduct;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('admins', AdminController::class)->names('admin');

    Route::get('/admin/dashboard', function () {
        $user = auth()->user();

        // Warehouse
        $warehouseProducts = Modules\Warehouse\App\Models\Product::select('name', 'quantity')->get();
        $warehouseProductCount = $warehouseProducts->count();
        $warehouseOrders = Modules\Warehouse\App\Models\Order::latest()->take(10)->get();
        $warehouseQuarterlySales = Modules\Warehouse\App\Models\Order::selectRaw('YEAR(created_at) as year, QUARTER(created_at) as quarter, SUM(total) as total')
            ->groupBy('year', 'quarter')
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();
        // CustomerRetail Featured Products for cards
        $retailFeaturedProducts = Modules\CustomerRetail\App\Models\Product::select('name', 'category', 'image')->take(5)->get();
        $retailFeaturedProductCount = $retailFeaturedProducts->count();

        // Vendor
        $vendorProducts = Modules\Vendor\App\Models\Product::select('name', 'quantity')->get();
        $vendorProductCount = $vendorProducts->count();
        $vendorOrders = Modules\Vendor\App\Models\Order::latest()->take(10)->get();
        $vendorQuarterlySales = Modules\Vendor\App\Models\Order::selectRaw('YEAR(created_at) as year, QUARTER(created_at) as quarter, SUM(grand_total) as total')
            ->groupBy('year', 'quarter')
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        // CustomerRetail
        $retailProducts = Modules\CustomerRetail\App\Models\Product::select('name', 'current_stock')->get();
        $retailProductCount = $retailProducts->count();
        $retailOrders = Modules\CustomerRetail\App\Models\Order::latest()->take(10)->get();
        $retailQuarterlySales = Modules\CustomerRetail\App\Models\Order::selectRaw('YEAR(created_at) as year, QUARTER(created_at) as quarter, SUM(total_amount) as total')
            ->groupBy('year', 'quarter')
            ->orderBy('year', 'desc')
            ->orderBy('quarter', 'desc')
            ->get();

        // 6 Best Selling Retail Products
        $retailBestSellingProducts = RetailOrderItem::select('product_id', \DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(6)
            ->with(['product' => function($q) { $q->select('id', 'name', 'category', 'image'); }])
            ->get()
            ->map(function($item) { return $item->product ? (object)[
                'name' => $item->product->name,
                'category' => $item->product->category,
                'image' => $item->product->image,
                'total_sold' => $item->total_sold
            ] : null; })
            ->filter();

        return view('admin::dashboard', compact(
            'user',
            'warehouseProducts', 'warehouseProductCount', 'warehouseOrders', 'warehouseQuarterlySales',
            'vendorProducts', 'vendorProductCount', 'vendorOrders', 'vendorQuarterlySales',
            'retailProducts', 'retailProductCount', 'retailOrders', 'retailQuarterlySales',
            'retailFeaturedProducts', 'retailFeaturedProductCount', 'retailBestSellingProducts'
        ));
    })->name('admin.dashboard');
        
    Route::get('/admin/profile', function () {
        return view('admin::account-pages.profile');
    })->name('admin.profile');

    Route::resource('allowed-emails', AllowedEmailController::class)->names('admin.allowed_emails');
});

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

Route::get('/profile', function () {
    return view('admin::account-pages.profile');
})->name('admin.profile');

Route::get('/profile', function () {
    return view('admin::account-pages.profile');
})->name('profile');

Route::get('/signin', function () {
    return view('auth.signin');
})->name('signin');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::get('/sign-up', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('sign-up');

Route::post('/sign-up', [RegisterController::class, 'store'])
    ->middleware('guest');

Route::get('/sign-in', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'store'])
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'store'])
    ->middleware('guest');

Route::get('/laravel-examples/user-profile', 
    [ProfileController::class, 'index'])->name('admin.users.profile');
Route::put('/laravel-examples/user-profile/update', 
    [ProfileController::class, 'update'])->name('admin.users.update');
Route::get('/laravel-examples/users-management', 
    [UserController::class, 'index'])->name('admin.users.management');

Route::middleware(['auth'])->group(function () {
    Route::post('/messages', [MessageController::class, 'store']);
    Route::post('/messages/{message}/read', [MessageController::class, 'markAsRead']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/chat', [MessageController::class, 'index'])->name('admin.chat.index');
    Route::get('/admin/chat/{user}', [MessageController::class, 'chatWithUser'])->name('admin.chat.with');
});

// Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::middleware(['auth'])->post('/admin/messages', [MessageController::class, 'store'])->name('admin.messages.store');
Route::middleware(['auth'])->get('/admin/messages', [MessageController::class, 'index'])->name('admin.messages.index');

Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');

Route::resource('stages', Modules\Admin\Http\Controllers\ProductionStageController::class);
Route::get('/stages/create', [ProductionStageController::class, 'create'])->name('stages.create');
Route::post('/stages/store', [ProductionStageController::class, 'store'])->name('stages.store');

Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
Route::get('/staff/auto-assign', [StaffController::class, 'autoAssign'])->name('staff.auto.assign');

// Staff CRUD
Route::get('/staff/{staff}/edit', [StaffController::class, 'edit'])->name('staff.edit');
Route::put('/staff/{staff}', [StaffController::class, 'update'])->name('staff.update');
Route::delete('/staff/{staff}', [StaffController::class, 'destroy'])->name('staff.destroy');

// Stages CRUD (resource already present, but ensure edit/update/destroy are available)
// Route::resource('stages', App\Http\Controllers\ProductionStageController::class); // already present
