<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 1. Buat Permissions terkait Buku
        Permission::firstOrCreate(['name' => 'view-books', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'create-books', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'edit-books', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'delete-books', 'guard_name' => 'web']);
        Permission::firstOrCreate(['name' => 'manage-users', 'guard_name' => 'web']);

        $roleAdmin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $roleAdmin->syncPermissions(Permission::where('guard_name', 'web')->get());

        $roleDosen = Role::firstOrCreate(['name' => 'Dosen', 'guard_name' => 'web']);
        $roleDosen->syncPermissions(['view-books', 'create-books', 'edit-books']);

        $roleMahasiswa = Role::firstOrCreate(['name' => 'Mahasiswa', 'guard_name' => 'web']);
        $roleMahasiswa->syncPermissions(['view-books']);

        // 3. Buat Akun Pengujian untuk Masing-masing Role
        $admin = User::firstOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password')
            ]
        );
        $admin->syncRoles($roleAdmin);

        $dosen = User::firstOrCreate(
            ['email' => 'dosen@mail.com'],
            [
                'name' => 'Bapak Dosen',
                'password' => Hash::make('password')
            ]
        );
        $dosen->syncRoles($roleDosen);

        $mahasiswa = User::firstOrCreate(
            ['email' => 'mahasiswa@mail.com'],
            [
                'name' => 'Mahasiswa Teladan',
                'password' => Hash::make('password')
            ]
        );
        $mahasiswa->syncRoles($roleMahasiswa);

        User::query()
            ->whereDoesntHave('roles')
            ->each(fn (User $user) => $user->syncRoles($roleMahasiswa));

        User::query()
            ->whereIn('email', ['admin@mail.com', 'dosen@mail.com', 'mahasiswa@mail.com'])
            ->whereNull('email_verified_at')
            ->update(['email_verified_at' => Carbon::now()]);
    }
}