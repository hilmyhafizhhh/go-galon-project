<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'pending');

        $statusMap = [
            'pending'   => ['pending', 'confirmed'], // Menunggu konfirmasi + sudah dikonfirmasi
            'shipping'  => ['on_delivery'],           // Sedang dikirim
            'completed' => ['completed'],             // Selesai
            'cancelled' => ['cancelled'],             // Dibatalkan
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

    public function getStatus(Request $request)
    {
        $activeTab = $request->get('tab', 'pending');

        $statusMap = [
            'pending'   => ['pending', 'confirmed'],
            'shipping'  => ['on_delivery'],
            'completed' => ['completed'],
            'cancelled' => ['cancelled'],
        ];

        $orders = Order::where('user_id', auth()->id())
            ->whereIn('status', $statusMap[$activeTab] ?? [])
            ->latest()
            ->get()
            ->map(fn($o) => [
                'id'           => $o->id,
                'status'       => $o->status,
                'queue_number' => $o->queue_number,
            ]);

        $countByTab = [];
        foreach ($statusMap as $tab => $statuses) {
            $countByTab[$tab] = Order::where('user_id', auth()->id())
                ->whereIn('status', $statuses)
                ->count();
        }

        return response()->json([
            'orders'     => $orders,
            'countByTab' => $countByTab,
        ]);
    }
}
