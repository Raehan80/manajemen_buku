<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $permissions = collect([
            'view-books',
            'create-books',
            'edit-books',
            'delete-books',
            'manage-users',
        ])->mapWithKeys(fn (string $name): array => [
            $name => Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]),
        ]);

        $admin = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $teacher = Role::firstOrCreate(['name' => 'Dosen', 'guard_name' => 'web']);
        $student = Role::firstOrCreate(['name' => 'Mahasiswa', 'guard_name' => 'web']);

        $admin
            ->syncPermissions($permissions->values());

        $teacher
            ->syncPermissions([
                $permissions['view-books'],
                $permissions['create-books'],
                $permissions['edit-books'],
            ]);

        $student
            ->syncPermissions([$permissions['view-books']]);

        User::query()->where('email', 'admin@mail.com')->first()?->syncRoles($admin);
        User::query()->where('email', 'dosen@mail.com')->first()?->syncRoles($teacher);
        User::query()->where('email', 'mahasiswa@mail.com')->first()?->syncRoles($student);

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        $permission = Permission::query()
            ->where('name', 'manage-users')
            ->where('guard_name', 'web')
            ->first();

        if ($permission === null) {
            return;
        }

        Role::query()
            ->where('guard_name', 'web')
            ->get()
            ->each(fn (Role $role) => $role->revokePermissionTo($permission));

        $permission->delete();

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }
};
