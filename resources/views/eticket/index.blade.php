<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiket Saya — BioskopKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#0f0f13] text-white min-h-screen">
    <nav class="sticky top-0 z-50 bg-[#0f0f13]/80 backdrop-blur-md border-b border-white/5 px-6 py-4">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight">
                <span class="text-indigo-400">Bioskop</span>Ku
            </a>
            <div class="flex gap-2">
                <a href="{{ url('/') }}"
                   class="text-xs font-medium bg-white/5 border border-white/10 px-4 py-2 rounded-full hover:bg-white/10 transition text-gray-300">
                    ← Beranda
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-xs font-medium bg-white/5 border border-white/10 px-4 py-2 rounded-full hover:bg-white/10 transition text-gray-300">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-10">
        <div class="mb-8">
            <p class="text-xs font-medium tracking-widest text-indigo-400 uppercase mb-2">Riwayat Pembelian</p>
            <h1 class="text-2xl font-bold text-white">Tiket Saya</h1>
        </div>
        @if($orders->isEmpty())
            <div class="bg-[#16161d] border border-white/5 rounded-2xl p-16 text-center">
                <div class="text-5xl mb-4">🎟️</div>
                <h4 class="text-base font-semibold text-white mb-2">Belum ada tiket</h4>
                <p class="text-sm text-gray-500 mb-6">Kamu belum pernah membeli tiket film apa pun.</p>
                <a href="{{ url('/') }}"
                   class="inline-block bg-indigo-600 text-white text-sm px-6 py-2 rounded-full hover:bg-indigo-500 transition">
                    Cari Film
                </a>
            </div>
        @else
            <div class="space-y-4">
                @foreach($orders as $orderId => $bookings)
                    @php
                        $firstBooking = $bookings->first();
                        $schedule = $firstBooking->schedule;
                        $film = $schedule->film;
                        $seats = $bookings->pluck('seat_number')->implode(', ');
                    @endphp

                    <div class="bg-[#16161d] border border-white/5 hover:border-indigo-500/30 rounded-2xl overflow-hidden flex flex-row transition-all duration-200 hover:shadow-lg hover:shadow-indigo-900/10">

                        <!-- Poster -->
                        <div class="w-24 sm:w-28 bg-[#0f0f13] flex items-center justify-center p-3 flex-shrink-0">
                            @if($film->poster)
                                <img src="{{ $film->poster_url }}"
                                     class="w-full h-auto object-contain rounded-lg shadow-md" alt="Poster">
                            @else
                                <span class="text-3xl">🎬</span>
                            @endif
                        </div>

                        <!-- Info -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="text-base font-bold text-white">{{ $film->judul }}</h4>
                                    <span class="text-xs bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-2 py-1 rounded-full font-semibold">
                                        Berhasil
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 mb-1">
                                    📅 {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('d F Y') }}
                                    &nbsp;·&nbsp;
                                    🕒 {{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    📍 {{ $schedule->studio }}
                                    &nbsp;·&nbsp;
                                    💺 <span class="font-semibold text-white">{{ $seats }}</span>
                                </p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-white/5 flex justify-between items-center">
                                <p class="text-xs text-gray-600 font-mono">{{ $orderId }}</p>
                                <a href="{{ route('eticket.show', $orderId) }}"
                                   class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition">
                                    Lihat E-Ticket →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <footer class="border-t border-white/5 text-center py-6 text-xs text-gray-700">
        © {{ date('Y') }} BioskopKu — All rights reserved.
    </footer>

</body>
</html>