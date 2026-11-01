<x-app-layout>
    <x-slot name="header">
        <p class="mb-2 text-xs font-semibold uppercase tracking-[0.28em] text-emerald-300/70">Akses administrator</p>
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
            <div>
                <h1 class="text-3xl font-semibold tracking-tight text-white sm:text-4xl">Kelola pengguna</h1>
                <p class="mt-2 text-sm text-emerald-100/55">Atur role dan hak akses untuk setiap akun.</p>
            </div>
            <span class="glass-subpanel px-4 py-2 text-sm text-emerald-100/70">{{ $users->total() }} akun</span>
        </div>
    </x-slot>

    @if (session('success'))
        <div role="status" class="mb-6 rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    <section class="glass-panel overflow-hidden">
        <div class="border-b border-white/10 px-5 py-5 sm:px-6">
            <h2 class="font-semibold text-white">Akun terdaftar</h2>
            <p class="mt-1 text-sm text-emerald-100/45">Pengguna baru secara otomatis mendapat role Mahasiswa.</p>
        </div>
        <div class="overflow-x-auto">
            <table class="glass-table w-full min-w-[700px]">
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Email</th>
                        <th>Role saat ini</th>
                        <th>Ubah role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-white/[0.03]">
                            <td class="font-medium text-white">{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="rounded-full border border-emerald-200/10 bg-emerald-300/10 px-3 py-1 text-xs text-emerald-100">
                                    {{ $user->roles->pluck('name')->implode(', ') ?: 'Belum ada role' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('users.roles.update', $user) }}" method="POST" class="flex items-start gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <label for="role-{{ $user->id }}" class="sr-only">Role untuk {{ $user->name }}</label>
                                    <select id="role-{{ $user->id }}" name="role_id" class="glass-input min-w-36 py-2">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}" @selected($user->roles->contains('id', $role->id))>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="glass-button-primary shrink-0 px-3 py-2">Simpan</button>
                                </form>
                                @error('role_id')
                                    <p class="mt-2 text-xs text-rose-300">{{ $message }}</p>
                                @enderror
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($users->hasPages())
            <div class="border-t border-white/10 px-5 py-4 sm:px-6">
                {{ $users->links() }}
            </div>
        @endif
    </section>
</x-app-layout>
