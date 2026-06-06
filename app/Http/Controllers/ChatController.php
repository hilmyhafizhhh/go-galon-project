<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Models\Chat;
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
            ->map(function ($group) use ($user) {           // ← ganti bagian ini
                $chat = $group->first();
                $chat->other_user_id = $chat->sender_id == $user->id
                    ? $chat->receiver_id
                    : $chat->sender_id;

                // Hitung unread dari seluruh group, bukan hanya pesan pertama
                $chat->unread_count = $group->filter(fn($c) =>
                    $c->receiver_id == $user->id && is_null($c->read_at)
                )->count();

                return $chat;
            });

        $depotContact = null;
        if ($user->hasRole('courier')) {
            $depotContact = User::role('admin')->first();
        }

        return view('chat.index-chat', compact('chats', 'depotContact'));
    }

    public function show($receiverId)
    {
        $sender = Auth::user();
        $receiver = User::findOrFail($receiverId);

        // Ambil semua unread sebelum di-update
        $unread = Chat::where('sender_id', $receiver->id)
            ->where('receiver_id', $sender->id)
            ->whereNull('read_at')
            ->get();

        if ($unread->isNotEmpty()) {
            // Update semua sekaligus
            Chat::whereIn('id', $unread->pluck('id'))
                ->update(['read_at' => now()]);

            // Broadcast langsung — bukan toOthers() agar tidak delay
            broadcast(new \App\Events\ChatRead([
                'reader_id' => $sender->id,
                'sender_id' => $receiver->id,
                'chat_ids'  => $unread->pluck('id')->toArray(),
            ]));
        }

        $chats = Chat::where(function ($q) use ($sender, $receiver) {
                $q->where('sender_id', $sender->id)->where('receiver_id', $receiver->id);
            })
            ->orWhere(function ($q) use ($sender, $receiver) {
                $q->where('sender_id', $receiver->id)->where('receiver_id', $sender->id);
            })
            ->orderBy('created_at')
            ->get();

        return view('chat.show-chat', compact('chats', 'receiver'));
    }

    public function sendChat(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required',
            'message' => 'required',
        ]);

        $sender = Auth::user();
        $receiver = User::findOrFail($request->receiver_id);

        // setiap pesan harus create row baru
        $chat = Chat::create([
            'sender_id' => $sender->id,
            'receiver_id' => $receiver->id,
            'sender_role' => $sender->getRoleNames()->first(),
            'receiver_role' => $receiver->getRoleNames()->first(),
            'message' => $request->message,
        ]);

        broadcast(new ChatSent($chat))->toOthers();

        return response()->json([
            'chat' => [
                'id'          => $chat->id,
                'sender_id'   => $chat->sender_id,
                'receiver_id' => $chat->receiver_id,
                'message'     => $chat->message,
                'created_at'  => $chat->created_at->format('H:i'),
                'read_at'     => $chat->read_at, // ← tambah ini
            ]
        ]);
    }

    // API endpoint untuk polling unread count
    public function unreadCount()
    {
        $count = Chat::unreadFor(auth()->id())->count();
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

        broadcast(new \App\Events\ChatRead([
            'reader_id' => $user->id,
            'sender_id' => $chats->first()->sender_id,
            'chat_ids'  => $chats->pluck('id')->toArray(),
        ]));

        return response()->json(['success' => true]);
    }
}
