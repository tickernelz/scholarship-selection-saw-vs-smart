<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            MahasiswaSeeder::class,
            KriteriaTableSeeder::class,
            SubKriteriaTableSeeder::class,
            BeasiswasTableSeeder::class,
            BerkasTableSeeder::class,
        ]);
    }
}
