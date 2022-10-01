<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run()
    {
        Pengaturan::create([
            'is_open' => true,
            'semester' => 'ganjil',
            'batas_pengajuan' => '10/31/2022 9:56 PM',
        ]);
    }
}
