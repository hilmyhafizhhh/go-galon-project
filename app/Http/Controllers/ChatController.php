<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Events\ChatRead;
use App\Models\Chat;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        /*
         * PostgreSQL tidak support MAX(uuid).
         * Solusi: group by room key → ambil MAX(created_at),
         * lalu ambil 1 chat per room berdasarkan created_at terbaru.
         *
         * Menggunakan DISTINCT ON (PostgreSQL-specific) untuk efisiensi.
         */

        // ── 1. Chat berbasis order ───────────────────────────────────
        // DISTINCT ON (order_id) ORDER BY order_id, created_at DESC
        // → ambil 1 baris terbaru per order_id
        $orderChats = Chat::select('*')
            ->whereRaw('id IN (
                SELECT DISTINCT ON (order_id) id
                FROM chats
                WHERE (sender_id = ? OR receiver_id = ?)
                  AND order_id IS NOT NULL
                ORDER BY order_id, created_at DESC
            )', [$userId, $userId])
            ->with(['sender', 'receiver', 'order'])
            ->get();

        // ── 2. Chat non-order (depot/admin) ─────────────────────────
        // DISTINCT ON pasangan user
        $nonOrderChats = Chat::select('*')
            ->whereRaw('id IN (
                SELECT DISTINCT ON (LEAST(sender_id::text, receiver_id::text) || \'_\' || GREATEST(sender_id::text, receiver_id::text)) id
                FROM chats
                WHERE (sender_id = ? OR receiver_id = ?)
                  AND order_id IS NULL
                ORDER BY
                    LEAST(sender_id::text, receiver_id::text) || \'_\' || GREATEST(sender_id::text, receiver_id::text),
                    created_at DESC
            )', [$userId, $userId])
            ->with(['sender', 'receiver'])
            ->get();

        // ── 3. Gabung, hitung unread, sort ───────────────────────────
        $chats = $orderChats->merge($nonOrderChats)
            ->map(function ($chat) use ($userId) {
                $otherUser = $chat->sender_id === $userId
                    ? $chat->receiver
                    : $chat->sender;

                // Hitung unread per room
                $unreadQuery = Chat::where('receiver_id', $userId)
                    ->whereNull('read_at');

                if ($chat->order_id) {
                    $unreadQuery->where('order_id', $chat->order_id);
                } else {
                    $unreadQuery->whereNull('order_id')
                        ->where('sender_id', $otherUser?->id ?? '');
                }

                $chat->other_user    = $otherUser;
                $chat->other_user_id = $otherUser?->id;
                $chat->unread_count  = $unreadQuery->count();

                return $chat;
            })
            ->sortByDesc('created_at')
            ->values();

        $depotContact = null;
        if (auth()->user()->hasRole('courier')) {
            $depotContact = User::role('admin')->first();
        }

        return view('chat.index-chat', compact('chats', 'depotContact'));
    }

