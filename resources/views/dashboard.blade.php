<x-app-layout>
    <x-slot name="header">
        <p class="mb-2 text-xs font-semibold uppercase tracking-[0.28em] text-emerald-300/70">Perpustakaan digital</p>
        <h1 class="text-3xl font-semibold tracking-tight text-white sm:text-4xl">Selamat datang, {{ Auth::user()->name }}</h1>
        <p class="mt-2 text-sm text-emerald-100/55">Koleksi bacaan dan akses Anda, tersusun dalam satu tempat.</p>
    </x-slot>

    <div class="grid gap-5 lg:grid-cols-[1.4fr_0.8fr]">
        <section class="glass-panel relative overflow-hidden p-6 sm:p-8">
            <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full bg-emerald-300/10 blur-3xl"></div>
            <div class="relative">
                <span class="inline-flex rounded-full border border-emerald-200/15 bg-emerald-300/10 px-3 py-1 text-xs font-medium text-emerald-100">
                    {{ Auth::user()->getRoleNames()->implode(', ') ?: 'Pengguna' }}
                </span>
                <h2 class="mt-6 max-w-xl text-3xl font-semibold leading-tight text-white sm:text-4xl">Jelajahi pengetahuan, satu buku dalam satu waktu.</h2>
                <p class="mt-4 max-w-lg text-sm leading-6 text-emerald-100/55">Cari koleksi perpustakaan, temukan bacaan berikutnya, dan kelola katalog sesuai hak akses akun Anda.</p>
                <a href="{{ route('books.index') }}" class="glass-button-primary mt-7">Jelajahi katalog <span aria-hidden="true">→</span></a>
            </div>
        </section>

        <section class="grid gap-5 sm:grid-cols-2 lg:grid-cols-1">
            <div class="glass-panel flex items-center justify-between p-5">
                <div>
                    <p class="text-sm text-emerald-100/55">Total koleksi</p>
                    <p class="mt-2 text-3xl font-semibold text-white">{{ number_format($bookCount) }}</p>
                    <a href="{{ route('books.index') }}" class="mt-3 inline-block text-xs font-semibold text-emerald-300 hover:text-emerald-200">Lihat buku <span aria-hidden="true">→</span></a>
                </div>
                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-emerald-300/10 text-2xl text-emerald-200" aria-hidden="true">▤</span>
            </div>

            @can('manage-users')
                <div class="glass-panel flex items-center justify-between p-5">
                    <div>
                        <p class="text-sm text-emerald-100/55">Pengguna terdaftar</p>
                        <p class="mt-2 text-3xl font-semibold text-white">{{ number_format($userCount) }}</p>
                        <a href="{{ route('users.roles.index') }}" class="mt-3 inline-block text-xs font-semibold text-emerald-300 hover:text-emerald-200">Kelola role <span aria-hidden="true">→</span></a>
                    </div>
                    <span class="grid h-12 w-12 place-items-center rounded-2xl bg-emerald-300/10 text-2xl text-emerald-200" aria-hidden="true">◎</span>
                </div>
            @else
                <div class="glass-panel p-5">
                    <p class="text-sm text-emerald-100/55">Hak akses Anda</p>
                    <p class="mt-2 text-lg font-semibold text-white">{{ Auth::user()->getRoleNames()->implode(', ') ?: 'Pengguna' }}</p>
                    <p class="mt-2 text-xs leading-5 text-emerald-100/45">Menu dan tindakan yang tersedia mengikuti role akun Anda.</p>
                </div>
            @endcan
        </section>
    </div>

    <section class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        <div class="glass-panel p-5">
            <span class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-300/70">01 · Jelajahi</span>
            <h3 class="mt-3 font-semibold text-white">Lihat seluruh buku</h3>
            <p class="mt-2 text-sm leading-6 text-emerald-100/50">Cari judul, penulis, atau ISBN dari katalog perpustakaan.</p>
        </div>
        @can('create-books')
            <div class="glass-panel p-5">
                <span class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-300/70">02 · Kembangkan</span>
                <h3 class="mt-3 font-semibold text-white">Tambah dan perbarui koleksi</h3>
                <p class="mt-2 text-sm leading-6 text-emerald-100/50">Admin dan dosen dapat menjaga informasi buku tetap akurat.</p>
            </div>
        @endcan
        @can('delete-books')
            <div class="glass-panel p-5">
                <span class="text-xs font-semibold uppercase tracking-[0.18em] text-emerald-300/70">03 · Administrasi</span>
                <h3 class="mt-3 font-semibold text-white">Kelola akses dan koleksi</h3>
                <p class="mt-2 text-sm leading-6 text-emerald-100/50">Admin dapat menghapus buku dan mengatur role pengguna.</p>
            </div>
        @endcan
    </section>
</x-app-layout>
