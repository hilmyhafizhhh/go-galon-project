<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Task;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CancelExpiredOrders extends Command
{
    protected $signature = 'orders:cancel-expired';
    protected $description = 'Batalkan order yang task-nya tidak diselesaikan kurir pada hari yang sama';

    public function handle(): int
    {
        // Ambil semua task dari hari-hari sebelumnya yang belum completed
        $expiredTasks = Task::with('order')
            ->whereDate('created_at', '<', today())
            ->whereIn('status', ['pending', 'picked_up'])
            ->get();

        if ($expiredTasks->isEmpty()) {
            $this->info('Tidak ada task kedaluwarsa.');
            return self::SUCCESS;
        }

        $cancelledCount = 0;

        foreach ($expiredTasks as $task) {
            $order = $task->order;

            if (!$order) continue;

            // Hanya cancel order yang masih aktif (bukan yang sudah completed/cancelled)
            if (!in_array($order->status, ['pending', 'confirmed', 'on_delivery'])) continue;

            DB::transaction(function () use ($task, $order) {
                $order->update(['status' => 'cancelled']);
                $task->update(['status' => 'cancelled']);
            });

            $cancelledCount++;

            Log::info('Order expired & dibatalkan otomatis', [
                'order_id'   => $order->id,
                'order_code' => $order->order_code,
                'task_id'    => $task->id,
            ]);
        }

        $this->info("Selesai: {$cancelledCount} order dibatalkan.");

        return self::SUCCESS;
    }
}