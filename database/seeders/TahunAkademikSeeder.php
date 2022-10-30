<?php

namespace Database\Seeders;

use App\Models\TahunAkademik;
use Illuminate\Database\Seeder;

class TahunAkademikSeeder extends Seeder
{
    public function run()
    {
        TahunAkademik::create([
            'tahun_awal' => 2021,
            'tahun_akhir' => 2022,
            'is_active' => true,
        ]);
        TahunAkademik::create([
            'tahun_awal' => 2022,
            'tahun_akhir' => 2023,
            'is_active' => false,
        ]);
    }
}
