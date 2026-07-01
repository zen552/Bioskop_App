<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
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
                <div class="flex flex-col items-center justify-center bg-white rounded-2xl p-6 flex-shrink-0 cursor-pointer hover:scale-105 transition-transform duration-300 shadow-xl shadow-white/5" onclick="openQrModal()" title="Klik untuk memperbesar">
                    <div class="mb-3">
                        {!! $qrCode !!}
                    </div>
                    <p class="text-xs text-center text-gray-400 max-w-[160px]">
                        Tunjukkan QR Code ini kepada petugas studio atau scan di mesin. (Klik untuk perbesar)
                    </p>
                </div>
            </div>

            <!-- Dashed divider -->
            <div class="mx-8 border-t border-dashed border-white/10"></div>

            <!-- Bottom -->
            <div class="px-8 py-4 flex justify-between items-center">
                <p class="text-xs text-gray-600">© {{ date('Y') }} BioskopKu</p>
                <a href="{{ route('eticket.download', $order_id) }}"
                   class="no-print inline-flex items-center gap-1.5 text-xs font-semibold bg-indigo-600 px-4 py-2 rounded-full hover:bg-indigo-500 transition text-white shadow-md shadow-indigo-900/30">
                    Unduh PDF
                </a>
            </div>
        </div>

    </div>

    <footer class="border-t border-white/5 text-center py-6 text-xs text-gray-700 no-print">
        © {{ date('Y') }} BioskopKu — All rights reserved.
    </footer>

    <!-- Modal QR Code -->
    <div id="qrModal" class="fixed inset-0 z-[100] bg-black/80 backdrop-blur-sm hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300 no-print" onclick="closeQrModal()">
        <div class="bg-white p-6 sm:p-8 rounded-3xl transform scale-95 transition-transform duration-300 shadow-2xl flex flex-col items-center mx-4" id="qrModalContent" onclick="event.stopPropagation()">
            <div class="mb-4 [&>svg]:w-64 [&>svg]:h-64 sm:[&>svg]:w-72 sm:[&>svg]:h-72">
                {!! $qrCode !!}
            </div>
            <p class="text-sm text-center text-gray-500 font-medium">Scan QR Code ini</p>
            <button onclick="closeQrModal()" class="mt-6 w-full px-8 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-xl text-sm font-semibold transition">Tutup</button>
        </div>
    </div>

    <script>
        const modal = document.getElementById('qrModal');
        const modalContent = document.getElementById('qrModalContent');

        function openQrModal() {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            // Trigger reflow
            void modal.offsetWidth;
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }

        function closeQrModal() {
            modal.classList.add('opacity-0');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
    </script>
</body>
</html>