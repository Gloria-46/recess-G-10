<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

// Set the welcome page as the default root route
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

use Illuminate\Support\Facades\Auth;

Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect('/');
    }

    switch ($user->role) {
        case 'admin':
            return redirect('/admin/dashboard');
        case 'vendor':
            return redirect('/vendor/dashboard');
        case 'warehouse':
            return redirect('/warehouse/dashboard');
        case 'retailer':
            return redirect('/retailer/dashboard');
        default:
            return redirect('/customer/dashboard'); // or a customer dashboard if you have one
    }
})->middleware(['auth'])->name('dashboard');
