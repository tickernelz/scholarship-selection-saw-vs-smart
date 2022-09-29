<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    public function run()
    {
        Kriteria::create([
            'nama' => 'Penghasilan orang tua atau sumber biaya kuliah',
            'tipe' => 'cost',
            'bobot' => 15,
        ])->subkriteria()->createMany([
            [
                'nama' => 'Rp 0,-',
                'prioritas' => 1,
            ],
            [
                'nama' => 'Rp 600.000',
                'prioritas' => 2,
            ],
            [
                'nama' => 'Rp 600.001 s.d. 1.500.000,-',
                'prioritas' => 3,
            ],
            [
                'nama' => 'Rp 1.500.001 s.d. 3.000.000,-',
                'prioritas' => 4,
            ],
            [
                'nama' => 'Rp 3.000.001 s.d. 4.500.000,-',
                'prioritas' => 5,
            ],
            [
                'nama' => 'Rp 4.500.001 s.d. 6.500.000,-',
                'prioritas' => 6,
            ],
            [
                'nama' => 'Rp 6.500.001 s.d. 10 juta',
                'prioritas' => 7,
            ],
            [
                'nama' => 'Di atas Rp 10 juta',
                'prioritas' => 8,
            ],
        ]);

        Kriteria::create([
            'nama' => 'Jumlah orang dalam keluarga (termasuk kepala keluarga)',
            'tipe' => 'benefit',
            'bobot' => 85,
        ])->subkriteria()->createMany([
            [
                'nama' => 'Lebih dari 5 orang',
                'prioritas' => 1,
            ],
            [
                'nama' => '5 orang',
                'prioritas' => 2,
            ],
            [
                'nama' => '4 orang',
                'prioritas' => 3,
            ],
            [
                'nama' => '3 orang',
                'prioritas' => 4,
            ],
            [
                'nama' => '2 orang',
                'prioritas' => 5,
            ],
            [
                'nama' => '1 orang',
                'prioritas' => 6,
            ]
        ]);
    }
}
