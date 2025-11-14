<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Courier;
use App\Models\Product;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function orders()
    {
        $orders = Order::with('product')->latest()->get();
        return view('admin.reports.orders', compact('orders'));
    }

    public function couriers()
    {
        $couriers = Courier::with(['user', 'assignedOrders'])->get();
        return view('admin.reports.couriers', compact('couriers'));
    }

    public function inventory()
    {
        $products = Product::all();
        return view('admin.reports.inventory', compact('products'));
    }
}
