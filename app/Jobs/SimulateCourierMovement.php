<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\TrackingLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SimulateCourierMovement implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function handle(): void
    {
        $courier = $this->order->assignedCourier;

        $route = json_decode(
            $this->order->route_coordinates,
            true
        );

        foreach ($route as $point) {

            TrackingLog::create([
                'courier_id' => $courier->id,
                'order_id' => $this->order->id,
                'latitude' => $point[1],
                'longitude' => $point[0],
                'recorded_at' => now(),
            ]);

            sleep(3);
        }
    }
}