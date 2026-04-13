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
            'sender_id' => 'c58a267a-e305-40ef-bcbc-0caf75f3a9ce',
            'receiver_id' => '41b9d1cc-2448-4e5a-99d6-6e4236292c84',
            'sender_role' => 'customer',
            'receiver_role' => 'courier',
            'message' => 'Halo, titik pengantaran sudah sesuai yaa!'
        ]);
    }
}
