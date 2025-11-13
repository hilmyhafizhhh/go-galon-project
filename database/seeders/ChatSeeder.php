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
            'sender_id' => 'f9396916-c6ca-4143-8903-11bd771f6430',
            'receiver_id' => '32c106aa-548c-448c-a5fb-9832e254159c',
            'sender_role' => 'customer',
            'receiver_role' => 'courier',
            'message' => 'Halo, titik pengantaran sudah sesuai yaa!'
        ]);
    }
}
