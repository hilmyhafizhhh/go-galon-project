<?php

namespace App\Http\Controllers;

use App\Events\ChatSent;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index() {
        $user = auth()->user();

         // Ambil semua chat yang melibatkan user login
        $chats = Chat::with(['sender', 'receiver'])
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                ->orWhere('receiver_id', $user->id);
            })
            ->latest()
            ->get()
            // Grouping per lawan bicara (supaya tiap user cuma 1)
            ->groupBy(function ($chat) use ($user) {
                return $chat->sender_id === $user->id ? $chat->receiver_id : $chat->sender_id;
            })
            // Ambil hanya chat terakhir dari tiap grup
            ->map(function ($group) {
                return $group->first();
            });


        return view('chat.index-realtime-chat', compact('chats'));
    }

    public function show($receiverId) {
        $user = Auth::user();
        $receiver = User::findOrFail($receiverId);

        if ($user->hasRole($receiver->getRoleNames()->first())) {
            abort(403, 'Tidak bisa chat dengan role yang sama!');
        }

        $chats = Chat::where(function($q) use ($user, $receiver) {
            $q->where('sender_id', $user->id)->where('receiver_id', $receiver->id);
        })->orWhere(function($q) use ($user, $receiver) {
            $q->where('sender_id', $receiver->id)->where('receiver_id', $user->id);
        })->orderBy('created_at')->get();

        return view('chat.show-realtime-chat', compact('chats', 'receiver'));
    }

    public function sendChat(Request $request) {
        $request->validate([
            'receiver_id' => 'required',
            'receiver_role' => 'required|in:customer,courier',
            'message' => 'required',
        ]);

        $sender = Auth::user();

        if($sender->role === $request->receiver_role) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak bisa mengirim pesan ke role yang sama!'
            ], 403);
        }

        $chat = Chat::create([
            'sender_id' => $sender->id,
            'receiver_id' => $request->receiver_id,
            'sender_role' => auth()->user()->getRoleNames()->first(),
            'receiver_role' => $request->receiver_role,
            'message' => $request->message,
        ]);

        broadcast( new ChatSent($chat))->toOthers();

        return response()->json([
            'chat' => $chat,
        ]);
    }
   

}
