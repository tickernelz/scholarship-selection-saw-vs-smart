<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BerkasTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('berkas')->delete();

        \DB::table('berkas')->insert(array(
            array(
                'id' => 1,
                'mahasiswa_id' => 1,
                'tahun_akademik_id' => 1,
                'file' => '1664625357_1xBet.pdf',
                'created_at' => '2022-10-01 18:55:48',
                'updated_at' => '2022-10-01 18:55:57',
            ),
            array(
                'id' => 2,
                'mahasiswa_id' => 3,
                'tahun_akademik_id' => 1,
                'file' => '1664625381_1xBet.pdf',
                'created_at' => '2022-10-01 18:56:16',
                'updated_at' => '2022-10-01 18:56:21',
            ),
            array(
                'id' => 3,
                'mahasiswa_id' => 2,
                'tahun_akademik_id' => 1,
                'file' => '1664625400_1xBet.pdf',
                'created_at' => '2022-10-01 18:56:32',
                'updated_at' => '2022-10-01 18:56:40',
            ),
        ));


    }
}
