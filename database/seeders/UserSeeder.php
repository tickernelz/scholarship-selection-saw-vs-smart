<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'email' => 'admin@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('admin');
        User::create([
            'name' => 'Zahratun Nisa',
            'email' => 'zahratunnisa@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
        User::create([
            'name' => 'Siti Taybah',
            'email' => 'sititaybah@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
        User::create([
            'name' => 'Fahrudin',
            'email' => 'fahrudin@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
        User::create([
            'name' => 'Freny Andriani',
            'email' => 'frenyandriani@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
        User::create([
            'name' => 'Aly Hidayat',
            'email' => 'alyhidayat@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
        User::create([
            'name' => 'Ahmad Khafillah',
            'email' => 'ahmadkhafillah@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
        User::create([
            'name' => 'Asep Hermawan',
            'email' => 'asephermawan@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
        User::create([
            'name' => 'Fitria Arifin',
            'email' => 'fitriaarifin@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
        User::create([
            'name' => 'Dandi Ramadani',
            'email' => 'dandiramadani@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
        User::create([
            'name' => 'Sri Wahyuni',
            'email' => 'sriwahyuni@test.com',
            'password' => Hash::make('123'),
        ])->assignRole('mahasiswa');
    }
}
