<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ruang Baca</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <main class="mx-auto flex min-h-screen max-w-7xl flex-col px-4 sm:px-6 lg:px-8">
            <header class="flex items-center justify-between py-6">
                <a href="/" class="flex items-center gap-3">
                    <span class="grid h-10 w-10 place-items-center rounded-xl border border-emerald-200/20 bg-emerald-300/10 text-lg font-bold text-emerald-200">B</span>
                    <span class="text-sm font-bold tracking-[0.16em] text-emerald-50">RUANG BACA</span>
                </a>
                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="glass-button-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="glass-button-muted">Masuk</a>
                        <a href="{{ route('register') }}" class="glass-button-primary">Buat akun</a>
                    @endauth
                </div>
            </header>

            <section class="grid flex-1 items-center gap-12 py-12 lg:grid-cols-[1.1fr_0.9fr] lg:py-20">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-emerald-200/15 bg-emerald-300/[0.07] px-4 py-2 text-xs font-medium tracking-wide text-emerald-100/80">
                        <span class="h-2 w-2 rounded-full bg-emerald-300"></span>
                        Perpustakaan digital
                    </span>
                    <h1 class="mt-7 max-w-3xl text-5xl font-semibold leading-[1.08] tracking-tight text-white sm:text-6xl">
                        Setiap buku membuka <span class="text-emerald-300">kemungkinan baru.</span>
                    </h1>
                    <p class="mt-6 max-w-xl text-base leading-7 text-emerald-100/55">
                        Jelajahi koleksi, temukan inspirasi, dan nikmati pengalaman perpustakaan dengan akses yang tertata untuk setiap pengguna.
                    </p>
                    <div class="mt-8 flex flex-wrap gap-3">
                        @auth
                            <a href="{{ route('books.index') }}" class="glass-button-primary">Jelajahi katalog <span aria-hidden="true">→</span></a>
                        @else
                            <a href="{{ route('register') }}" class="glass-button-primary">Mulai membaca <span aria-hidden="true">→</span></a>
                            <a href="{{ route('login') }}" class="glass-button-muted">Saya sudah punya akun</a>
                        @endauth
                    </div>
                    <div class="mt-12 flex flex-wrap gap-x-8 gap-y-4 border-t border-white/10 pt-6">
                        <div>
                            <p class="text-xl font-semibold text-white">Katalog</p>
                            <p class="mt-1 text-xs text-emerald-100/45">Mudah dijelajahi</p>
                        </div>
                        <div>
                            <p class="text-xl font-semibold text-white">Akses teratur</p>
                            <p class="mt-1 text-xs text-emerald-100/45">Sesuai role pengguna</p>
                        </div>
                        <div>
                            <p class="text-xl font-semibold text-white">Ruang belajar</p>
                            <p class="mt-1 text-xs text-emerald-100/45">Untuk semua pembaca</p>
                        </div>
                    </div>
                </div>

                <div class="glass-panel relative mx-auto w-full max-w-lg p-5 sm:p-7">
                    <div class="pointer-events-none absolute -right-10 -top-10 h-48 w-48 rounded-full bg-emerald-300/10 blur-3xl"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-300/70">Pilihan hari ini</p>
                                <h2 class="mt-2 text-xl font-semibold text-white">Jelajahi tanpa batas</h2>
                            </div>
                            <span class="grid h-12 w-12 place-items-center rounded-2xl border border-emerald-200/10 bg-emerald-300/10 text-2xl text-emerald-200" aria-hidden="true">✦</span>
                        </div>
                        <div class="mt-7 space-y-3">
                            <div class="glass-subpanel flex items-center gap-4 p-4">
                                <span class="grid h-12 w-10 shrink-0 place-items-center rounded-lg bg-gradient-to-br from-emerald-300/40 to-teal-900/70 text-lg text-emerald-100">01</span>
                                <div>
                                    <p class="font-medium text-white">Temukan koleksi</p>
                                    <p class="mt-1 text-xs text-emerald-100/45">Cari buku dari katalog perpustakaan.</p>
                                </div>
                            </div>
                            <div class="glass-subpanel flex items-center gap-4 p-4">
                                <span class="grid h-12 w-10 shrink-0 place-items-center rounded-lg bg-gradient-to-br from-teal-300/30 to-emerald-950 text-lg text-emerald-100">02</span>
                                <div>
                                    <p class="font-medium text-white">Kelola dengan bijak</p>
                                    <p class="mt-1 text-xs text-emerald-100/45">Akses kelola katalog berdasarkan peran.</p>
                                </div>
                            </div>
                            <div class="glass-subpanel flex items-center gap-4 p-4">
                                <span class="grid h-12 w-10 shrink-0 place-items-center rounded-lg bg-gradient-to-br from-lime-300/25 to-green-950 text-lg text-emerald-100">03</span>
                                <div>
                                    <p class="font-medium text-white">Terus belajar</p>
                                    <p class="mt-1 text-xs text-emerald-100/45">Simpan rasa ingin tahu, buka halaman berikutnya.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <footer class="border-t border-white/10 py-5 text-center text-xs text-emerald-100/35">
                Ruang Baca · Perpustakaan digital
            </footer>
        </main>
    </body>
</html>
