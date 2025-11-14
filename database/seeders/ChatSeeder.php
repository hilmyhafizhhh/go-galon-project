<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Chat::create([
            'sender_id' => '61d24ce3-e4fb-4e12-90cf-687ad131b2c1',
            'receiver_id' => '6ee49eb9-79c8-4951-873b-b4ee3636a662',
            'sender_role' => 'customer',
            'receiver_role' => 'courier',
            'message' => 'Halo, titik pengantaran sudah sesuai yaa!'
        ]);
    }
}
