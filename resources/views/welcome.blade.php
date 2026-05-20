<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BioskopKu</title>
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
<body class="bg-[#0f0f13] text-white min-h-screen">
    <nav class="sticky top-0 z-50 border-b border-white/5 bg-[#0f0f13]/80 px-6 py-4 backdrop-blur-md">
        <div class="mx-auto flex max-w-6xl items-center justify-between gap-4">
            <a href="{{ $homeUrl }}" class="text-lg font-semibold tracking-tight text-white">
                <span class="text-indigo-400">Bioskop</span>Ku
            </a>

            <div class="flex flex-wrap items-center justify-end gap-2">
                @auth
                    @if($previewMode)
                        <span class="rounded-full border border-cyan-400/30 bg-cyan-400/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.25em] text-cyan-200">
                            Mode Preview Admin
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
            <div class="mx-auto flex max-w-6xl flex-col gap-4 px-6 py-5 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-200">Live Preview Admin</p>
                    <h1 class="mt-2 text-xl font-bold text-white">Anda sedang melihat halaman user dalam mode preview aman.</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-cyan-50/80">
                        Dari sini admin hanya meninjau tampilan. Untuk keluar dari preview, gunakan tombol
                        <span class="font-semibold text-white">Kembali ke Dashboard</span>.
                        Tombol logout di kanan akan mengakhiri sesi admin sepenuhnya.
                    </p>
                </div>
                <a href="{{ route('admin.dashboard') }}"
                   class="inline-flex rounded-full bg-cyan-300 px-5 py-3 text-sm font-semibold text-slate-950 transition hover:bg-cyan-200">
                    Keluar dari Preview
                </a>
            </div>
        </section>
    @endif

    <section class="px-6 py-20 text-center">
        <p class="mb-4 text-xs font-medium uppercase tracking-[0.35em] text-indigo-400">Selamat Datang</p>
        <h2 class="mb-4 text-4xl font-bold leading-tight text-white sm:text-5xl">
            Film favorit kamu,<br><span class="text-indigo-400">ada di sini.</span>
        </h2>
        <p class="mx-auto max-w-md text-sm text-gray-500">
            Temukan jadwal tayang terbaru dan pesan tiket bioskop kesayanganmu dengan mudah.
        </p>

        @auth
            @if(! $previewMode)
                <div class="mt-8 flex flex-wrap justify-center gap-3">
                    <a href="{{ route('eticket.index') }}"
                       class="inline-flex items-center rounded-full bg-indigo-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-indigo-950/40 transition hover:bg-indigo-500">
                        Lihat History Tiket
                    </a>
                </div>
            @endif
        @endauth
    </section>

    <main class="mx-auto max-w-6xl px-6 pb-20">
        <section class="mb-16">
            <div class="mb-8 flex items-center gap-3">
                <div class="h-5 w-1 rounded-full bg-indigo-500"></div>
                <h3 class="text-base font-semibold tracking-tight text-white">Film Tersedia</h3>
            </div>

            @if($films->count())
                <div class="grid grid-cols-2 gap-5 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5">
                    @foreach($films as $film)
                        <a href="{{ $previewMode ? route('admin.preview.films.show', $film) : route('films.detail', $film) }}"
                           class="group block overflow-hidden rounded-2xl border border-white/5 bg-[#16161d] transition-all duration-300 hover:border-indigo-500/40 hover:shadow-lg hover:shadow-indigo-900/20">
                            <div class="flex h-72 w-full items-center justify-center overflow-hidden bg-[#0f0f13]">
                                @if($film->poster_url)
                                    <img src="{{ $film->poster_url }}"
                                         alt="{{ $film->judul }}"
                                         class="h-72 w-full object-contain transition-transform duration-500 ease-in-out group-hover:scale-105">
                                @else
                                    <div class="text-4xl transition-transform duration-500 group-hover:scale-110">FILM</div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h4 class="truncate text-sm font-medium text-white">{{ $film->judul }}</h4>
                                <p class="mt-1 text-xs text-indigo-400/80">{{ $film->genre }}</p>
                                <p class="mt-1 text-xs text-gray-600">{{ $film->durasi }} menit</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @else
                <div class="py-16 text-center text-sm text-gray-600">Belum ada film tersedia.</div>
            @endif
        </section>

        <section>
            <div class="mb-8 flex items-center gap-3">
                <div class="h-5 w-1 rounded-full bg-amber-500"></div>
                <h3 class="text-base font-semibold tracking-tight text-white">Jadwal Tayang Hari Ini</h3>
            </div>

            @if($schedules->count())
                <div class="overflow-hidden rounded-2xl border border-white/5">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-white/[0.03] text-left text-xs uppercase tracking-wider text-gray-500">
                                <th class="px-5 py-4 font-medium">Film</th>
                                <th class="px-5 py-4 font-medium">Studio</th>
                                <th class="px-5 py-4 font-medium">Jam</th>
                                <th class="px-5 py-4 font-medium">Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $index => $schedule)
                                <tr class="{{ $index % 2 === 0 ? 'bg-white/[0.01]' : '' }} border-t border-white/5 transition hover:bg-indigo-500/5">
                                    <td class="px-5 py-4 font-medium text-white">{{ $schedule->film->judul }}</td>
                                    <td class="px-5 py-4 text-gray-500">{{ $schedule->studio }}</td>
                                    <td class="px-5 py-4 text-amber-400 font-semibold">{{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}</td>
                                    <td class="px-5 py-4 text-emerald-400 font-semibold">Rp {{ number_format($schedule->harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="rounded-2xl border border-white/5 py-16 text-center text-sm text-gray-600">
                    Tidak ada jadwal tayang hari ini.
                </div>
            @endif
        </section>
    </main>

    <footer class="border-t border-white/5 py-6 text-center text-xs text-gray-700">
        Copyright {{ date('Y') }} BioskopKu. All rights reserved.
    </footer>
</body>
</html>
