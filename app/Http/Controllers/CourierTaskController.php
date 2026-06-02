<?php

namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\Order;
use App\Models\Task;
use App\Models\TrackingLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CourierTaskController extends Controller
{
    /**
     * Dashboard kurir — daftar tugas hari ini.
     */
    public function index(Request $request)
    {
        $courierId = Auth::id();
        $today     = Carbon::today();

        $tasks = Task::with(['order.user', 'order.address', 'order.items.product'])
            ->join('orders', 'tasks.order_id', '=', 'orders.id')
            ->where('tasks.courier_id', $courierId)
            ->whereIn('tasks.status', ['pending', 'picked_up'])
            ->where(function ($q) use ($today) {
                $q->whereDate('tasks.created_at', $today)
                    ->orWhereDate('tasks.pickup_date', $today);
            })
            ->orderBy('orders.created_at', 'asc')
            ->select('tasks.*')
            ->get();

        $todayTasks = Task::where('courier_id', $courierId)
            ->whereDate('created_at', $today)
            ->count();

        $completedToday = Task::where('courier_id', $courierId)
            ->whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        $pendingToday = Task::where('courier_id', $courierId)
            ->whereDate('created_at', $today)
            ->whereIn('status', ['pending', 'picked_up'])
            ->count();

        return view('courier.home', compact(
            'tasks',
            'todayTasks',
            'completedToday',
            'pendingToday'
        ));
    }

    /**
     * Kurir mengambil barang → status: pending → picked_up.
     */
    public function pickup($taskId)
    {
        $task = Task::where('id', $taskId)
            ->where('courier_id', Auth::id())
            ->firstOrFail();

        if ($task->status !== 'pending') {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid'
            ], 400);
        }

        $task->update(['status' => 'picked_up']);

        // ✅ Ubah: order masih "confirmed", belum "on_delivery"
        // on_delivery baru di-set saat kurir mulai antar (deliver)
        $task->order()->update(['status' => 'confirmed']);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil diambil, sedang dalam pengiriman'
        ]);
    }

    /**
     * Kurir menyelesaikan pengiriman → status: picked_up → completed.
     */
    public function deliver($taskId)
    {
        $task = Task::where('id', $taskId)
            ->where('courier_id', Auth::id())
            ->firstOrFail();

        if ($task->status !== 'picked_up') {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid'
            ], 400);
        }

        $task->update(['status' => 'completed']);

        // ✅ Ubah: on_delivery di-set di sini dulu, lalu completed + delivered_at
        // Karena deliver() dipanggil setelah kurir konfirmasi sudah sampai,
        // kita langsung set completed (on_delivery sudah tersirat dari flow peta)
        $task->order()->update([
            'status'       => 'completed',
            'delivered_at' => now(),
        ]);

        $maxTasksPerKurir = 10;
        $sisaTaskAktif = Task::where('courier_id', Auth::id())
            ->whereIn('status', ['pending', 'picked_up'])
            ->count();

        $kurir = Courier::where('user_id', Auth::id())->first();
        if ($kurir && $sisaTaskAktif < $maxTasksPerKurir) {
            $kurir->update(['status' => 'available']);
        }

        return response()->json([
            'success'    => true,
            'message'    => 'Pesanan berhasil diantarkan!',
            'sisa_tasks' => $sisaTaskAktif,
        ]);
    }

    /**
     * Kurir mengirim koordinat GPS-nya secara periodik (dipanggil dari JS).
     * Menyimpan ke tracking_logs DAN update last_known di tabel couriers.
     */
    public function updateLocation(Request $request, $taskId)
    {
        $request->validate([
            'latitude'  => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'speed'     => 'nullable|numeric|min:0',
        ]);

        $task = Task::where('id', $taskId)
            ->where('courier_id', Auth::id())
            ->firstOrFail();

        if ($task->status !== 'picked_up') {
            return response()->json([
                'success' => false,
                'message' => 'Tracking hanya aktif saat pengiriman.'
            ], 422);
        }

        $kurir = Courier::where('user_id', Auth::id())->first();

        if (!$kurir) {
            return response()->json([
                'success' => false,
                'message' => 'Data kurir tidak ditemukan.'
            ], 404);
        }

        // Simpan log tracking
        TrackingLog::create([
            'courier_id'  => $kurir->id,
            'order_id'    => $task->order_id,
            'latitude'    => $request->latitude,
            'longitude'   => $request->longitude,
            'speed'       => $request->speed,
            'recorded_at' => now(),
        ]);

        // Update posisi terakhir di tabel couriers
        $kurir->update([
            'last_known_lat' => $request->latitude,
            'last_known_lng' => $request->longitude,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Endpoint polling — customer/admin ambil posisi kurir terbaru untuk order tertentu.
     * Dipanggil tiap N detik dari halaman tracking.
     */
    public function trackingData(Order $order)
    {
        $latest = TrackingLog::where('order_id', $order->id)
            ->latest('recorded_at')
            ->first();

        $destination = $order->address;
        $courier     = $order->assignedCourier;

        return response()->json([
            'courier_lat'   => $latest?->latitude,
            'courier_lng'   => $latest?->longitude,
            'courier_name'  => $courier?->user?->name ?? '-',
            'courier_phone' => $courier?->user?->phone ?? '-',
            'dest_lat'      => $destination?->latitude,
            'dest_lng'      => $destination?->longitude,
            'dest_address'  => $destination?->address ?? '-',
            'order_status'  => $order->status,
            'updated_at'    => $latest?->recorded_at?->diffForHumans() ?? 'Belum ada data',
        ]);
    }

    /**
     * Halaman tracking publik untuk customer — diakses via order_code.
     */
    public function trackingPage(string $orderCode)
    {
        $order = Order::with(['address', 'assignedCourier.user'])
            ->where('order_code', $orderCode)
            ->firstOrFail();

        return view('tracking.show', compact('order'));
    }

    public function startDelivery($taskId)
    {
        $task = Task::where('id', $taskId)
            ->where('courier_id', Auth::id())
            ->firstOrFail();

        if ($task->status !== 'picked_up') {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak valid'
            ], 400);
        }

        // ✅ Set on_delivery saat kurir klik "Mulai Antar"
        $task->order()->update(['status' => 'on_delivery']);

        return response()->json(['success' => true]);
    }
}