// ── Tambahan di ChatController::show() ──────────────────────────
// Cek apakah order sudah selesai dan melewati batas waktu kirim

    public function show($receiverId, Request $request)
    {
        $sender   = Auth::user();
        $receiver = User::findOrFail($receiverId);
        $orderId  = $request->query('order_id');

        $query = Chat::where(function ($q) use ($sender, $receiver) {
            $q->where(function ($q2) use ($sender, $receiver) {
                $q2->where('sender_id', $sender->id)
                    ->where('receiver_id', $receiver->id);
            })->orWhere(function ($q2) use ($sender, $receiver) {
                $q2->where('sender_id', $receiver->id)
                    ->where('receiver_id', $sender->id);
            });
        });

        if ($orderId) {
            $query->where('order_id', $orderId);
        } else {
            $query->whereNull('order_id');
        }

        // ✅ Cek apakah chat sudah terkunci (order selesai > 24 jam)
        // ✅ Cek apakah chat sudah terkunci (order selesai > 24 jam)
$order       = $orderId ? Order::find($orderId) : null;
$chatLocked  = false;
$lockedReason = null;

if ($order) {
    if (
        $order->status === 'completed'
        && $order->delivered_at
        && now()->greaterThanOrEqualTo(
            $order->delivered_at->copy()->addHours(24)
        )
    ) {
        $chatLocked = true;
        $lockedReason = 'Pesanan sudah selesai. Chat ditutup 24 jam setelah pengiriman.';
    } elseif ($order->status === 'cancelled') {
        $chatLocked   = true;
        $lockedReason = 'Pesanan dibatalkan. Chat tidak tersedia.';
    }
}

        // Mark read + broadcast (tetap jalan meski locked — bisa baca history)
        $unread = (clone $query)
            ->where('receiver_id', $sender->id)
            ->whereNull('read_at')
            ->get();

        if ($unread->isNotEmpty()) {
            Chat::whereIn('id', $unread->pluck('id'))
                ->update(['read_at' => now()]);

            broadcast(new ChatRead([
                'reader_id' => $sender->id,
                'sender_id' => $receiver->id,
                'order_id'  => $orderId,
                'chat_ids'  => $unread->pluck('id')->toArray(),
            ]));
        }

        $chats = $query->orderBy('created_at')->get();
        return view('chat.show-chat', compact('chats', 'receiver', 'order', 'chatLocked', 'lockedReason'));
    }


// ── Tambahan di ChatController::sendChat() ───────────────────────
// Tolak kirim pesan kalau order sudah locked

    public function sendChat(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'message'     => 'required|string|max:2000',
            'order_id'    => 'nullable|exists:orders,id',
        ]);

        // ✅ Cek lock sebelum menyimpan pesan
        if ($request->order_id) {
            $order = Order::find($request->order_id);

            if ($order) {
                if ($order->status === 'cancelled') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pesanan dibatalkan. Tidak bisa mengirim pesan.'
                    ], 403);
                }

                if (
    $order->status === 'completed'
    && $order->delivered_at
    && now()->greaterThanOrEqualTo(
        $order->delivered_at->copy()->addHours(24)
    )
) {
    return response()->json([
        'success' => false,
        'message' => 'Chat sudah ditutup 24 jam setelah pengiriman selesai.'
    ], 403);
}
            }
        }

        $sender   = Auth::user();
        $receiver = User::findOrFail($request->receiver_id);

        $chat = Chat::create([
            'sender_id'     => $sender->id,
            'receiver_id'   => $receiver->id,
            'order_id'      => $request->order_id ?? null,
            'sender_role'   => $sender->getRoleNames()->first(),
            'receiver_role' => $receiver->getRoleNames()->first(),
            'message'       => $request->message,
        ]);

        broadcast(new ChatSent($chat))->toOthers();

        return response()->json([
            'chat' => [
                'id'          => $chat->id,
                'sender_id'   => $chat->sender_id,
                'receiver_id' => $chat->receiver_id,
                'order_id'    => $chat->order_id,
                'message'     => $chat->message,
                'created_at'  => $chat->created_at->format('H:i'),
                'read_at'     => $chat->read_at,
            ]
        ]);
    }

    public function markRead(Request $request)
{
    $request->validate(['chat_ids' => 'required|array']);

    $userId = auth()->id();

    $chats = Chat::whereIn('id', $request->chat_ids)
        ->where('receiver_id', $userId)
        ->whereNull('read_at')
        ->get();

    if ($chats->isEmpty()) {
        return response()->json(['ok' => true]);
    }

    Chat::whereIn('id', $chats->pluck('id'))
        ->update(['read_at' => now()]);

    // Ambil sender_id — semua chat ini dari satu pengirim
    $senderId = $chats->first()->sender_id;
    $orderId  = $chats->first()->order_id;

    broadcast(new ChatRead([
        'reader_id' => $userId,
        'sender_id' => $senderId,
        'order_id'  => $orderId,
        'chat_ids'  => $chats->pluck('id')->toArray(),
    ]));

    return response()->json(['ok' => true]);
}
}