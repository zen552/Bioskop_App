<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $film->judul }} | BioskopKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
@php
    $isAdminViewer = auth()->check() && auth()->user()->isAdmin();
    $previewMode = ($previewMode ?? false) || $isAdminViewer;
    $homeUrl = $previewMode ? route('admin.preview') : url('/');
@endphp
<body class="min-h-screen bg-[#0f0f13] text-white">
    <nav class="sticky top-0 z-50 border-b border-white/5 bg-[#0f0f13]/80 px-6 py-4 backdrop-blur-md">
        <div class="mx-auto flex max-w-4xl items-center justify-between gap-4">
            <a href="{{ $homeUrl }}" class="text-lg font-semibold tracking-tight text-white">
                <span class="text-indigo-400">Bioskop</span>Ku
            </a>

            <div class="flex flex-wrap items-center justify-end gap-2">
                @auth
                    @if($previewMode)
                        <span class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-cyan-200">
                            Preview Admin
                        </span>
                        <a href="{{ route('admin.dashboard') }}"
                           class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-medium text-gray-200 transition hover:bg-white/10">
                            Kembali ke Dashboard
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-full border border-red-400/20 bg-red-400/10 px-4 py-2 text-xs font-medium text-red-100 transition hover:bg-red-400/20">
                                Logout Admin
                            </button>
                        </form>
                    @else
                        <a href="{{ route('eticket.index') }}"
                           class="rounded-full border border-indigo-500/30 bg-indigo-600/20 px-4 py-2 text-xs font-medium text-indigo-300 transition hover:bg-indigo-600/35">
                            Tiket Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-medium text-gray-300 transition hover:bg-white/10">
                                Keluar
                            </button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}"
                       class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-medium text-gray-300 transition hover:bg-white/10">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="rounded-full bg-indigo-600 px-4 py-2 text-xs font-medium text-white transition hover:bg-indigo-500">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    @if($previewMode)
        <section class="border-b border-cyan-400/10 bg-cyan-400/10">
            <div class="mx-auto max-w-4xl px-6 py-5">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-200">Live Preview Admin</p>
                <p class="mt-2 max-w-2xl text-sm leading-6 text-cyan-50/85">
                    Halaman ini hanya untuk meninjau detail film dan jadwal tampilannya. Kartu jadwal di bawah tidak dapat dipakai untuk melanjutkan booking.
                </p>
            </div>
        </section>
    @endif

    <main class="mx-auto max-w-4xl px-6 py-10">
        <a href="{{ $homeUrl }}"
           class="mb-8 inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-medium text-gray-400 transition hover:bg-white/10 hover:text-white">
            Kembali ke {{ $previewMode ? 'Live Preview' : 'Beranda' }}
        </a>

        <section class="mb-12 flex flex-col gap-8 rounded-2xl border border-white/5 bg-[#16161d] p-6 sm:flex-row">
            @if($film->poster_url)
                <img src="{{ $film->poster_url }}"
                     alt="{{ $film->judul }}"
                     class="h-64 w-44 flex-shrink-0 rounded-xl bg-[#0f0f13] object-contain">
            @else
                <div class="flex h-64 w-44 flex-shrink-0 items-center justify-center rounded-xl bg-[#0f0f13] text-5xl">
                    FILM
                </div>
            @endif

            <div class="flex flex-col justify-center">
                <p class="mb-2 text-xs font-medium uppercase tracking-[0.35em] text-indigo-400">Detail Film</p>
                <h1 class="mb-3 text-2xl font-bold leading-snug text-white sm:text-3xl">{{ $film->judul }}</h1>
                <div class="mb-4 flex flex-wrap gap-2">
                    @foreach(array_filter(array_map('trim', preg_split('/[\/,]/', $film->genre))) as $g)
                        <span class="rounded-full border border-indigo-500/30 bg-indigo-600/20 px-3 py-1 text-xs text-indigo-300">
                            {{ $g }}
                        </span>
                    @endforeach
                    <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-xs text-gray-400">
                        {{ $film->durasi }} menit
                    </span>
                </div>
                <p class="text-sm leading-relaxed text-gray-400">{{ $film->deskripsi }}</p>
            </div>
        </section>

        <section>
            <div class="mb-6 flex items-center gap-3">
                <div class="h-5 w-1 rounded-full bg-amber-500"></div>
                <h2 class="text-base font-semibold tracking-tight text-white">Jadwal Tayang</h2>
            </div>

            @if($schedules->count())
                @foreach($schedules->groupBy('tanggal') as $tanggal => $jadwals)
                    <div class="mb-6">
                        <p class="mb-3 text-xs font-medium uppercase tracking-wide text-amber-400/80">
                            {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                        </p>
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            @foreach($jadwals as $jadwal)
                                @if($previewMode)
                                    <div class="rounded-2xl border border-white/5 bg-[#16161d] p-4 opacity-90">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-2xl font-bold tracking-tight text-amber-400">
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_tayang)->format('H:i') }}
                                                </p>
                                                <p class="mt-1 text-xs text-gray-500">{{ $jadwal->studio }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-emerald-400">
                                                    Rp {{ number_format($jadwal->harga, 0, ',', '.') }}
                                                </p>
                                                <p class="mt-2 text-[11px] text-cyan-200">Preview only</p>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ route('booking.seats', $jadwal->id) }}"
                                       class="block rounded-2xl border border-white/5 bg-[#16161d] p-4 transition-all duration-200 hover:border-indigo-500/40 hover:shadow-md hover:shadow-indigo-900/10">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-2xl font-bold tracking-tight text-amber-400">
                                                    {{ \Carbon\Carbon::parse($jadwal->jam_tayang)->format('H:i') }}
                                                </p>
                                                <p class="mt-1 text-xs text-gray-500">{{ $jadwal->studio }}</p>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-sm font-semibold text-emerald-400">
                                                    Rp {{ number_format($jadwal->harga, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="rounded-2xl border border-white/5 py-16 text-center text-sm text-gray-600">
                    Belum ada jadwal tayang untuk film ini.
                </div>
            @endif
        </section>
    </main>

    <footer class="border-t border-white/5 py-6 text-center text-xs text-gray-700">
        Copyright {{ date('Y') }} BioskopKu. All rights reserved.
    </footer>
</body>
</html>
