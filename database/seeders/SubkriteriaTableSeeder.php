<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubkriteriaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('subkriteria')->delete();

        \DB::table('subkriteria')->insert(array (
            array(
                'id' => 1,
                'kriteria_id' => 1,
                'nama' => 'Rp 0,-',
                'prioritas' => 1,
                'bobot' => 0.0,
            ),
            array(
                'id' => 2,
                'kriteria_id' => 1,
                'nama' => 'Rp 600.000',
                'prioritas' => 2,
                'bobot' => 0.14285714285714,
            ),
            array(
                'id' => 3,
                'kriteria_id' => 1,
                'nama' => 'Rp 600.001 s.d. 1.500.000,-',
                'prioritas' => 3,
                'bobot' => 0.28571428571429,
            ),
            array(
                'id' => 4,
                'kriteria_id' => 1,
                'nama' => 'Rp 1.500.001 s.d. 3.000.000,-',
                'prioritas' => 4,
                'bobot' => 0.42857142857143,
            ),
            array(
                'id' => 5,
                'kriteria_id' => 1,
                'nama' => 'Rp 3.000.001 s.d. 4.500.000,-',
                'prioritas' => 5,
                'bobot' => 0.57142857142857,
            ),
            array(
                'id' => 6,
                'kriteria_id' => 1,
                'nama' => 'Rp 4.500.001 s.d. 6.500.000,-',
                'prioritas' => 6,
                'bobot' => 0.71428571428571,
            ),
            array(
                'id' => 7,
                'kriteria_id' => 1,
                'nama' => 'Rp 6.500.001 s.d. 10 juta',
                'prioritas' => 7,
                'bobot' => 0.85714285714286,
            ),
            array(
                'id' => 8,
                'kriteria_id' => 1,
                'nama' => 'Di atas Rp 10 juta',
                'prioritas' => 8,
                'bobot' => 1.0,
            ),
            array(
                'id' => 9,
                'kriteria_id' => 2,
                'nama' => 'Lebih dari 5 orang',
                'prioritas' => 1,
                'bobot' => 1.0,
            ),
            array(
                'id' => 10,
                'kriteria_id' => 2,
                'nama' => '5 orang',
                'prioritas' => 2,
                'bobot' => 0.8,
            ),
            array(
                'id' => 11,
                'kriteria_id' => 2,
                'nama' => '4 orang',
                'prioritas' => 3,
                'bobot' => 0.6,
            ),
            array(
                'id' => 12,
                'kriteria_id' => 2,
                'nama' => '3 orang',
                'prioritas' => 4,
                'bobot' => 0.4,
            ),
            array(
                'id' => 13,
                'kriteria_id' => 2,
                'nama' => '2 orang',
                'prioritas' => 5,
                'bobot' => 0.2,
            ),
            array(
                'id' => 14,
                'kriteria_id' => 2,
                'nama' => '1 orang',
                'prioritas' => 6,
                'bobot' => 0.0,
            ),
            array(
                'id' => 15,
                'kriteria_id' => 3,
                'nama' => 'Sungai/danau/sumur galian',
                'prioritas' => 1,
                'bobot' => 0.0,
            ),
            array(
                'id' => 16,
                'kriteria_id' => 3,
                'nama' => 'Pompa air',
                'prioritas' => 2,
                'bobot' => 0.33333333333333,
            ),
            array(
                'id' => 17,
                'kriteria_id' => 3,
                'nama' => 'PDAM',
                'prioritas' => 3,
                'bobot' => 0.66666666666667,
            ),
            array(
                'id' => 18,
                'kriteria_id' => 3,
                'nama' => 'Kemasan',
                'prioritas' => 4,
                'bobot' => 1.0,
            ),
            array(
                'id' => 19,
                'kriteria_id' => 4,
                'nama' => 'Sungai/danau/sumur galian',
                'prioritas' => 1,
                'bobot' => 0.0,
            ),
            array(
                'id' => 20,
                'kriteria_id' => 4,
                'nama' => 'Pompa air',
                'prioritas' => 2,
                'bobot' => 0.33333333333333,
            ),
            array(
                'id' => 21,
                'kriteria_id' => 4,
                'nama' => 'PDAM',
                'prioritas' => 3,
                'bobot' => 0.66666666666667,
            ),
            array(
                'id' => 22,
                'kriteria_id' => 4,
                'nama' => 'Kemasan',
                'prioritas' => 4,
                'bobot' => 1.0,
            ),
            array(
                'id' => 23,
                'kriteria_id' => 5,
                'nama' => 'Tanpa listrik',
                'prioritas' => 1,
                'bobot' => 0.0,
            ),
            array(
                'id' => 24,
                'kriteria_id' => 5,
                'nama' => 'Menyambung tetangga',
                'prioritas' => 2,
                'bobot' => 0.5,
            ),
            array(
                'id' => 25,
                'kriteria_id' => 5,
                'nama' => 'Milik sendiri',
                'prioritas' => 3,
                'bobot' => 1.0,
            ),
            array(
                'id' => 26,
                'kriteria_id' => 6,
                'nama' => 'Tidak bayar listrik',
                'prioritas' => 1,
                'bobot' => 0.0,
            ),
            array(
                'id' => 27,
                'kriteria_id' => 6,
                'nama' => 'Rp 20.000 ke bawah',
                'prioritas' => 2,
                'bobot' => 0.14285714285714,
            ),
            array(
                'id' => 28,
                'kriteria_id' => 6,
                'nama' => 'Rp 20.001 s.d. 75.000',
                'prioritas' => 3,
                'bobot' => 0.28571428571429,
            ),
            array(
                'id' => 29,
                'kriteria_id' => 6,
                'nama' => 'Rp 75.001 s.d. 125.000',
                'prioritas' => 4,
                'bobot' => 0.42857142857143,
            ),
            array(
                'id' => 30,
                'kriteria_id' => 6,
                'nama' => 'Rp 125.001 s.d. 300.000',
                'prioritas' => 5,
                'bobot' => 0.57142857142857,
            ),
            array(
                'id' => 31,
                'kriteria_id' => 6,
                'nama' => 'Rp 300.001 s.d. 500.000',
                'prioritas' => 6,
                'bobot' => 0.71428571428571,
            ),
            array(
                'id' => 32,
                'kriteria_id' => 6,
                'nama' => 'Rp 500.001 s.d. 1000.000',
                'prioritas' => 7,
                'bobot' => 0.85714285714286,
            ),
            array(
                'id' => 33,
                'kriteria_id' => 6,
                'nama' => 'Di atas Rp 1.000.001',
                'prioritas' => 8,
                'bobot' => 1.0,
            ),
            array(
                'id' => 34,
                'kriteria_id' => 7,
                'nama' => 'Tidak memiliki',
                'prioritas' => 1,
                'bobot' => 0.0,
            ),
            array(
                'id' => 35,
                'kriteria_id' => 7,
                'nama' => 'Memiliki 1',
                'prioritas' => 2,
                'bobot' => 0.5,
            ),
            array(
                'id' => 36,
                'kriteria_id' => 7,
                'nama' => 'Memiliki lebih dari 1',
                'prioritas' => 3,
                'bobot' => 1.0,
            ),
            array(
                'id' => 37,
                'kriteria_id' => 8,
                'nama' => 'Tidak memiliki',
                'prioritas' => 1,
                'bobot' => 0.0,
            ),
            array(
                'id' => 38,
                'kriteria_id' => 8,
                'nama' => 'Memiliki 1',
                'prioritas' => 2,
                'bobot' => 0.5,
            ),
            array(
                'id' => 39,
                'kriteria_id' => 8,
                'nama' => 'Memiliki lebih dari 1',
                'prioritas' => 3,
                'bobot' => 1.0,
            ),
            array(
                'id' => 40,
                'kriteria_id' => 9,
                'nama' => 'Ada, dengan UKT persemester setinggi-tingginya Rp 1.000.000,-',
                'prioritas' => 1,
                'bobot' => 1.0,
            ),
            array(
                'id' => 41,
                'kriteria_id' => 9,
                'nama' => 'Ada, dengan UKT persemester setinggi-tingginya Rp 500.000,-',
                'prioritas' => 2,
                'bobot' => 0.66666666666667,
            ),
            array(
                'id' => 42,
                'kriteria_id' => 9,
                'nama' => 'Ada, dengan UKT persemester lebih dari Rp 1.000.000,-',
                'prioritas' => 3,
                'bobot' => 0.33333333333333,
            ),
            array(
                'id' => 43,
                'kriteria_id' => 9,
                'nama' => 'Tidak ada',
                'prioritas' => 4,
                'bobot' => 0.0,
            ),
            array(
                'id' => 44,
                'kriteria_id' => 10,
                'nama' => 'Menumpang',
                'prioritas' => 1,
                'bobot' => 0.0,
            ),
            array(
                'id' => 45,
                'kriteria_id' => 10,
                'nama' => 'Sewa Rp 300.000 sd 500.00/bulan',
                'prioritas' => 2,
                'bobot' => 0.33333333333333,
            ),
            array(
                'id' => 46,
                'kriteria_id' => 10,
                'nama' => 'Sewa > Rp 500.001',
                'prioritas' => 3,
                'bobot' => 0.66666666666667,
            ),
            array(
                'id' => 47,
                'kriteria_id' => 10,
                'nama' => 'Milik sendiri',
                'prioritas' => 4,
                'bobot' => 1.0,
            ),
            array(
                'id' => 48,
                'kriteria_id' => 11,
                'nama' => 'Memiliki',
                'prioritas' => 1,
                'bobot' => 1.0,
            ),
            array(
                'id' => 49,
                'kriteria_id' => 11,
                'nama' => 'Tidak memiliki',
                'prioritas' => 2,
                'bobot' => 0.0,
            ),
        ));


    }
}