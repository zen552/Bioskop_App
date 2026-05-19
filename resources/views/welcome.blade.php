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
<body class="bg-[#0f0f13] text-white min-h-screen">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-[#0f0f13]/80 backdrop-blur-md border-b border-white/5 px-6 py-4 flex justify-between items-center">
        <span class="text-lg font-semibold tracking-tight text-white">🎬 <span class="text-indigo-400">Bioskop</span>Ku</span>
        <div class="flex gap-2">
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}"
                       class="text-xs font-medium bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 px-4 py-2 rounded-full hover:bg-indigo-600/40 transition">
                        Dashboard Admin
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs font-medium bg-white/5 text-gray-300 border border-white/10 px-4 py-2 rounded-full hover:bg-white/10 transition">
                        Keluar
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}"
                   class="text-xs font-medium bg-white/5 text-gray-300 border border-white/10 px-4 py-2 rounded-full hover:bg-white/10 transition">
                    Masuk
                </a>
                <a href="{{ route('register') }}"
                   class="text-xs font-medium bg-indigo-600 text-white px-4 py-2 rounded-full hover:bg-indigo-500 transition">
                    Daftar
                </a>
            @endauth
        </div>
    </nav>

    <!-- Hero -->
    <div class="text-center py-20 px-6">
        <p class="text-xs font-medium tracking-widest text-indigo-400 uppercase mb-4">Selamat Datang</p>
        <h1 class="text-4xl sm:text-5xl font-bold text-white mb-4 leading-tight">
            Film favorit kamu,<br><span class="text-indigo-400">ada di sini.</span>
        </h1>
        <p class="text-gray-500 text-sm max-w-md mx-auto">Temukan jadwal tayang terbaru dan pesan tiket bioskop kesayanganmu dengan mudah.</p>
    </div>

    <div class="max-w-6xl mx-auto px-6 pb-20">

        <!-- Daftar Film -->
        <section class="mb-16">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1 h-5 bg-indigo-500 rounded-full"></div>
                <h2 class="text-base font-semibold text-white tracking-tight">Film Tersedia</h2>
            </div>

            @if($films->count())
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-5">
                @foreach($films as $film)
                <a href="{{ route('films.detail', $film) }}"
                   class="group block bg-[#16161d] rounded-2xl overflow-hidden border border-white/5 hover:border-indigo-500/40 hover:shadow-lg hover:shadow-indigo-900/20 transition-all duration-300">
                    <div class="w-full h-72 bg-[#0f0f13] flex items-center justify-center overflow-hidden">
                        @if($film->poster)
                            <img src="{{ Storage::url($film->poster) }}"
                                 class="h-72 w-full object-contain transition-transform duration-500 ease-in-out group-hover:scale-105">
                        @else
                            <div class="text-4xl transition-transform duration-500 group-hover:scale-110">🎬</div>
                        @endif
                    </div>
                    <div class="p-3">
                        <h3 class="font-medium text-sm text-white truncate">{{ $film->judul }}</h3>
                        <p class="text-xs text-indigo-400/80 mt-1">{{ $film->genre }}</p>
                        <p class="text-xs text-gray-600 mt-1">{{ $film->durasi }} menit</p>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-16 text-gray-600 text-sm">Belum ada film tersedia.</div>
            @endif
        </section>

        <!-- Jadwal Hari Ini -->
        <section>
            <div class="flex items-center gap-3 mb-8">
                <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
                <h2 class="text-base font-semibold text-white tracking-tight">Jadwal Tayang Hari Ini</h2>
            </div>

            @if($schedules->count())
            <div class="rounded-2xl border border-white/5 overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-white/[0.03] text-gray-500 text-xs uppercase tracking-wider">
                            <th class="px-5 py-4 text-left font-medium">Film</th>
                            <th class="px-5 py-4 text-left font-medium">Studio</th>
                            <th class="px-5 py-4 text-left font-medium">Jam</th>
                            <th class="px-5 py-4 text-left font-medium">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $i => $schedule)
                        <tr class="{{ $i % 2 == 0 ? 'bg-white/[0.01]' : '' }} hover:bg-indigo-500/5 transition border-t border-white/5">
                            <td class="px-5 py-4 font-medium text-white">{{ $schedule->film->judul }}</td>
                            <td class="px-5 py-4 text-gray-500">{{ $schedule->studio }}</td>
                            <td class="px-5 py-4">
                                <span class="text-amber-400 font-semibold">{{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <span class="text-emerald-400 font-semibold">Rp {{ number_format($schedule->harga, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-16 text-gray-600 text-sm border border-white/5 rounded-2xl">
                Tidak ada jadwal tayang hari ini.
            </div>
            @endif
        </section>

    </div>

    <!-- Footer -->
    <footer class="border-t border-white/5 text-center py-6 text-xs text-gray-700">
        © {{ date('Y') }} BioskopKu — All rights reserved.
    </footer>

</body>
</html>