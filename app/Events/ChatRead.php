<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChatRead implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function broadcastOn(): array
    {
        // Broadcast ke channel private user si pengirim pesan asli
        return [
            // Ke pengirim pesan asli — untuk update ceklis ✓✓
            new PrivateChannel("user.{$this->data['sender_id']}"),
            // Ke pembaca — untuk reset unread di list chat mereka
            new PrivateChannel("user.{$this->data['reader_id']}"),
        ];
    }

    public function broadcastAs(): string
    {
        return 'chat.read';
    }

    public function broadcastWith(): array
    {
        return $this->data;
    }
}