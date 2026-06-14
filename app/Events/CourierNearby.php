<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CourierNearby implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public string $userId,
        public string $message,
        public string $type,   // 'nearby' | 'arriving' | 'arrived'
        public float  $distanceKm,
        public int    $etaMins,
    ) {}

    public function broadcastOn(): array
    {
        return [new PrivateChannel("user.{$this->userId}")];
    }

    public function broadcastAs(): string
    {
        return 'courier.nearby';
    }

    public function broadcastWith(): array
    {
        return [
            'message'     => $this->message,
            'type'        => $this->type,
            'distance_km' => $this->distanceKm,
            'eta_mins'    => $this->etaMins,
        ];
    }
}
