<?php

use App\Http\Controllers\AddressController;
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
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\CourierTaskController;
use App\Http\Controllers\GpsSimulatorController;
use App\Models\Order;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;

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
    // Route::get('/dashboard', function () {
    //     return view('admin.dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/data', [DashboardController::class, 'getData'])->name('dashboard.data');

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


    Route::post('/orders/{id}/validate', [DashboardController::class, 'validateOrder'])->name('orders.validate');

    // ⚙️ Pengaturan
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');

    // ── Profile ──
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});


// Route Courier
Route::prefix('courier')->middleware(['auth', 'verified', 'role:courier'])->name('courier.')->group(function () {

    Route::get('/home', [CourierTaskController::class, 'index'])->name('home');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/user/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'sendChat'])->name('chat.send');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/tasks', [CourierTaskController::class, 'index'])->name('tasks');
    Route::post('/tasks/{taskId}/pickup',  [CourierTaskController::class, 'pickup'])->name('task.pickup');
    Route::post('/tasks/{taskId}/deliver', [CourierTaskController::class, 'deliver'])->name('task.deliver');
    Route::post('/tasks/{taskId}/start-delivery', [CourierTaskController::class, 'startDelivery']);


    // GPS update — dipanggil JS tiap ~5 detik saat status picked_up
    Route::post('/tasks/{taskId}/location', [CourierTaskController::class, 'updateLocation'])->name('tasks.location');
});

/*
|--------------------------------------------------------------------------
| Tracking publik — customer tanpa login, via order_code
|--------------------------------------------------------------------------
*/
Route::get('/track/{orderCode}', [CourierTaskController::class, 'trackingPage'])->name('tracking.show');

/*
|--------------------------------------------------------------------------
| API Polling — dipanggil JS dari halaman tracking tiap N detik
| Menggunakan {order} = UUID dari orders.id
|--------------------------------------------------------------------------
*/
Route::get('/api/tracking/{order}', [CourierTaskController::class, 'trackingData'])->name('api.tracking');

/*
|--------------------------------------------------------------------------
| GPS Simulator — Demo / TA only
| Akses: /simulator
|--------------------------------------------------------------------------
*/
Route::prefix('simulator')
    ->middleware(['auth', 'verified'])  // cukup auth, tidak perlu role tertentu
    ->name('simulator.')
    ->group(function () {
        Route::get('/',           [GpsSimulatorController::class, 'index'])->name('index');
        Route::get('/route',      [GpsSimulatorController::class, 'getRoute'])->name('route');
        Route::post('/inject',    [GpsSimulatorController::class, 'injectPoint'])->name('inject');
    });

// Route Customer
Route::prefix('customer')->middleware(['auth', 'verified', 'role:customer'])->name('customer.')->group(function () {
    Route::get('/home', [ProductController::class, 'index'])->name('home');

    // Route::get('/order', function () {
    //     return view('customer.order');
    // })->name('order');
    Route::get('/order', [CustomerOrderController::class, 'index'])->name('order');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/order/status', [CustomerOrderController::class, 'getStatus'])->name('order.status');

    // Route::get('/chat/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    // Route::post('/chat/send', [ChatController::class, 'sendChat'])->name('chat.send');
    Route::get('/chat/user/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'sendChat'])->name('chat.send');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/select-item', [CartController::class, 'selectItem']);
    Route::post('/cart/update-qty', [CartController::class, 'updateQty'])->name('cart.update-qty');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');


    // addres
    Route::get('/address/create', [AddressController::class, 'create'])->name('address.create');
    Route::get('/address/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::post('/address/store', [AddressController::class, 'store'])->name('address.store');


    // route untuk chechout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/address-picker', [CheckoutController::class, 'addressPicker'])
        ->name('checkout.address-picker');
    Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])
        ->name('checkout.success');

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

    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/remove', [CartController::class, 'removeBulk'])->name('cart.remove.bulk');

    // ── Profile ──
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // ── Alamat ──────────────────────────────────────────────────────────────
    Route::get('/address/create',              [AddressController::class, 'create'])->name('address.create');
    Route::post('/address',                    [AddressController::class, 'store'])->name('address.store');
    Route::get('/address/{address}/edit',      [AddressController::class, 'edit'])->name('address.edit');
    Route::put('/address/{address}',           [AddressController::class, 'update'])->name('address.update');
    Route::patch('/address/{address}/default', [AddressController::class, 'setDefault'])->name('address.default');
    Route::delete('/address/{address}',        [AddressController::class, 'destroy'])->name('address.destroy');
    Route::delete('/address/{address}',  [AddressController::class, 'destroy'])->name('address.destroy');
    Route::get('/address/select', [AddressController::class, 'select'])->name('address.select');
});

// ── API STOCK REALTIME ─────────────────────────────
Route::get('/api/products/stock', function () {

    return \App\Models\Product::select(
        'id',
        'stock'
    )->get();
});


// pmidtrans
Route::post('/payment/{order}/create', [PaymentController::class, 'createPayment'])->name('payment.create');
Route::post('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback')->withoutMiddleware(VerifyCsrfToken::class);;

// Route Google OAuth
Route::get('/auth/google/redirect', [ProviderController::class, 'redirect']);
Route::get('/auth/google/callback', [ProviderController::class, 'callback']);

require __DIR__ . '/auth.php';
