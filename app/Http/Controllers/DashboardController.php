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

        // $totalOrders = Order::count();
        $totalOrders = Order::whereDate('created_at', $today)->count();


        $todayIncome = Order::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->sum('total_amount');

        // $activeOrders = Order::whereIn('status', [
        //     // 'draft', //tambahan
        //     'pending',
        //     'confirmed',
        //     'assigned',
        //     'delivering'
        // ])->count();
        $activeOrders = Order::whereDate('created_at', $today)
            ->whereIn('status', ['pending', 'confirmed', 'on_delivery'])
            ->count();
        // $courierOnline = User::role('courier')
        //     ->where('is_online', true)
        //     ->count();

        // $totalCourier = User::role('courier')->count();
        $courierOnline = Courier::where('status', 'available')->count();
        $totalCourier = Courier::count();

        // $orders = Order::with(['user', 'courier.user', 'items.product', 'address'])
        //     ->latest()
        //     ->take(10)
        //     ->get();
        // $orders = Order::with(['user', 'courier.user', 'items.product', 'address'])
        //     ->whereDate('created_at', $today)
        //     ->latest()
        //     ->get();
        $orders = Order::with(['user', 'courier.user', 'items.product', 'address'])
            ->where(function ($q) use ($today) {
                $q->whereDate('created_at', $today)
                    ->orWhere('status', 'pending');
            })
            ->latest()
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

    public function validateOrder(Request $request, $id)
    {
        $order = Order::with(['user', 'items.product', 'address'])->findOrFail($id);

        if ($order->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Pesanan ini tidak dapat divalidasi'
            ], 400);
        }

        $action = $request->input('action');

        if ($action === 'accept') {



            // // $maxTasksPerKurir = 10;
            // $queueNumber = Order::whereDate('created_at', Carbon::today())
            //     ->whereNotNull('queue_number')
            //     ->where('created_at', '<', $order->created_at)
            //     ->count() + 1;
            $queueNumber = Order::whereDate('created_at', Carbon::today())
                ->where('created_at', '<=', $order->created_at)
                ->whereIn('status', ['pending', 'confirmed', 'delivered', 'completed', 'on_delivery'])
                ->count();

            $maxTasksPerKurir = 10;

            // Ambil semua kurir available
            $kurirList = Courier::with('user')
                ->where('status', 'available')
                ->get();

            // Cari kurir dengan task aktif paling sedikit dan belum penuh
            $kurir = $kurirList->map(function ($k) {
                $k->active_tasks = Order::where('assigned_courier_id', $k->id)
                    ->whereIn('status', ['confirmed', 'on_delivery'])
                    ->count();
                return $k;
            })
                ->filter(fn($k) => $k->active_tasks < $maxTasksPerKurir)
                ->sortBy('active_tasks')
                ->first();

            if (!$kurir) {
                return response()->json([
                    'success' => false,
                    'message' => 'Semua kurir sedang penuh, coba beberapa saat lagi'
                ], 400);
            }
            // 3. Update status order
            $order->status              = 'confirmed';
            // $order->queue_number        = $lastQueueNumber + 1;
            $order->queue_number = $queueNumber;
            $order->assigned_courier_id = $kurir->id;
            $order->save();

            // 4. Buat record task untuk kurir
            \App\Models\Task::create([
                'order_id'    => $order->id,
                'courier_id'  => $kurir->user_id,
                'customer_id' => $order->user_id,
                'pickup_date' => Carbon::today(),
                'status'      => 'pending',
            ]);

            // 5. Cek apakah kurir sudah mencapai batas maksimal task
            $activeTasks = $kurir->active_tasks + 1; // +1 karena baru saja ditambah
            if ($activeTasks >= $maxTasksPerKurir) {
                $kurir->update(['status' => 'on_delivery']); // Penuh, tidak bisa terima lagi
            }
            // Kalau belum penuh, status tetap 'available'

            return response()->json([
                'success'      => true,
                'message'      => 'Pesanan diterima, assigned ke kurir ' . $kurir->user->name . ' (Task aktif: ' . $activeTasks . '/' . $maxTasksPerKurir . ')',
                'queue_number' => $order->queue_number,
                'kurir'        => $kurir->user->name,
            ]);
        } elseif ($action === 'reject') {

            $order->status = 'cancelled';
            $order->save();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan ditolak'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Aksi tidak valid'
        ], 400);
    }
}
