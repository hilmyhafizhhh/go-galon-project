<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Address;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('stock', '>', 0)->get();

        // Ambil pesanan aktif terakhir pelanggan
        $activeOrder = Order::with(['items.product', 'address', 'courier.user'])
            ->where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'confirmed', 'on_delivery'])
            ->latest()
            ->first();

        // Ambil alamat default pelanggan
        $defaultAddress = Address::where('user_id', auth()->id())
            ->where('is_default', true)
            ->first();

        // Hitung total item aktif
        $totalActiveItems = $activeOrder
            ? $activeOrder->items->sum('quantity')
            : 0;

        return view('customer.home', compact(
            'products',
            'activeOrder',
            'defaultAddress',
            'totalActiveItems'
        ));
    }
}
