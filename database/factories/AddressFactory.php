<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        $faker = fake('id_ID');

        return [
            // ambil user random yang sudah ada
            'user_id' => User::inRandomOrder()->first()->id,

            // label realistis ala user Indonesia 😭
            'label' => $faker->randomElement([
                'Rumah',
                'Rumah Utama',
                'Rumah Mama',
                'Rumah Nenek',
                'Kontrakan',
                'Kontrakan Belakang',
                'Kos',
                'Kost',
                'Kantor',
                'Toko',
                'Ruko',
                'Gudang',
                'Basecamp',
                'Warung',
                'Mess',
                'Cafe',
                'Pos Satpam',
                'Depan Indomaret',
                'Samping Musholla',
                'konter pulsa',
                'Lapangan'
            ]),

            // alamat sekitar depot EFATA (Jakarta Barat/Jakarta Utara)
            'address' => $faker->randomElement([
                'Jl. Bidara Raya No. 7, RT.004/RW.004, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kepanduan II No. 29, RT.005/RW.006, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kepanduan I No. 14, RT.003/RW.005, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Pangeran Tubagus Angke No. 19, RT.004/RW.005, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Pangeran Tubagus Angke Gg. Haji Naim No. 8, RT.002/RW.005, Pejagalan, Jakarta Utara',
                'Jl. Teluk Gong Raya No. 12, RT.004/RW.007, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Teluk Gong Raya Gg. Lili No. 43, RT.004/RW.007, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Teluk Gong Selatan No. 6, RT.010/RW.017, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. B Teluk Gong Selatan No. 11, RT.003/RW.017, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Teluk Gong Selatan III No. 9, RT.006/RW.012, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Sinar Budi No. 8, RT.005/RW.004, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Sinar Budi No. 23, RT.004/RW.003, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Sinar Budi Gg. Melati No. 5, RT.002/RW.004, Pejagalan, Jakarta Utara',
                'Gg. Lontar No. 41, RT.009/RW.004, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. Lontar No. 17, RT.008/RW.004, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. Code No. 12, RT.004/RW.007, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. Code No. 5A, RT.003/RW.007, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kamp. Gusti Kebon Sayur No. 3, RT.008/RW.014, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kamp. Gusti Kebon Sayur No. 22, RT.007/RW.014, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. B No. B2/70, RT.005/RW.001, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. Jangkung No. 43A, RT.003/RW.002, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. Jangkung No. 18, RT.002/RW.002, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. O No. 23, RT.004/RW.003, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. O No. 9, RT.005/RW.003, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kepanduan II Gg. Mawar No. 6, RT.007/RW.010, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kepanduan II Gg. Anggrek No. 14, RT.006/RW.008, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Bidara Raya Gg. Melati No. 3, RT.005/RW.004, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Bidara Raya No. 12, RT.003/RW.004, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Pangeran Tubagus Angke No. 34, RT.006/RW.005, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Pangeran Tubagus Angke Blok Siaga No. 4, RT.004/RW.005, Pejagalan, Jakarta Utara',
                'Jl. Teluk Gong Raya No. 33, RT.010/RW.013, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Teluk Gong Raya No. 55B, RT.009/RW.013, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kepanduan I No. 27, RT.004/RW.006, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kepanduan I Gg. Buntu No. 8, RT.002/RW.006, Pejagalan, Jakarta Utara',
                'Jl. Sinar Budi Gg. Kenanga No. 11, RT.001/RW.003, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. Lontar No. 7, RT.010/RW.004, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. Code No. 31, RT.005/RW.007, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Jelambar Wijaya Gg. Lili No. 21, RT.003/RW.007, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Jelambar Wijaya No. 8, RT.004/RW.007, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kamp. Gusti Kebon Sayur No. 14, RT.009/RW.014, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Pangeran Tubagus Angke Gg. Damai No. 7, RT.001/RW.005, Pejagalan, Jakarta Utara',
                'Jl. Teluk Gong Selatan Gg. Angin No. 4, RT.011/RW.017, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Bidara Raya Gg. Kenanga No. 9, RT.006/RW.004, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. B No. 15, RT.006/RW.001, Pejagalan, Penjaringan, Jakarta Utara',
                'Gg. Jangkung No. 30, RT.001/RW.002, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kepanduan II No. 47, RT.008/RW.010, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Sinar Budi No. 35, RT.003/RW.003, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Teluk Gong Raya Gg. Masjid No. 2, RT.005/RW.007, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Pangeran Tubagus Angke No. 61, RT.007/RW.005, Pejagalan, Penjaringan, Jakarta Utara',
                'Jl. Kepanduan I No. 38, RT.001/RW.006, Pejagalan, Penjaringan, Jakarta Utara',
            ]),

            /*
            Koordinat sekitar depot EFATA:
            (-6.1413375, 106.7869347)

            Radius sekitar ±5 KM
            */

            'latitude' => $faker->randomFloat(
                6,
                -6.170000,
                -6.110000
            ),

            'longitude' => $faker->randomFloat(
                6,
                106.760000,
                106.810000
            ),

            'is_default' => false,

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}