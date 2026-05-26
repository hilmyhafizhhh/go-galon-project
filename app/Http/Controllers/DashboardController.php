<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Courier; //tambahan
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function getData()
    {
        $today = Carbon::today();

        $totalOrders = Order::count();

        $todayIncome = Order::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        $activeOrders = Order::whereIn('status', [
            // 'draft', //tambahan
            'pending',
            'confirmed',
            'assigned',
            'delivering'
        ])->count();

        // $courierOnline = User::role('courier')
        //     ->where('is_online', true)
        //     ->count();

        // $totalCourier = User::role('courier')->count();
        $courierOnline = Courier::where('status', 'available')->count();
        $totalCourier = Courier::count();

        $orders = Order::with(['user', 'courier.user', 'items.product'])
            ->latest()
            ->take(10)
            ->get();

        $activeCouriers = Courier::with('user') //tambahan
            ->where('status', 'available')
            ->take(5)
            ->get();
        
        $products = Product::orderBy('stock', 'asc') //tambahan
            ->take(5)
            ->get();

        return response()->json([
            'totalOrders' => $totalOrders,
            'todayIncome' => number_format($todayIncome, 0, ',', '.'),
            'activeOrders' => $activeOrders,
            'courierOnline' => $courierOnline,
            'totalCourier' => $totalCourier,
            'orders' => $orders,
            'activeCouriers' => $activeCouriers, //tambahan
            'products' => $products //tambahan
        ]);
    }
}