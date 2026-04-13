<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
// use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $chat;

    public function __construct(Chat $chat)
    {
        $this->chat = $chat->load('sender'); // biar nama pengirim langsung ikut
    }

    // Channel privat antar 2 orang (urutkan ID biar konsisten)
    public function broadcastOn(): Channel
{
    $userA = min($this->chat->sender_id, $this->chat->receiver_id);
    $userB = max($this->chat->sender_id, $this->chat->receiver_id);

    return new PrivateChannel("chat.$userA.$userB");
}


    public function broadcastAs(): string
    {
        return 'chat.sent';
    }
    public function broadcastWith(): array
{
    return [
        'chat' => [
            'id' => $this->chat->id,
            'sender_id' => $this->chat->sender_id,
            'receiver_id' => $this->chat->receiver_id,
            'message' => $this->chat->message,
            // 'created_at' => $this->chat->created_at,
            'created_at' => $this->chat->created_at->format('H:i'),
            'sender' => $this->chat->sender,
        ]
    ];
}

    
}
