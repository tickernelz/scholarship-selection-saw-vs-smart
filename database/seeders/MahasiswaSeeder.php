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
            'prodi' => 'Sistem Informasi',
            'jurusan' => 'Teknik Informatika',
            'user_id' => 2,
        ]);
    }
}
