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
            'ukt' => 1000000,
            'semester' => 6,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 2,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => 'DBC118043',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2019',
            'jenis_kelamin' => 'L',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 3000000,
            'semester' => 6,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 3,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => 'DBC118044',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2019',
            'jenis_kelamin' => 'L',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 5000000,
            'semester' => 6,
            'is_verified' => 1,
            'is_beasiswa_send' => 0,
            'user_id' => 4,
            'tahun_akademik_id' => 1,
        ]);
    }
}
