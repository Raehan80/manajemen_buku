<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    public function up(): void
    {
        $studentRole = Role::findByName('Mahasiswa', 'web');

        User::query()
            ->whereDoesntHave('roles')
            ->each(fn (User $user) => $user->syncRoles($studentRole));

        app(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function down(): void
    {
        // Existing user role assignments are retained when rolling back access migrations.
    }
};
