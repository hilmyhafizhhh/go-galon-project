<?php

namespace App\Console\Commands;

use App\Models\Chat;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

/**
 * Hapus chat dari list index dengan menyembunyikannya
 * (soft approach: tandai sebagai archived, bukan delete fisik).
 *
 * Jalankan: php artisan chats:cleanup
 * Schedule: setiap hari tengah malam
 */
class CleanupOldChatsCommand extends Command
{
    protected $signature   = 'chats:cleanup';
    protected $description = 'Arsipkan chat dari order yang sudah selesai lebih dari 7 hari';

    public function handle(): void
    {
        $cutoff = Carbon::now()->subDays(7);

        // Ambil order yang completed lebih dari 7 hari lalu
        $oldOrderIds = Order::where('status', 'completed')
            ->where('delivered_at', '<', $cutoff)
            ->pluck('id');

        if ($oldOrderIds->isEmpty()) {
            $this->info('Tidak ada chat yang perlu diarsipkan.');
            return;
        }

        // Tandai sebagai archived (bukan hapus fisik — data tetap ada untuk audit/laporan)
        $affected = Chat::whereIn('order_id', $oldOrderIds)
            ->whereNull('archived_at')
            ->update(['archived_at' => now()]);

        $this->info("✓ {$affected} chat diarsipkan dari {$oldOrderIds->count()} order lama.");
    }
}