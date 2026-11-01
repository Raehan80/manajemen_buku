<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Ruang Baca</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col items-center justify-center gap-6 px-4 py-12">
            <div class="text-center">
                <a href="/">
                    <span class="mx-auto grid h-16 w-16 place-items-center rounded-2xl border border-emerald-200/20 bg-emerald-300/10 text-3xl text-emerald-200 shadow-xl shadow-emerald-950/30">B</span>
                </a>
                <p class="mt-4 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-200/60">Ruang Baca</p>
            </div>

            <div class="glass-panel w-full max-w-md overflow-hidden p-6 sm:p-8">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
