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
            'sender_id' => '49dc4dcd-6af3-4ace-a482-6c39eab585cb',
            'receiver_id' => '128f3493-2067-4cda-8253-81f4b239cdf3',
            'sender_role' => 'courier',
            'receiver_role' => 'customer',
            'message' => 'Halo, titik pengantaran sudah sesuai yaa!'
        ]);
    }
}
