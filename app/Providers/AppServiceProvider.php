<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         // 🔹 Broadcast (punya kamu)
    Broadcast::routes([
        'middleware' => ['web', 'auth'],
    ]);

    // 🔹 Cart Count (tambahan kita)
    View::composer('*', function ($view) {
        $count = 0;

        if (Auth::check()) {
            $order = Order::with('items')
                ->where('user_id', Auth::id())
                ->where('status', 'draft')
                ->first();

            if ($order) {
                $count = $order->items->sum('quantity');
            }
        }

        $view->with('cartCount', $count);
    });

    require base_path('routes/channels.php');
    }
}
