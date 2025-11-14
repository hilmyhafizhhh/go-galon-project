<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $chat;
    public function __construct($chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('chat.channel'),
        ];
    }

    public function broadcastAs() {
        return 'chat.sent';
    }

    public function broadcastWith() {
        return [
            'chat' => [
                'id' => $this->chat->id,
                'sender_id' => $this->chat->sender_id,
                'receiver_id' => $this->chat->receiver_id,
                'message' => $this->chat->message,
                // 'created_at' => $this->chat->created_at->format('H:i'),
                'created_at' => $this->chat->created_at->setTimezone('Asia/Jakarta')->format('H:i'), // ← format di sini

            ]
        ];
    }
}
