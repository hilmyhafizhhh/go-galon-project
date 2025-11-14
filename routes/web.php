<?php

use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});


// // Dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Route Admin
// Route::get('admin', function() {
//     return view('admin.dashboard');
// })->middleware(['auth', 'verified', 'role:admin'])->name('admin');;

// Route Admin
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// Route Courier
Route::prefix('courier')->middleware(['auth', 'verified', 'role:courier'])->name('courier.')->group(function () {
    Route::get('/home', function () {
        return view('courier.home');
    })->name('home');
});

// Route Customer
Route::prefix('customer')->middleware(['auth', 'verified', 'role:customer'])->name('customer.')->group(function () {
    Route::get('/home', function () {
        return view('customer.home');
    })->name('home');

    Route::get('/order', function () {
        return view('customer.order');
    })->name('order');

    Route::get('/chat', function() {
        return view('customer.chat');
    })->name('chat');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    
    Route::get('/chat/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'sendChat'])->name('chat.send');;
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
});

// Route Google OAuth
Route::get('/auth/google/redirect', [ProviderController::class, 'redirect']);
Route::get('/auth/google/callback', [ProviderController::class, 'callback']);

require __DIR__ . '/auth.php';
