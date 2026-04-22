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
            'sender_id' => '9ceaa66c-a368-41a2-b9f7-90e50efaa8e3',
            'receiver_id' => '2eb1b3ec-c5fc-46b0-ab37-c0e8fde55282',
            'sender_role' => 'customer',
            'receiver_role' => 'courier',
            'message' => 'Halo, titik pengantaran sudah sesuai yaa!'
        ]);
    }
}
