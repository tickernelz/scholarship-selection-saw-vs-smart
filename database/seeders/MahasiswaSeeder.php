<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        Mahasiswa::create([
            'nim' => '123',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2019',
            'jenis_kelamin' => 'L',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'is_verified' => 1,
            'user_id' => 2,
        ]);
        Mahasiswa::create([
            'nim' => 'DBC118043',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2019',
            'jenis_kelamin' => 'L',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'is_verified' => 0,
            'user_id' => 3,
        ]);
    }
}
