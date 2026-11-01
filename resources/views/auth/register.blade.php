<x-guest-layout>
    <div class="mb-7">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-300/70">Ruang baca</p>
        <h1 class="mt-2 text-2xl font-semibold text-white">Buat akun</h1>
        <p class="mt-2 text-sm text-emerald-100/50">Akun baru mendapat akses sebagai Mahasiswa.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5">
        @csrf
        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-emerald-50/80">Nama</label>
            <input id="name" class="glass-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Nama lengkap">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-sm text-rose-300" />
        </div>
        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-emerald-50/80">Email</label>
            <input id="email" class="glass-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="nama@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-300" />
        </div>
        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-emerald-50/80">Password</label>
            <input id="password" class="glass-input" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-300" />
        </div>
        <div>
            <label for="password_confirmation" class="mb-2 block text-sm font-medium text-emerald-50/80">Konfirmasi password</label>
            <input id="password_confirmation" class="glass-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-rose-300" />
        </div>
        <button type="submit" class="glass-button-primary w-full">Buat akun</button>
    </form>

    <p class="mt-6 text-center text-sm text-emerald-100/50">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="font-semibold text-emerald-300 hover:text-emerald-200">Masuk</a>
    </p>
</x-guest-layout>
