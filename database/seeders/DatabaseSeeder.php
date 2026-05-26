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
    public function run(): void
{
/*
|--------------------------------------------------------------------------
| 1. USERS
|--------------------------------------------------------------------------
*/

// $users = User::factory(154)->create();

// foreach ($users as $user) {
//     $user->assignRole('customer');
// }


/*
|--------------------------------------------------------------------------
| 2. ADDRESSES
|--------------------------------------------------------------------------
*/

// foreach ($users as $user) {

//     // tiap user punya 1-3 alamat
//     Address::factory(rand(1, 3))->create([
//         'user_id' => $user->id,
//         'is_default' => false,
//     ]);

//     // pilih 1 default address
//     $defaultAddress = $user->addresses()
//         ->inRandomOrder()
//         ->first();

//     $defaultAddress?->update([
//         'is_default' => true
//     ]);
// }


/*
|--------------------------------------------------------------------------
| 3. COURIERS
|--------------------------------------------------------------------------
*/

// $courierUsers = User::factory(5)->create();

// $courierUsers->each(function ($user) {
//     $user->assignRole('courier');
// });

// $couriers = [];

// foreach ($courierUsers as $user) {

//     $couriers[] = Courier::create([
//         'user_id' => $user->id,

//         'vehicle_info' => fake('id_ID')->randomElement([
//             'Honda Beat',
//             'Honda Vario',
//             'Yamaha NMAX',
//             'Suzuki Address',
//         ]),

//         'status' => fake()->randomElement([
//             'available',
//             'delivering',
//             'offline',
//         ]),

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


/*
|--------------------------------------------------------------------------
| 4. ORDERS
|--------------------------------------------------------------------------
*/

// $orders = Order::factory(13500)->create();


/*
|--------------------------------------------------------------------------
| 5. ORDER ITEMS
|--------------------------------------------------------------------------
*/

// foreach ($orders as $order) {

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


/*
|--------------------------------------------------------------------------
| 6. TRACKING LOGS
|--------------------------------------------------------------------------
*/

$confirmedOrders = Order::where('status', 'confirmed')
    ->whereNotNull('assigned_courier_id')
    ->get();

foreach ($confirmedOrders as $order) {

    $lat = -6.1413375;
    $lng = 106.7869347;

    $totalTracks = rand(5, 15);

    for ($i = 1; $i <= $totalTracks; $i++) {

        $lat += fake()->randomFloat(6, 0.0001, 0.0010);
        $lng += fake()->randomFloat(6, 0.0001, 0.0010);

        TrackingLog::create([
            'courier_id' => $order->assigned_courier_id,
            'order_id' => $order->id,
            'latitude' => $lat,
            'longitude' => $lng,
            'speed' => rand(15, 40),
            'recorded_at' => now()->subMinutes(rand(10, 300)),
        ]);
    }
}
}

}
