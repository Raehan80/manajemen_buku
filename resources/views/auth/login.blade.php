<x-guest-layout>
    <div class="mb-7">
        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-emerald-300/70">Selamat datang kembali</p>
        <h1 class="mt-2 text-2xl font-semibold text-white">Masuk ke akun</h1>
        <p class="mt-2 text-sm text-emerald-100/50">Lanjutkan menjelajahi koleksi perpustakaan.</p>
    </div>

    <x-auth-session-status class="mb-4 text-sm text-emerald-200" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-emerald-50/80">Email</label>
            <input id="email" class="glass-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-rose-300" />
        </div>
        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-emerald-50/80">Password</label>
            <input id="password" class="glass-input" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-rose-300" />
        </div>
        <div class="flex items-center justify-between gap-3">
            <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-emerald-100/60">
                <input id="remember_me" type="checkbox" class="rounded border-white/20 bg-black/20 text-emerald-400 focus:ring-emerald-400/30" name="remember">
                Ingat saya
            </label>
            @if (Route::has('password.request'))
                <a class="text-sm text-emerald-300 hover:text-emerald-200" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>
        <button type="submit" class="glass-button-primary w-full">Masuk</button>
    </form>

    <p class="mt-6 text-center text-sm text-emerald-100/50">
        Belum punya akun?
        <a href="{{ route('register') }}" class="font-semibold text-emerald-300 hover:text-emerald-200">Daftar di sini</a>
    </p>
</x-guest-layout>
