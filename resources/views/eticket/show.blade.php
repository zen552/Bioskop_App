<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket — BioskopKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        @media print {
            nav, footer, .no-print { display: none !important; }
            body { background: white !important; color: black !important; }
            .ticket-card { border: 1px solid #e5e7eb !important; background: white !important; }
            .print-dark { color: black !important; }
        }
    </style>
</head>
<body class="bg-[#0f0f13] text-white min-h-screen">

    <!-- Navbar -->
    <nav class="sticky top-0 z-50 bg-[#0f0f13]/80 backdrop-blur-md border-b border-white/5 px-6 py-4 no-print">
        <div class="max-w-3xl mx-auto flex justify-between items-center">
            <a href="{{ url('/') }}" class="text-lg font-semibold tracking-tight">
                <span class="text-indigo-400">Bioskop</span>Ku
            </a>
            <a href="{{ route('eticket.index') }}"
               class="text-xs font-medium bg-white/5 border border-white/10 px-4 py-2 rounded-full hover:bg-white/10 transition text-gray-300">
                ← Tiket Saya
            </a>
        </div>
    </nav>

    <div class="max-w-3xl mx-auto px-6 py-10">

        <!-- Header -->
        <div class="mb-6 no-print">
            <p class="text-xs font-medium tracking-widest text-indigo-400 uppercase mb-2">E-Ticket</p>
            <h1 class="text-2xl font-bold text-white">Detail Tiket</h1>
        </div>

        <!-- Ticket Card -->
        <div class="ticket-card bg-[#16161d] border border-white/5 rounded-2xl overflow-hidden">

            <!-- Top bar -->
            <div class="bg-indigo-600/20 border-b border-indigo-500/20 px-8 py-5 flex justify-between items-center">
                <div>
                    <p class="text-xs font-semibold tracking-widest text-indigo-300 uppercase">BioskopKu Ticket</p>
                    <p class="text-xs text-gray-500 mt-1 font-mono">{{ $order_id }}</p>
                </div>
                <span class="text-xs bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-full font-semibold">
                    LUNAS
                </span>
            </div>

            <div class="p-8 flex flex-col md:flex-row gap-8">

                <!-- Detail Info -->
                <div class="flex-1 space-y-5">
                    <div>
                        <p class="text-xs font-medium tracking-widest text-gray-500 uppercase mb-1">Film</p>
                        <p class="text-xl font-bold text-white print-dark">{{ $schedule->film->judul }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium tracking-widest text-gray-500 uppercase mb-1">Tanggal</p>
                            <p class="font-semibold text-white print-dark">
                                {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('d F Y') }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs font-medium tracking-widest text-gray-500 uppercase mb-1">Jam</p>
                            <p class="font-semibold text-amber-400">
                                {{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-medium tracking-widest text-gray-500 uppercase mb-1">Studio</p>
                            <p class="font-semibold text-white print-dark">{{ $schedule->studio }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium tracking-widest text-gray-500 uppercase mb-1">Kursi</p>
                            <p class="font-bold text-indigo-400 text-lg">{{ $seatsString }}</p>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-white/5">
                        <p class="text-xs font-medium tracking-widest text-gray-500 uppercase mb-1">Atas Nama</p>
                        <p class="font-semibold text-white print-dark">{{ $user->name }}</p>
                    </div>
                </div>

                <!-- QR Code -->
                <div class="flex flex-col items-center justify-center bg-white rounded-2xl p-6 flex-shrink-0">
                    <div class="mb-3">
                        {!! $qrCode !!}
                    </div>
                    <p class="text-xs text-center text-gray-400 max-w-[160px]">
                        Tunjukkan QR Code ini kepada petugas studio atau scan di mesin.
                    </p>
                </div>
            </div>

            <!-- Dashed divider -->
            <div class="mx-8 border-t border-dashed border-white/10"></div>

            <!-- Bottom -->
            <div class="px-8 py-4 flex justify-between items-center">
                <p class="text-xs text-gray-600">© {{ date('Y') }} BioskopKu</p>
                <button onclick="window.print()"
                        class="no-print text-xs font-semibold bg-white/5 border border-white/10 px-4 py-2 rounded-full hover:bg-white/10 transition text-gray-300">
                        Cetak / Simpan PDF
                </button>
            </div>
        </div>

    </div>

    <footer class="border-t border-white/5 text-center py-6 text-xs text-gray-700 no-print">
        © {{ date('Y') }} BioskopKu — All rights reserved.
    </footer>

</body>
</html>