<?php

use App\Http\Controllers\Auth\ProviderController;
// use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return redirect('/login');
});


// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// // Pesanan
// Route::get('/pesanan', function () {
//     return view('pesanan');
// })->middleware(['auth'])->name('pesanan');


// cart
// Route::middleware(['auth'])->group(function () {
//     Route::get('/cart', [CartController::class, 'index'])->name('cart');
// });

// Chat
Route::get('/chat', function () {
    return view('chat');
})->middleware(['auth'])->name('chat');

// Profile routes
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Group route khusus customer
// Route::middleware(['auth'])->prefix('customer')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'index'])->name('customer.profile');
//     Route::post('/profile/update', [ProfileController::class, 'update'])->name('customer.profile.update');
// });
// Route Admin
Route::prefix('admin')->middleware(['auth', 'verified', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // 🧾 Pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');

    // 🚴 Kurir
    // Route::get('/couriers', [CourierController::class, 'index'])->name('couriers');
    Route::resource('couriers', CourierController::class);

    // 📦 Inventory
    // Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    Route::resource('inventory', InventoryController::class)
        ->names('inventory');

    // 📊 Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/orders', [ReportController::class, 'orders'])->name('reports.orders');
    Route::get('/reports/couriers', [ReportController::class, 'couriers'])->name('reports.couriers');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');


    // ⚙️ Pengaturan
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
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

    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'sendChat'])->name('chat.send');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// Route Google OAuth
Route::get('/auth/google/redirect', [ProviderController::class, 'redirect']);
Route::get('/auth/google/callback', [ProviderController::class, 'callback']);

require __DIR__ . '/auth.php';
