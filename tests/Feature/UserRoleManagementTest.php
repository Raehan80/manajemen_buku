<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserRoleManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_view_the_user_role_management_page(): void
    {
        $this->seed(RolePermissionSeeder::class);
        $student = User::query()->where('email', 'mahasiswa@mail.com')->firstOrFail();
        $teacher = User::query()->where('email', 'dosen@mail.com')->firstOrFail();
        $admin = User::query()->where('email', 'admin@mail.com')->firstOrFail();

        $this->actingAs($student)->get('/users/roles')->assertForbidden();
        $this->actingAs($teacher)->get('/users/roles')->assertForbidden();
        $this->actingAs($admin)->get('/users/roles')->assertOk()->assertSee('Kelola pengguna');
    }

    public function test_admin_can_change_a_user_role_and_the_new_permission_takes_effect(): void
    {
        $this->seed(RolePermissionSeeder::class);
        $student = User::query()->where('email', 'mahasiswa@mail.com')->firstOrFail();
        $admin = User::query()->where('email', 'admin@mail.com')->firstOrFail();
        $teacherRole = Role::findByName('Dosen');

        $response = $this->actingAs($admin)->patch("/users/{$student->id}/role", [
            'role_id' => $teacherRole->id,
        ]);

        $response->assertRedirect(route('users.roles.index'));
        $this->assertTrue($student->fresh()->hasRole('Dosen'));
        $this->assertTrue($student->fresh()->can('create-books'));
    }

    public function test_admin_cannot_remove_the_last_admin_role(): void
    {
        $this->seed(RolePermissionSeeder::class);
        $admin = User::query()->where('email', 'admin@mail.com')->firstOrFail();
        $studentRole = Role::findByName('Mahasiswa');

        $response = $this->actingAs($admin)->from('/users/roles')->patch("/users/{$admin->id}/role", [
            'role_id' => $studentRole->id,
        ]);

        $response->assertRedirect('/users/roles')->assertSessionHasErrors('role_id');
        $this->assertTrue($admin->fresh()->hasRole('Admin'));
    }

    public function test_admin_role_update_rejects_an_unknown_role(): void
    {
        $this->seed(RolePermissionSeeder::class);
        $student = User::query()->where('email', 'mahasiswa@mail.com')->firstOrFail();
        $admin = User::query()->where('email', 'admin@mail.com')->firstOrFail();

        $response = $this->actingAs($admin)->from('/users/roles')->patch("/users/{$student->id}/role", [
            'role_id' => 99999,
        ]);

        $response->assertRedirect('/users/roles')->assertSessionHasErrors('role_id');
        $this->assertTrue($student->fresh()->hasRole('Mahasiswa'));
    }

    public function test_unassigned_legacy_users_receive_student_read_access(): void
    {
        $this->seed(RolePermissionSeeder::class);
        $user = User::factory()->create();

        $this->seed(RolePermissionSeeder::class);

        $this->assertTrue($user->fresh()->hasRole('Mahasiswa'));
        $this->assertTrue($user->fresh()->can('view-books'));
        $this->assertFalse($user->fresh()->can('create-books'));
    }
}
