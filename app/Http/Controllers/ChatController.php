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
                return $chat->sender_id == $user->id ? $chat->receiver_id : $chat->sender_id;
            })
            ->map(fn($group) => $group->first());

        $chats = $chats->map(function ($chat) use ($user) {
            $chat->other_user_id = $chat->sender_id == $user->id
                ? $chat->receiver_id
                : $chat->sender_id;

            return $chat;
        });

        return view('chat.index-chat', compact('chats'));
    }

    public function show($receiverId)
    {
        $sender = Auth::user();
        $receiver = User::findOrFail($receiverId);

        $chats = Chat::where(function ($q) use ($sender, $receiver) {
            $q->where('sender_id', $sender->id)
                ->where('receiver_id', $receiver->id);
        })
            ->orWhere(function ($q) use ($sender, $receiver) {
                $q->where('sender_id', $receiver->id)
                    ->where('receiver_id', $sender->id);
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
                'id' => $chat->id,
                'sender_id' => $chat->sender_id,
                'receiver_id' => $chat->receiver_id,
                'message' => $chat->message,
                'created_at' => $chat->created_at->format('H:i'),
            ]
        ]);
    }
}
