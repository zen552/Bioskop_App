<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Pembayaran — BioskopKu</title>
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
                <span class="text-indigo-400">Bioskop</span>Ku
            </a>
            <a href="{{ route('payment.show', $order_id) }}"
               class="text-xs font-medium bg-white/5 border border-white/10 px-4 py-2 rounded-full hover:bg-white/10 transition text-gray-300">
                ← Kembali
            </a>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-10">

        <div class="mb-6">
            <p class="text-xs font-medium tracking-widest text-indigo-400 uppercase mb-2">Proses Pembayaran</p>
            <h1 class="text-2xl font-bold text-white">Pilih Metode Pembayaran</h1>
        </div>

        <div class="flex flex-col md:flex-row gap-6">

            <!-- Panel Kiri: Metode Pembayaran -->
            <div class="w-full md:w-2/3 bg-[#16161d] border border-white/5 rounded-2xl overflow-hidden">

                <div class="p-6 border-b border-white/5">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Metode</p>
                    <p class="font-semibold text-white">Pilih salah satu opsi pembayaran</p>
                </div>

                <!-- Opsi Bank -->
                <div class="border-b border-white/5">
                    <button disabled class="w-full text-left px-6 py-4 flex justify-between items-center opacity-35 cursor-not-allowed">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-8 bg-blue-900/40 border border-blue-500/20 rounded flex items-center justify-center font-bold text-blue-400 text-xs">BCA</div>
                            <span class="text-gray-200 text-sm">BCA Virtual Account</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <div class="border-b border-white/5">
                    <button disabled class="w-full text-left px-6 py-4 flex justify-between items-center opacity-35 cursor-not-allowed">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-8 bg-orange-900/40 border border-orange-500/20 rounded flex items-center justify-center font-bold text-orange-400 text-xs">BNI</div>
                            <span class="text-gray-200 text-sm">BNI Virtual Account</span>
                        </div>
                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <!-- Opsi QRIS (selected) -->
                <div class="border-b border-white/5">
                    <button class="w-full text-left px-6 py-4 flex justify-between items-center bg-indigo-900/20 focus:outline-none transition" id="qris-btn">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-8 bg-red-900/40 border border-red-500/20 rounded flex items-center justify-center font-bold text-red-400 text-xs">QRIS</div>
                            <span class="text-gray-200 text-sm">QRIS (GoPay, OVO, Dana, LinkAja)</span>
                        </div>
                        <svg class="w-4 h-4 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </div>

                <!-- QR Display -->
                <div class="p-6 text-center" id="qris-display">
                    <p class="text-xs text-gray-500 uppercase tracking-widest mb-4">Scan QR Code dengan aplikasi E-Wallet Anda</p>
                    <div class="inline-block p-5 bg-white rounded-2xl mb-4 shadow-lg shadow-indigo-900/20">
                        <svg class="w-44 h-44 mx-auto text-gray-900" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm13-2h3v2h-3v-2zm-3 0h2v2h-2v-2zm3 3h3v2h-3v-2zm-2 3h2v2h-2v-2zm-3-3h2v2h-2v-2zm3 3h-2v2h2v-2zm-5 0h2v2h-2v-2z"></path>
                        </svg>
                    </div>
                    <p class="font-mono text-sm font-semibold tracking-widest text-gray-400">NMID: 1234567890</p>
                </div>
            </div>

            <!-- Panel Kanan: Ringkasan & Aksi -->
            <div class="w-full md:w-1/3 flex flex-col gap-4">

                <!-- Order Summary -->
                <div class="bg-[#16161d] border border-white/5 rounded-2xl overflow-hidden">
                    <div class="p-6 border-b border-white/5">
                        <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Order ID</p>
                        <p class="font-mono text-sm text-gray-300">{{ $order_id }}</p>
                    </div>
                    <div class="p-6">
                        <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Total Pembayaran</p>
                        <p class="text-2xl font-bold text-emerald-400">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                    </div>
                </div>

                <!-- TOMBOL MOCK PAYMENT (tidak diubah, hanya restyled wrapper) -->
                <div class="bg-[#16161d] border border-amber-500/20 rounded-2xl p-5">
                    <p class="text-xs text-amber-400/80 mb-4 text-center leading-relaxed">
                        <strong class="text-amber-400">Mode Simulasi / Developer</strong><br>
                        Klik tombol di bawah untuk mensimulasikan pembayaran berhasil.
                    </p>
                    <form action="{{ route('payment.simulate', $order_id) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white font-semibold py-3 px-4 rounded-xl transition text-sm flex justify-center items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Bayar Sekarang (Mock)
                        </button>
                    </form>
                </div>

                <!-- Tombol Back -->
                <a href="{{ route('payment.show', $order_id) }}"
                   class="w-full text-center bg-white/5 hover:bg-white/10 border border-white/10 text-gray-300 font-medium py-3 rounded-xl transition text-sm">
                    ← Kembali ke Ringkasan
                </a>

            </div>
        </div>
    </div>

    <footer class="border-t border-white/5 text-center py-6 text-xs text-gray-700 mt-10">
        © {{ date('Y') }} BioskopKu — All rights reserved.
    </footer>

</body>
</html>