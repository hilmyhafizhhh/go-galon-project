<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'draf');

        $statusMap = [
            'riwayat' => ['delivered', 'completed'],
            'dalam'   => ['processing', 'shipping'],
            'draf'    => ['draft', 'pending', 'confirmed'],
            'batal'   => ['cancelled'],
        ];

        $orders = Order::with(['items.product', 'address'])
            ->where('user_id', auth()->id())
            ->whereIn('status', $statusMap[$activeTab] ?? [])
            ->latest()
            ->get();

        $countByTab = [];
        foreach ($statusMap as $tab => $statuses) {
            $countByTab[$tab] = Order::where('user_id', auth()->id())
                ->whereIn('status', $statuses)
                ->count();
        }

        return view('customer.order', compact('orders', 'activeTab', 'countByTab'));
    }
}
