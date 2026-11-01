<nav x-data="{ open: false }" class="sticky top-0 z-40 border-b border-white/10 bg-[#071b15]/80 backdrop-blur-xl">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-xl border border-emerald-200/20 bg-emerald-300/10 text-lg font-bold text-emerald-200">B</span>
                <span class="hidden text-sm font-bold tracking-wide text-emerald-50 sm:block">RUANG BACA</span>
            </a>

            <div class="hidden items-center gap-2 md:flex">
                <a href="{{ route('dashboard') }}" @class([
                    'rounded-lg px-3 py-2 text-sm transition hover:bg-white/5 hover:text-white',
                    'bg-white/10 text-white' => request()->routeIs('dashboard'),
                    'text-emerald-100/60' => ! request()->routeIs('dashboard'),
                ])>Dashboard</a>
                @can('view-books')
                    <a href="{{ route('books.index') }}" @class([
                        'rounded-lg px-3 py-2 text-sm transition hover:bg-white/5 hover:text-white',
                        'bg-white/10 text-white' => request()->routeIs('books.*'),
                        'text-emerald-100/60' => ! request()->routeIs('books.*'),
                    ])>Katalog buku</a>
                @endcan
                @can('manage-users')
                    <a href="{{ route('users.roles.index') }}" @class([
                        'rounded-lg px-3 py-2 text-sm transition hover:bg-white/5 hover:text-white',
                        'bg-white/10 text-white' => request()->routeIs('users.roles.*'),
                        'text-emerald-100/60' => ! request()->routeIs('users.roles.*'),
                    ])>Pengguna</a>
                @endcan
            </div>
        </div>

        <div class="hidden items-center gap-3 md:flex">
            <a href="{{ route('profile.edit') }}" class="text-right leading-tight">
                <span class="block text-sm font-semibold text-emerald-50">{{ Auth::user()->name }}</span>
                <span class="text-xs text-emerald-100/45">{{ Auth::user()->getRoleNames()->implode(', ') ?: 'Pengguna' }}</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="glass-button-muted px-3 py-2 text-xs" type="submit">Ganti akun</button>
            </form>
        </div>

        <button type="button" class="glass-button-muted px-3 py-2 md:hidden" @click="open = !open" :aria-expanded="open" aria-label="Buka navigasi">
            <span x-text="open ? 'Tutup' : 'Menu'"></span>
        </button>
    </div>

    <div x-cloak x-show="open" x-transition class="border-t border-white/10 bg-[#071b15]/95 px-4 py-4 md:hidden">
        <div class="mx-auto flex max-w-7xl flex-col gap-2">
            <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 text-sm text-emerald-50/80 hover:bg-white/5">Dashboard</a>
            @can('view-books')
                <a href="{{ route('books.index') }}" class="rounded-lg px-3 py-2 text-sm text-emerald-50/80 hover:bg-white/5">Katalog buku</a>
            @endcan
            @can('manage-users')
                <a href="{{ route('users.roles.index') }}" class="rounded-lg px-3 py-2 text-sm text-emerald-50/80 hover:bg-white/5">Kelola pengguna</a>
            @endcan
            <a href="{{ route('profile.edit') }}" class="rounded-lg px-3 py-2 text-sm text-emerald-50/80 hover:bg-white/5">Profil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full rounded-lg px-3 py-2 text-left text-sm text-rose-200 hover:bg-rose-400/10" type="submit">Keluar / ganti akun</button>
            </form>
        </div>
    </div>
</nav>
