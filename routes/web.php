<?php

use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CourierController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Models\Order;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

Route::get('/', function () {
    return redirect('/login');
});

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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
        $today = Carbon::today();

        // Ambil tugas kurir yang login, hanya hari ini
        $tasks = Task::with(['order.customer', 'customer'])
            ->where('courier_id', Auth::id())
            ->where(function ($query) use ($today) {
                $query->whereDate('created_at', $today)
                    ->orWhereDate('pickup_date', $today);
            })
            ->latest()
            ->get();
        // Hitung statistik
        $todayTasks     = $tasks->count();
        $completedToday = $tasks->where('status', 'completed')->count();
        $pendingToday   = $tasks->whereIn('status', ['pending', 'picked_up'])->count();
        return view('courier.home', compact(
            'tasks',
            'todayTasks',
            'completedToday',
            'pendingToday'
        ));
    })->name('home');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    // Route::get('/chat/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    // Route::post('/chat/send', [ChatController::class, 'sendChat'])->name('chat.send');
    Route::get('/chat/user/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'sendChat'])->name('chat.send');


    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile');

    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});

// Route Customer
Route::prefix('customer')->middleware(['auth', 'verified', 'role:customer'])->name('customer.')->group(function () {
    Route::get('/home', [ProductController::class, 'index'])->name('home');

    Route::get('/order', function () {
        return view('customer.order');
    })->name('order');

    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    // Route::get('/chat/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    // Route::post('/chat/send', [ChatController::class, 'sendChat'])->name('chat.send');
    Route::get('/chat/user/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'sendChat'])->name('chat.send');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // cart count untuk navbar
    Route::get('/cart/count', function () {
        $order = Order::where('user_id', auth()->id())
            ->where('status', 'draft')
            ->first();

        $count = $order
            ? $order->items()->sum('quantity')
            : 0;

        return response()->json([
            'count' => $count
        ]);
    });
});

// Route Google OAuth
Route::get('/auth/google/redirect', [ProviderController::class, 'redirect']);
Route::get('/auth/google/callback', [ProviderController::class, 'callback']);

require __DIR__ . '/auth.php';
