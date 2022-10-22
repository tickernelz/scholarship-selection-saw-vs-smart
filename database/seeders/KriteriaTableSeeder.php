<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class KriteriaTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('kriteria')->delete();

        \DB::table('kriteria')->insert(array (
            array(
                'id' => 1,
                'nama' => 'Penghasilan orang tua atau sumber biaya kuliah',
                'tipe' => 'cost',
                'bobot' => 15.0,
                'required' => 1,
                'created_at' => '2022-10-01 02:20:07',
                'updated_at' => '2022-10-01 02:20:07',
            ),
            array(
                'id' => 2,
                'nama' => 'Jumlah orang dalam keluarga (termasuk kepala keluarga)',
                'tipe' => 'benefit',
                'bobot' => 8.0,
                'required' => 1,
                'created_at' => '2022-10-01 02:20:07',
                'updated_at' => '2022-10-01 02:20:17',
            ),
            array(
                'id' => 3,
                'nama' => 'Sumber air untuk MCK',
                'tipe' => 'cost',
                'bobot' => 5.0,
                'required' => 1,
                'created_at' => '2022-10-01 02:21:38',
                'updated_at' => '2022-10-01 02:23:31',
            ),
            array(
                'id' => 4,
                'nama' => 'Sumber air untuk konsumsi',
                'tipe' => 'cost',
                'bobot' => 5.0,
                'required' => 1,
                'created_at' => '2022-10-01 02:22:37',
                'updated_at' => '2022-10-01 02:23:40',
            ),
            array(
                'id' => 5,
                'nama' => 'Status listrik/penerangan rumah',
                'tipe' => 'cost',
                'bobot' => 10.0,
                'required' => 1,
                'created_at' => '2022-10-01 02:23:22',
                'updated_at' => '2022-10-01 02:23:22',
            ),
            array(
                'id' => 6,
                'nama' => 'Rata-rata biaya listrik 3 bulan terakhir',
                'tipe' => 'cost',
                'bobot' => 10.0,
                'required' => 1,
                'created_at' => '2022-10-01 02:25:30',
                'updated_at' => '2022-10-01 02:25:30',
            ),
            array(
                'id' => 7,
                'nama' => 'Mempunyai motor (roda dua)',
                'tipe' => 'cost',
                'bobot' => 5.0,
                'required' => 1,
                'created_at' => '2022-10-01 02:26:08',
                'updated_at' => '2022-10-01 02:26:08',
            ),
            array(
                'id' => 8,
                'nama' => 'Mempunyai mobil',
                'tipe' => 'cost',
                'bobot' => 7.0,
                'required' => 1,
                'created_at' => '2022-10-01 02:26:52',
                'updated_at' => '2022-10-01 02:26:52',
            ),
            array(
                'id' => 9,
                'nama' => 'Orang tua/sumber biaya kuliah memiliki tanggungan saudara kuliah lain',
                'tipe' => 'benefit',
                'bobot' => 10.0,
                'required' => 1,
                'created_at' => '2022-10-01 02:29:32',
                'updated_at' => '2022-10-01 02:29:32',
            ),
            array(
                'id' => 10,
                'nama' => 'Status rumah tinggal saat kuliah',
                'tipe' => 'cost',
                'bobot' => 10.0,
                'required' => 1,
                'created_at' => '2022-10-01 02:30:29',
                'updated_at' => '2022-10-01 02:30:29',
            ),
            array(
                'id' => 11,
                'nama' => 'Memiliki Surat Keterangan Tidak Mampu (SKTM) atau Kartu Indonesia Pintar (KIP) atau Kartu Program Keluarga Harapan (PKH)',
                'tipe' => 'benefit',
                'bobot' => 15.0,
                'required' => 0,
                'created_at' => '2022-10-01 02:31:17',
                'updated_at' => '2022-10-01 02:31:17',
            ),
        ));


    }
}
