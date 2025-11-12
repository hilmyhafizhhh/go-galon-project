<?php

use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    // return view('welcome');
    return redirect('/login');
});


// // Dashboard
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// // Pesanan
// Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');

// // Kurir
// Route::get('/couriers', [CourierController::class, 'index'])->name('couriers.index');

// // Inventory
// Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');

// // Laporan
// Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

// // Pengaturan
// Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

// // Pesanan
// Route::get('/pesanan', function () {
//     return view('pesanan');
// })->middleware(['auth'])->name('pesanan');

// Chat
Route::get('/chat', function () {
    return view('chat');
})->middleware(['auth'])->name('chat');

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

     // 🧾 Pesanan
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');

        // 🚴 Kurir
    Route::get('/couriers', [CourierController::class, 'index'])->name('couriers');

        // 📦 Inventory
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');

        // 📊 Laporan
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');

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
});

// Route Google OAuth
Route::get('/auth/google/redirect', [ProviderController::class, 'redirect']);
Route::get('/auth/google/callback', [ProviderController::class, 'callback']);

require __DIR__ . '/auth.php';
