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
            'sender_id' => 'bb4e69e3-73ca-4d42-af1f-4dee8d643a75',
            'receiver_id' => '894e73bc-d236-4946-9fed-9964c23bc99e',
            'sender_role' => 'customer',
            'receiver_role' => 'courier',
            'message' => 'Halo, titik pengantaran sudah sesuai yaa!'
        ]);
    }
}
