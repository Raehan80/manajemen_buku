<x-app-layout>
    <x-slot name="header">
        <p class="mb-2 text-xs font-semibold uppercase tracking-[0.28em] text-emerald-300/70">Katalog</p>
        <h1 class="text-3xl font-semibold text-white">Tambah buku</h1>
    </x-slot>

    <section class="glass-panel mx-auto max-w-3xl p-6 sm:p-8">
        <p class="mb-6 text-sm text-emerald-100/55">Lengkapi informasi buku di bawah ini.</p>
        <form action="{{ route('books.store') }}" method="POST" class="space-y-5">
            @csrf
            @foreach (['title' => 'Judul buku', 'author' => 'Penulis', 'isbn' => 'ISBN', 'year' => 'Tahun terbit'] as $field => $label)
                <div>
                    <label for="{{ $field }}" class="mb-2 block text-sm font-medium text-emerald-50/80">{{ $label }}</label>
                    <input
                        id="{{ $field }}"
                        name="{{ $field }}"
                        type="{{ $field === 'year' ? 'number' : 'text' }}"
                        value="{{ old($field) }}"
                        @if ($field === 'year') min="1000" max="{{ now()->year + 5 }}" @endif
                        class="glass-input"
                        required
                    >
                    @error($field)
                        <p class="mt-2 text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
            @endforeach
            <div class="flex flex-col-reverse gap-3 border-t border-white/10 pt-5 sm:flex-row sm:justify-end">
                <a href="{{ route('books.index') }}" class="glass-button-muted">Batal</a>
                <button type="submit" class="glass-button-primary">Simpan buku</button>
            </div>
        </form>
    </section>
</x-app-layout>
