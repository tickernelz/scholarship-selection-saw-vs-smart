<?php

namespace Database\Seeders;

use App\Models\Pengaturan;
use DateTime;
use Illuminate\Database\Seeder;

class PengaturanSeeder extends Seeder
{
    public function run()
    {
        Pengaturan::create([
            'is_open' => true,
            'semester' => 'ganjil',
            'batas_pengajuan' => new DateTime('2022-12-30 23:59:59'),
        ]);
    }
}
