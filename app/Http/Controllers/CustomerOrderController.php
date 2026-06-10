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

        $orders = $orders->load(['items.product', 'address', 'task.courier']);


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

        $orders = Order::with('task.courier')  // ← tambah ini
            ->where('user_id', auth()->id())
            ->whereIn('status', $statusMap[$activeTab] ?? [])
            ->latest()
            ->get()
            ->map(fn($o) => [
                'id'           => $o->id,
                'status'       => $o->status,
                'queue_number' => $o->queue_number,
                'courier_name' => $o->task?->courier?->name,   // ← tambah ini
                'courier_id'   => $o->task?->courier?->id,     // ← tambah ini
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
    public function getFullStatus(Request $request)
    {
        $activeTab = $request->get('tab', 'pending');

        $statusMap = [
            'pending'   => ['pending', 'confirmed'],
            'shipping'  => ['on_delivery'],
            'completed' => ['completed'],
            'cancelled' => ['cancelled'],
        ];

        // Kalau tab=all, ambil semua order tanpa filter status
        $query = Order::with(['items.product', 'address'])
            ->where('user_id', auth()->id())
            ->latest();

        if ($activeTab !== 'all') {
            $query->whereIn('status', $statusMap[$activeTab] ?? []);
        }

        $orders = $query->get()->map(fn($o) => [
            'id'           => $o->id,
            'status'       => $o->status,
            'queue_number' => $o->queue_number,
            'order_code'   => $o->order_code,
            'total_amount' => $o->total_amount,
            'created_at'   => $o->created_at->format('d M, H:i'),
            'address_label' => $o->address->label ?? 'Tanpa Alamat',
            'items'        => $o->items->map(fn($i) => [
                'quantity' => $i->quantity,
                'name'     => optional($i->product)->name ?? 'Produk Dihapus',
            ]),
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
