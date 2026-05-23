<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Courier;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\TrackingLog;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(100)->create();
        // Address::factory(50)->create();
        // Order::factory(50)->create();
        // User::all()->each(function ($user) {
        //     if (!$user->hasRole('customer')) {
        //         $user->assignRole('customer');
        //     }
        // });

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

//         $courierUsers = User::factory(5)->create();

// $courierUsers->each(function ($user) {
//     $user->assignRole('courier');
// });

// foreach ($courierUsers as $user) {
//     Courier::create([
//         'user_id' => $user->id,

//         'vehicle_info' => fake('id_ID')->randomElement([
//             'Honda Beat B 1234 KLM',
//             'Honda Vario B 4321 ABC',
//             'Yamaha NMAX B 8899 XYZ',
//             'Suzuki Address B 7788 PQR',
//             'Honda Supra B 6677 DEF',
//         ]),

//         'status' => fake()->randomElement([
//             'available',
//             'delivering',
//             'offline',
//         ]),

//         // sekitar depot EFATA
//         'last_known_lat' => fake()->randomFloat(
//             6,
//             -6.146000,
//             -6.136000
//         ),

//         'last_known_lng' => fake()->randomFloat(
//             6,
//             106.781000,
//             106.791000
//         ),
//     ]);
// }

// $orders = Order::all();

// foreach ($orders as $order) {

//     // tiap order punya 1-3 item
//     $products = Product::inRandomOrder()
//         ->take(rand(1, 3))
//         ->get();

//     foreach ($products as $product) {

//         $qty = rand(1, 4);

//         OrderItem::create([
//             'order_id' => $order->id,
//             'product_id' => $product->id,
//             'quantity' => $qty,
//             'unit_price' => $product->price,
//             'subtotal' => $product->price * $qty,
//             'is_selected' => true,
//         ]);
//     }
// }

// $orders = Order::where('status', 'confirmed')
//     ->whereNotNull('assigned_courier_id')
//     ->get();

// foreach ($orders as $order) {

//     // titik awal depot EFATA
//     $lat = -6.1413375;
//     $lng = 106.7869347;

//     // tiap order punya 5-15 titik tracking
//     $totalTracks = rand(5, 15);

//     for ($i = 1; $i <= $totalTracks; $i++) {

//         // gerakan kecil tiap tracking
//         $lat += fake()->randomFloat(6, 0.0001, 0.0010);
//         $lng += fake()->randomFloat(6, 0.0001, 0.0010);

//         TrackingLog::create([
//             'courier_id' => $order->assigned_courier_id,

//             'order_id' => $order->id,

//             'latitude' => $lat,

//             'longitude' => $lng,

//             'speed' => rand(15, 40),

//             'recorded_at' => now()->subMinutes(
//                 rand(10, 300)
//             ),

//             'created_at' => now(),

//             'updated_at' => now(),
//         ]);
//     }
// }

User::all()->each(function ($user) {

    // bikin 1-3 alamat
    Address::factory(rand(1, 3))->create([
        'user_id' => $user->id,
        'is_default' => false,
    ]);

    // pilih 1 alamat random jadi default
    $defaultAddress = $user->addresses()
        ->inRandomOrder()
        ->first();

    $defaultAddress?->update([
        'is_default' => true
    ]);
});
    }
}
