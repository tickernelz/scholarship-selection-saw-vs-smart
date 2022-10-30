<?php

namespace Database\Seeders;

use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;

class MahasiswaSeeder extends Seeder
{
    public function run()
    {
        Mahasiswa::create([
            'nim' => '001',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2018',
            'jenis_kelamin' => 'P',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 1000000,
            'semester' => 7,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 2,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => '002',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2018',
            'jenis_kelamin' => 'P',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 3000000,
            'semester' => 7,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 3,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => '003',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2018',
            'jenis_kelamin' => 'L',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 5000000,
            'semester' => 7,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 4,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => '004',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2018',
            'jenis_kelamin' => 'P',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 7000000,
            'semester' => 7,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 5,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => '005',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2018',
            'jenis_kelamin' => 'L',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 9000000,
            'semester' => 7,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 6,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => '006',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2018',
            'jenis_kelamin' => 'L',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 2000000,
            'semester' => 7,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 7,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => '007',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2018',
            'jenis_kelamin' => 'L',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 3000000,
            'semester' => 7,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 8,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => '008',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2018',
            'jenis_kelamin' => 'P',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 5000000,
            'semester' => 7,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 9,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => '009',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2018',
            'jenis_kelamin' => 'L',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 6500000,
            'semester' => 7,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 10,
            'tahun_akademik_id' => 1,
        ]);
        Mahasiswa::create([
            'nim' => '010',
            'studi' => 'Sistem Informasi',
            'fakultas' => 'Teknik Informatika',
            'angkatan' => '2018',
            'jenis_kelamin' => 'P',
            'ttl' => 'Jakarta, 1 Januari 2000',
            'telepon' => '081234567890',
            'ukt' => 4500000,
            'semester' => 7,
            'is_verified' => 1,
            'is_beasiswa_send' => 1,
            'user_id' => 11,
            'tahun_akademik_id' => 1,
        ]);
    }
}
