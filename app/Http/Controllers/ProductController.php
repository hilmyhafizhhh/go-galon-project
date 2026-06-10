<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\Address;
use App\Services\RecommendationService;

class ProductController extends Controller
{
    public function index(RecommendationService $recommender)
    {
        $products = Product::where('stock', '>=', 0)
            ->whereNull('deleted_at')
            ->orderBy('name')
            ->get();
    
        $defaultAddress = auth()->user()
            ->addresses()
            ->where('is_default', true)
            ->first();
    
        $activeOrder = Order::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'confirmed', 'on_delivery'])
            ->with('courier.user')
            ->latest()
            ->first();
    
        $totalActiveItems = $activeOrder
            ? $activeOrder->items()->sum('quantity')
            : 0;
    
        // ── REKOMENDASI ─────────────────────────────────────────────
        // Otomatis: CBF untuk returning user, Rule-Based untuk cold start
        $recommended = $recommender->recommend(auth()->id(), 3);
        // ────────────────────────────────────────────────────────────
    
        return view('customer.home', compact(
            'products',
            'defaultAddress',
            'activeOrder',
            'totalActiveItems',
            'recommended',          // ← tambahkan ini
        ));
    }
}
