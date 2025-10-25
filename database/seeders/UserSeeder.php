<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'id' => Str::uuid(),
            'name' => 'Admin Go Galon',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('tamankota'),
        ]);

        $admin->assignRole('admin');

        $courier = User::create([
            'id' => Str::uuid(),
            'name' => 'Courier Go Galon',
            'username' => 'courier',
            'email' => 'courier@gmail.com',
            'password' => bcrypt('tamankota'),
        ]);

        $courier->assignRole('courier');

        $customer = User::create([
            'id' => Str::uuid(),
            'name' => 'Customer Go Galon',
            'username' => 'customer',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('tamankota'),
        ]);

        $customer->assignRole('customer');
    }
}
