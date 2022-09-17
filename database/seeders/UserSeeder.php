<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@local.com',
            'password' => Hash::make('123'),
        ])->assignRole('admin');
        User::create([
            'name' => 'Mahasiswa',
            'email' => 'mahasiswa@local.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
    }
}
