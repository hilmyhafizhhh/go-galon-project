<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Order;
use App\Models\Courier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class CourierTaskController extends Controller
{
    public function index(Request $request)
    {
        $courierId = Auth::id();
        $today     = Carbon::today();

        // // FCFS - urut berdasarkan order.created_at
        // $tasks = Task::with(['order.user', 'order.address', 'order.items.product'])
        //     ->where('courier_id', $courierId)
        //     ->whereIn('tasks.status', ['pending', 'picked_up']) // tambahkan ini
        //     ->where(function ($q) use ($today) {
        //         $q->whereDate('tasks.created_at', $today)
        //             ->orWhereDate('pickup_date', $today);
        //     })
        //     ->join('orders', 'tasks.order_id', '=', 'orders.id')
        //     ->orderBy('orders.created_at', 'asc') // FCFS
        //     ->select('tasks.*')
        //     ->get();
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
        $task->order()->update(['status' => 'on_delivery']);

        return response()->json([
            'success' => true,
            'message' => 'Pesanan berhasil diambil, sedang dalam pengiriman'
        ]);
    }

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

        // Update task dan order
        $task->update(['status' => 'completed']);
        $task->order()->update([
            'status'       => 'completed',
            'delivered_at' => now(),
        ]);

        // Cek sisa task aktif kurir setelah deliver
        $maxTasksPerKurir = 10;
        $sisaTaskAktif    = Task::where('courier_id', Auth::id())
            ->whereIn('status', ['pending', 'picked_up'])
            ->count();

        $kurir = Courier::where('user_id', Auth::id())->first();

        if ($kurir) {
            if ($sisaTaskAktif < $maxTasksPerKurir) {
                // Masih bisa terima pesanan baru
                $kurir->update(['status' => 'available']);
            }
            // Kalau masih penuh, status tetap on_delivery
        }

        return response()->json([
            'success'    => true,
            'message'    => 'Pesanan berhasil diantarkan! Sisa task aktif: ' . $sisaTaskAktif,
            'sisa_tasks' => $sisaTaskAktif,
        ]);
    }
}
