<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'kelola berita']);
        Permission::create(['name' => 'kelola profil']);
        Permission::create(['name' => 'kelola password']);
        Permission::create(['name' => 'kelola mahasiswa']);
        Permission::create(['name' => 'daftar beasiswa']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(['kelola berita', 'kelola profil', 'kelola password', 'kelola mahasiswa']);

        $mahasiswa = Role::create(['name' => 'mahasiswa']);
        $mahasiswa->givePermissionTo(['kelola profil', 'kelola password', 'daftar beasiswa']);
    }
}
