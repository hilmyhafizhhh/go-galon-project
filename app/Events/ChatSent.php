<?php

namespace App\Events;

use App\Models\Chat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatSent implements ShouldBroadcast
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
        $id1 = $this->chat->sender_id;
        $id2 = $this->chat->receiver_id;

        // Urutkan: yang kecil dulu
        if ($id1 > $id2) {
            [$id1, $id2] = [$id2, $id1];
        }

        return new PrivateChannel("chat.{$id1}.{$id2}");
    }

    public function broadcastAs(): string
    {
        return 'chat.sent';
    }
    
}
