<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    public function index(): View
    {
        return view('users.roles.index', [
            'users' => User::query()->with('roles')->orderBy('name')->paginate(15),
            'roles' => Role::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'role_id' => ['required', 'integer', Rule::exists('roles', 'id')],
        ]);

        $role = Role::query()->findOrFail($validated['role_id']);

        DB::transaction(function () use ($user, $role): void {
            if ($user->hasRole('Admin') && $role->name !== 'Admin' && User::role('Admin')->count() <= 1) {
                throw ValidationException::withMessages([
                    'role_id' => 'Akun admin terakhir tidak dapat kehilangan role Admin.',
                ]);
            }

            $user->syncRoles([$role]);
        });

        return to_route('users.roles.index')->with('success', 'Role pengguna berhasil diperbarui.');
    }
}
