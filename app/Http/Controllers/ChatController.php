<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Events\ChatRead;
use App\Models\Chat;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $chats = Chat::with(['sender', 'receiver'])
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->orderBy('updated_at', 'desc')
            ->get()
            ->groupBy(function ($chat) use ($user) {
                return $chat->sender_id == $user->id
                    ? $chat->receiver_id
                    : $chat->sender_id;
            })
            //dimatikan sementara
            // ->map(function ($group) use ($user) {
            //     $chat = $group->first();
            //     $chat->other_user_id = $chat->sender_id == $user->id
            //         ? $chat->receiver_id
            //         : $chat->sender_id;

            //     $chat->unread_count = $group->filter(fn($c) =>
            //         $c->receiver_id == $user->id && is_null($c->read_at)
            //     )->count();

            //     return $chat;
            // });

            ->map(function ($group) use ($user) {
                $chat = $group->first();
                
                $chat->other_user_id = $chat->sender_id == $user->id
                ? $chat->receiver_id
                : $chat->sender_id;
                
                $chat->unread_count = $group->filter(fn($c) =>
                $c->receiver_id == $user->id && is_null($c->read_at)
                )->count();
                
                // ambil order_id terbaru yang masih ada
                $activeOrderId = $group
                ->whereNotNull('order_id')
                ->sortByDesc('created_at')
                ->first();
                
                $chat->active_order_id = $activeOrderId?->order_id;
                
                return $chat;
                });

        $depotContact = null;
        if ($user->hasRole('courier')) {
            $depotContact = User::role('admin')->first();
        }

        return view('chat.index-chat', compact('chats', 'depotContact'));
    }

    public function show($receiverId, Request $request)
    {
        $sender   = Auth::user();
        $receiver = User::findOrFail($receiverId);
        $orderId  = $request->query('order_id');

        //tambahan script baru
        if (!$orderId) {
            $activeChat = Chat::where(function ($q) use ($sender, $receiver) {
                $q->where('sender_id', $sender->id)
                ->where('receiver_id', $receiver->id);
                })
                ->orWhere(function ($q) use ($sender, $receiver) {
                    $q->where('sender_id', $receiver->id)
                    ->where('receiver_id', $sender->id);
                    })
                    ->whereNotNull('order_id')
                    ->latest()
                    ->first();
                    
                    $orderId = $activeChat?->order_id;
                    }

        // Scope pesan berdasarkan order_id
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
        }

        // Mark read
        $unread = (clone $query)
            ->where('receiver_id', $sender->id)
            ->whereNull('read_at')
            ->get();

        if ($unread->isNotEmpty()) {
            Chat::whereIn('id', $unread->pluck('id'))->update(['read_at' => now()]);

            broadcast(new ChatRead([
                'reader_id' => $sender->id,
                'sender_id' => $receiver->id,
                'order_id'  => $orderId,
                'chat_ids'  => $unread->pluck('id')->toArray(),
            ]));
        }

        $chats = $query->orderBy('created_at')->get();
        $order = $orderId ? Order::find($orderId) : null;

        // dd(
        //     $orderId,
        //     $query->count(),
        //     $query->pluck('message', 'order_id')
        // );

        return view('chat.show-chat', compact('chats', 'receiver', 'order'));
    }

    public function sendChat(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'message'     => 'required',
            'order_id'    => 'nullable|exists:orders,id',
        ]);

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

    public function unreadCount()
    {
        $count = Chat::where('receiver_id', auth()->id())
            ->whereNull('read_at')
            ->count();
        return response()->json(['count' => $count]);
    }

    public function markRead(Request $request)
    {
        $user = Auth::user();

        $chats = Chat::whereIn('id', $request->chat_ids)
            ->where('receiver_id', $user->id)
            ->whereNull('read_at')
            ->get();

        if ($chats->isEmpty()) {
            return response()->json(['success' => true]);
        }

        Chat::whereIn('id', $chats->pluck('id'))->update(['read_at' => now()]);

        broadcast(new ChatRead([
            'reader_id' => $user->id,
            'sender_id' => $chats->first()->sender_id,
            'order_id'  => $chats->first()->order_id,
            'chat_ids'  => $chats->pluck('id')->toArray(),
        ]));

        return response()->json(['success' => true]);
    }
}