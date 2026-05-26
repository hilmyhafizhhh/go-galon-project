<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use App\Models\Courier;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $faker = fake('id_ID');

        // ambil user random
        $user = User::role('customer')->inRandomOrder()->first();

        // ambil address milik user tersebut
        $address = Address::where('user_id', $user->id)
            ->inRandomOrder()
            ->first();

        // status order
        $status = $faker->randomElement([
            'confirmed',
            'confirmed',
            'confirmed',
            'confirmed',
            'cancelled',
            // 'draft',
        ]);

        // payment status
        $paymentStatus = match ($status) {
            'confirmed' => $faker->randomElement([
                'paid',
                'paid',
                'paid',
                'pending',
            ]),

            'cancelled' => 'failed',

            default => 'pending',
        };

        // courier hanya kalau confirmed
        $courier = $status === 'confirmed'
            ? Courier::inRandomOrder()->first()
            : null;

        return [
            'user_id' => $user->id,

            'order_code' => 'ORDER-' .
                strtoupper(Str::random(8)) .
                '-' .
                now()->timestamp,

            'total_amount' => $faker->randomElement([
                6000,
                7000,
                8000,
                12000,
                14000,
                21000,
                27000,
                36000,
                44000,
                58000,
            ]),

            'payment_method' => $faker->randomElement([
                'QRIS',
                'cod',
                'Bank Transfer (BCA)',
                'Bank Transfer (BNI)',
                'Bank Transfer (BRI)',
            ]),

            'payment_status' => $paymentStatus,

            'status' => $status,

            'assigned_courier_id' => $courier?->id,

            'address_id' => $address?->id,

            'delivered_at' => $status === 'confirmed'
                ? $faker->dateTimeBetween('-3 months', 'now')
                : null,

            'created_at' => $faker->dateTimeBetween('-3 months', 'now'),

            'updated_at' => now(),
        ];
    }
}