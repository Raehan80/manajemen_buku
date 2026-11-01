<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
            <div>
                <p class="mb-2 text-xs font-semibold uppercase tracking-[0.28em] text-emerald-300/70">Perpustakaan digital</p>
                <h1 class="text-3xl font-semibold tracking-tight text-white sm:text-4xl">Katalog buku</h1>
                <p class="mt-2 text-sm text-emerald-100/55">Temukan koleksi dan kelola buku perpustakaan.</p>
            </div>
            @can('create-books')
                <a href="{{ route('books.create') }}" class="glass-button-primary">Tambah buku <span aria-hidden="true">+</span></a>
            @endcan
        </div>
    </x-slot>

    @if (session('success'))
        <div role="status" class="mb-6 rounded-xl border border-emerald-300/20 bg-emerald-400/10 px-4 py-3 text-sm text-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 grid gap-4 sm:grid-cols-2">
        <div class="glass-panel p-5">
            <p class="text-sm text-emerald-100/55">Total koleksi</p>
            <p class="mt-2 text-3xl font-semibold text-white">{{ number_format($bookCount) }}</p>
            <p class="mt-1 text-xs text-emerald-100/40">Buku terdaftar di perpustakaan</p>
        </div>
        <div class="glass-panel flex items-center justify-between gap-4 p-5">
            <div>
                <p class="text-sm text-emerald-100/55">Hak akses Anda</p>
                <p class="mt-2 text-lg font-semibold text-emerald-100">{{ auth()->user()->getRoleNames()->implode(', ') ?: 'Pengguna' }}</p>
            </div>
            <span class="grid h-11 w-11 place-items-center rounded-xl bg-emerald-300/10 text-xl text-emerald-200" aria-hidden="true">✦</span>
        </div>
    </div>

    <section class="glass-panel overflow-hidden">
        <div class="flex flex-col justify-between gap-4 border-b border-white/10 p-5 sm:flex-row sm:items-center sm:px-6">
            <div>
                <h2 class="font-semibold text-white">Daftar koleksi</h2>
                <p class="mt-1 text-sm text-emerald-100/45">Cari berdasarkan judul, penulis, atau ISBN.</p>
            </div>
            <form action="{{ route('books.index') }}" method="GET" class="flex w-full gap-2 sm:max-w-md">
                <label for="book-search" class="sr-only">Cari buku</label>
                <input id="book-search" name="search" value="{{ $search }}" class="glass-input" placeholder="Cari buku..." type="search">
                <button class="glass-button-muted shrink-0" type="submit">Cari</button>
                @if ($search !== '')
                    <a href="{{ route('books.index') }}" class="glass-button-muted shrink-0">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="glass-table w-full min-w-[640px]">
                <thead>
                    <tr>
                        <th>Judul buku</th>
                        <th>Penulis</th>
                        <th>ISBN</th>
                        <th>Tahun</th>
                        @canany(['edit-books', 'delete-books'])
                            <th class="text-right">Aksi</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr class="transition hover:bg-white/[0.03]">
                            <td class="font-medium text-white">{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td class="font-mono text-xs">{{ $book->isbn }}</td>
                            <td>{{ $book->year }}</td>
                            @canany(['edit-books', 'delete-books'])
                                <td class="text-right">
                                    <div class="flex justify-end gap-2">
                                        @can('edit-books')
                                            <a href="{{ route('books.edit', $book) }}" class="glass-button-muted px-3 py-2 text-xs">Edit</a>
                                        @endcan
                                        @can('delete-books')
                                            <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('Hapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="glass-button-danger px-3 py-2 text-xs">Hapus</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            @endcanany
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->canAny(['edit-books', 'delete-books']) ? 5 : 4 }}" class="py-12 text-center">
                                <span class="mb-2 block text-2xl text-emerald-200/50" aria-hidden="true">⌕</span>
                                <span class="font-medium text-emerald-50">Buku tidak ditemukan</span>
                                <span class="mt-1 block text-sm text-emerald-100/45">Coba kata kunci lain atau tambahkan koleksi baru.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($books->hasPages())
            <div class="border-t border-white/10 px-5 py-4 sm:px-6">
                {{ $books->links() }}
            </div>
        @endif
    </section>
</x-app-layout>
