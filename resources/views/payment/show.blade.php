<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ringkasan Pembayaran — BioskopKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#0f0f13] text-white min-h-screen">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-[#0f0f13]/80 backdrop-blur-md border-b border-white/5 px-6 py-4">
        <div class="max-w-4xl mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight">
                🎬 <span class="text-indigo-400">Bioskop</span>Ku
            </a>
            <a href="{{ url('/') }}"
               class="text-xs font-medium bg-white/5 border border-white/10 px-4 py-2 rounded-full hover:bg-white/10 transition text-gray-300">
                ← Beranda
            </a>
        </div>
    </nav>

    <div class="max-w-2xl mx-auto px-6 py-10">

        <div class="mb-6">
            <p class="text-xs font-medium tracking-widest text-indigo-400 uppercase mb-2">Ringkasan Pesanan</p>
            <h1 class="text-2xl font-bold text-white">Detail Pembayaran</h1>
        </div>

        <div class="bg-[#16161d] border border-white/5 rounded-2xl overflow-hidden mb-4">

            <!-- Film Info -->
            <div class="p-6 border-b border-white/5">
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Film</p>
                <p class="text-xl font-bold text-white">{{ $schedule->film->judul }}</p>
            </div>

            <!-- Schedule Info -->
            <div class="grid grid-cols-3 divide-x divide-white/5 border-b border-white/5">
                <div class="p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Tanggal</p>
                    <p class="font-semibold text-white text-sm">
                        {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('d F Y') }}
                    </p>
                </div>
                <div class="p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Jam</p>
                    <p class="font-semibold text-amber-400 text-sm">
                        {{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}
                    </p>
                </div>
                <div class="p-5">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Studio</p>
                    <p class="font-semibold text-white text-sm">{{ $schedule->studio }}</p>
                </div>
            </div>

            <!-- Seats -->
            <div class="p-6 border-b border-white/5">
                <p class="text-xs text-gray-500 uppercase tracking-widest mb-3">Kursi Dipesan</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($bookings as $booking)
                    <span class="bg-indigo-600/20 text-indigo-300 border border-indigo-500/30 text-xs font-semibold px-3 py-1 rounded-full">
                        {{ $booking->seat_number }}
                    </span>
                    @endforeach
                </div>
            </div>

            <!-- Total -->
            <div class="p-6 flex justify-between items-center">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Total Pembayaran</p>
                    <p class="text-2xl font-bold text-emerald-400">
                        Rp {{ number_format($totalPrice, 0, ',', '.') }}
                    </p>
                </div>
                <p class="text-xs text-gray-600 font-mono">{{ $order_id }}</p>
            </div>
        </div>

        <!-- CTA -->
        <form action="{{ route('payment.process', $order_id) }}" method="POST">
            @csrf
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-3 rounded-xl transition text-sm">
                Lanjutkan ke Pembayaran →
            </button>
        </form>

    </div>

    <footer class="border-t border-white/5 text-center py-6 text-xs text-gray-700">
        © {{ date('Y') }} BioskopKu — All rights reserved.
    </footer>

</body>
</html>