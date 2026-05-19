<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $film->judul }} — BioskopKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#0f0f13] text-white min-h-screen">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-[#0f0f13]/80 backdrop-blur-md border-b border-white/5 px-6 py-4 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight text-white">🎬 <span class="text-indigo-400">Bioskop</span>Ku</a>
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

    <div class="max-w-4xl mx-auto px-6 py-10">

        <!-- Tombol Kembali -->
        <a href="{{ url('/') }}"
           class="inline-flex items-center gap-2 text-xs font-medium text-gray-400 bg-white/5 border border-white/10 px-4 py-2 rounded-full hover:bg-white/10 hover:text-white transition mb-8">
            ← Kembali ke Beranda
        </a>

        <!-- Info Film -->
        <div class="flex flex-col sm:flex-row gap-8 mb-12 bg-[#16161d] border border-white/5 rounded-2xl p-6">
            @if($film->poster)
                <img src="{{ Storage::url($film->poster) }}"
                     class="w-44 h-64 object-contain rounded-xl flex-shrink-0 bg-[#0f0f13]">
            @else
                <div class="w-44 h-64 bg-[#0f0f13] rounded-xl flex items-center justify-center text-5xl flex-shrink-0">
                    🎬
                </div>
            @endif

            <div class="flex flex-col justify-center">
                <p class="text-xs font-medium tracking-widest text-indigo-400 uppercase mb-2">Detail Film</p>
                <h1 class="text-2xl sm:text-3xl font-bold text-white mb-3 leading-snug">{{ $film->judul }}</h1>
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="text-xs bg-indigo-600/20 text-indigo-400 border border-indigo-500/30 px-3 py-1 rounded-full">
                        {{ $film->genre }}
                    </span>
                    <span class="text-xs bg-white/5 text-gray-400 border border-white/10 px-3 py-1 rounded-full">
                        ⏱ {{ $film->durasi }} menit
                    </span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">{{ $film->deskripsi }}</p>
            </div>
        </div>

        <!-- Jadwal Tayang -->
        <section>
            <div class="flex items-center gap-3 mb-6">
                <div class="w-1 h-5 bg-amber-500 rounded-full"></div>
                <h2 class="text-base font-semibold text-white tracking-tight">Jadwal Tayang</h2>
            </div>

            @if($schedules->count())
                @foreach($schedules->groupBy('tanggal') as $tanggal => $jadwals)
                <div class="mb-6">
                    <p class="text-xs font-medium text-amber-400/80 tracking-wide uppercase mb-3">
                        📆 {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($jadwals as $jadwal)
                        <a href="{{ route('booking.seats', $jadwal->id) }}" class="block bg-[#16161d] border border-white/5 hover:border-indigo-500/40 hover:shadow-md hover:shadow-indigo-900/10 rounded-2xl p-4 transition-all duration-200">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-2xl font-bold text-amber-400 tracking-tight">
                                        {{ \Carbon\Carbon::parse($jadwal->jam_tayang)->format('H:i') }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $jadwal->studio }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-emerald-400 font-semibold text-sm">
                                        Rp {{ number_format($jadwal->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endforeach
            @else
                <div class="text-center py-16 text-gray-600 text-sm border border-white/5 rounded-2xl">
                    Belum ada jadwal tayang untuk film ini.
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