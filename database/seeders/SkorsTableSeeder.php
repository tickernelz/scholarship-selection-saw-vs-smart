<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SkorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('skors')->delete();

        \DB::table('skors')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'mahasiswa_id' => 3,
                    'tahun_akademik_id' => 1,
                    'skor_saw' => 0.86,
                    'skor_smart' => 0.79666666666667,
                    'created_at' => '2022-11-06 18:29:06',
                    'updated_at' => '2022-11-06 18:36:34',
                    'archived_at' => NULL,
                ),
            1 =>
                array(
                    'id' => 2,
                    'mahasiswa_id' => 7,
                    'tahun_akademik_id' => 1,
                    'skor_saw' => 0.79416666666667,
                    'skor_smart' => 0.59833333333333,
                    'created_at' => '2022-11-06 18:29:06',
                    'updated_at' => '2022-11-06 18:36:34',
                    'archived_at' => NULL,
                ),
            2 =>
                array(
                    'id' => 3,
                    'mahasiswa_id' => 8,
                    'tahun_akademik_id' => 1,
                    'skor_saw' => 0.72,
                    'skor_smart' => 0.59833333333333,
                    'created_at' => '2022-11-06 18:29:06',
                    'updated_at' => '2022-11-06 18:36:34',
                    'archived_at' => NULL,
                ),
            3 =>
                array(
                    'id' => 4,
                    'mahasiswa_id' => 10,
                    'tahun_akademik_id' => 1,
                    'skor_saw' => 0.70583333333333,
                    'skor_smart' => 0.455,
                    'created_at' => '2022-11-06 18:29:06',
                    'updated_at' => '2022-11-06 18:36:34',
                    'archived_at' => NULL,
                ),
            4 =>
                array(
                    'id' => 5,
                    'mahasiswa_id' => 9,
                    'tahun_akademik_id' => 1,
                    'skor_saw' => 0.7,
                    'skor_smart' => 0.57333333333333,
                    'created_at' => '2022-11-06 18:29:06',
                    'updated_at' => '2022-11-06 18:36:34',
                    'archived_at' => NULL,
                ),
            5 =>
                array(
                    'id' => 6,
                    'mahasiswa_id' => 2,
                    'tahun_akademik_id' => 1,
                    'skor_saw' => 0.665,
                    'skor_smart' => 0.52333333333333,
                    'created_at' => '2022-11-06 18:29:06',
                    'updated_at' => '2022-11-06 18:36:34',
                    'archived_at' => NULL,
                ),
            6 =>
                array(
                    'id' => 7,
                    'mahasiswa_id' => 4,
                    'tahun_akademik_id' => 1,
                    'skor_saw' => 0.66333333333333,
                    'skor_smart' => 0.52,
                    'created_at' => '2022-11-06 18:29:06',
                    'updated_at' => '2022-11-06 18:36:34',
                    'archived_at' => NULL,
                ),
            7 =>
                array(
                    'id' => 8,
                    'mahasiswa_id' => 6,
                    'tahun_akademik_id' => 1,
                    'skor_saw' => 0.61833333333333,
                    'skor_smart' => 0.44666666666667,
                    'created_at' => '2022-11-06 18:29:06',
                    'updated_at' => '2022-11-06 18:36:34',
                    'archived_at' => NULL,
                ),
            8 =>
                array(
                    'id' => 9,
                    'mahasiswa_id' => 5,
                    'tahun_akademik_id' => 1,
                    'skor_saw' => 0.6025,
                    'skor_smart' => 0.34833333333333,
                    'created_at' => '2022-11-06 18:29:06',
                    'updated_at' => '2022-11-06 18:36:34',
                    'archived_at' => NULL,
                ),
            9 =>
                array(
                    'id' => 10,
                    'mahasiswa_id' => 1,
                    'tahun_akademik_id' => 1,
                    'skor_saw' => 0.57166666666667,
                    'skor_smart' => 0.34666666666667,
                    'created_at' => '2022-11-06 18:29:06',
                    'updated_at' => '2022-11-06 18:36:34',
                    'archived_at' => NULL,
                ),
        ));


    }
}
