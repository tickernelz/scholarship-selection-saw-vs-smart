<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'lihat dashboard admin']);
        Permission::create(['name' => 'lihat dashboard mahasiswa']);
        Permission::create(['name' => 'kelola berita']);
        Permission::create(['name' => 'kelola profil']);
        Permission::create(['name' => 'kelola password']);
        Permission::create(['name' => 'kelola mahasiswa']);
        Permission::create(['name' => 'kelola kriteria']);
        Permission::create(['name' => 'kelola beasiswa']);
        Permission::create(['name' => 'kelola pengaturan']);
        Permission::create(['name' => 'daftar beasiswa']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['lihat dashboard admin', 'kelola berita', 'kelola profil', 'kelola password', 'kelola mahasiswa', 'kelola kriteria', 'kelola beasiswa', 'kelola pengaturan']);

        $mahasiswa = Role::create(['name' => 'mahasiswa']);
        $mahasiswa->givePermissionTo(['lihat dashboard mahasiswa', 'kelola profil', 'kelola password', 'daftar beasiswa']);
    }
}
