<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
// use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\ProductionStageController;

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

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/tables', function () {
    return view('tables');
})->name('tables')->middleware('auth');

Route::get('/wallet', function () {
    return view('wallet');
})->name('wallet')->middleware('auth');

Route::get('/RTL', function () {
    return view('RTL');
})->name('RTL')->middleware('auth');

Route::get('/profile', function () {
    return view('account-pages.profile');
})->name('profile')->middleware('auth');

Route::get('/signin', function () {
    return view('account-pages.signin');
})->name('signin');

Route::get('/signup', function () {
    return view('account-pages.signup');
})->name('signup')->middleware('guest');

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

Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile')->middleware('auth');
Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update')->middleware('auth');
Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management')->middleware('auth');
// Route::get('/chat', [ChatController::class, 'index']);
// Route::post('/chat/send', [ChatController::class, 'send']);
// Route::get('/chat/fetch', [ChatController::class, 'fetch']);

// Route::middleware('auth')->group(function () {
//     Route::get('/chat/{userId}', [ChatController::class, 'showChat'])->name('chat');
//     Route::post('/chat/send', [ChatController::class, 'send']);
// });
Route::middleware('auth')->group(function () {
    Route::post('/messages', [MessageController::class, 'store']);
    Route::post('/messages/{message}/read', [MessageController::class, 'markAsRead']);
});

Route::middleware('auth')->group(function () {
    Route::get('/chat', [MessageController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [MessageController::class, 'chatWithUser'])->name('chat.with');
});

// Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::middleware('auth')->post('/messages', [MessageController::class, 'store'])->name('messages.store');

// Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
// Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');

// Route::get('/staff/assign', [StaffController::class, 'showAssignmentForm'])->name('staff.assign.form');
// Route::post('/staff/assign', [StaffController::class, 'assignStages'])->name('staff.assign');

Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');

Route::resource('stages', App\Http\Controllers\ProductionStageController::class);
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

