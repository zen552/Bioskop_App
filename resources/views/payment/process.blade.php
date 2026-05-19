<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Proses Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <!-- Simulasi Panel Kiri: Metode Pembayaran -->
            <div class="w-full md:w-2/3 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">
                    <h3 class="text-lg font-bold">Pilih Metode Pembayaran</h3>
                </div>
                
                <div class="p-0">
                    <!-- Opsi Bank -->
                    <div class="border-b">
                        <button class="w-full text-left px-6 py-4 flex justify-between items-center hover:bg-gray-50 focus:bg-blue-50 focus:outline-none transition">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-8 bg-blue-100 rounded flex items-center justify-center font-bold text-blue-700 text-xs">BCA</div>
                                <span>BCA Virtual Account</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>
                    
                    <div class="border-b">
                        <button class="w-full text-left px-6 py-4 flex justify-between items-center hover:bg-gray-50 focus:bg-blue-50 focus:outline-none transition">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-8 bg-orange-100 rounded flex items-center justify-center font-bold text-orange-600 text-xs">BNI</div>
                                <span>BNI Virtual Account</span>
                            </div>
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </button>
                    </div>

                    <!-- Opsi E-Wallet -->
                    <div class="border-b">
                        <button class="w-full text-left px-6 py-4 flex justify-between items-center hover:bg-gray-50 focus:bg-blue-50 focus:outline-none transition bg-blue-50" id="qris-btn">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-8 bg-red-100 rounded flex items-center justify-center font-bold text-red-600 text-xs">QRIS</div>
                                <span>QRIS (GoPay, OVO, Dana, LinkAja)</span>
                            </div>
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </div>
                </div>
                
                <div class="p-6 bg-gray-50 text-center" id="qris-display">
                    <p class="text-sm text-gray-600 mb-4">Scan QR Code di bawah ini menggunakan aplikasi E-Wallet Anda.</p>
                    <div class="inline-block p-4 bg-white border-2 border-dashed border-gray-300 rounded-xl mb-4">
                        <!-- Mock QR Code Image using simple svg block for demonstration -->
                        <svg class="w-48 h-48 mx-auto" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 3h8v8H3V3zm2 2v4h4V5H5zm8-2h8v8h-8V3zm2 2v4h4V5h-4zM3 13h8v8H3v-8zm2 2v4h4v-4H5zm13-2h3v2h-3v-2zm-3 0h2v2h-2v-2zm3 3h3v2h-3v-2zm-2 3h2v2h-2v-2zm-3-3h2v2h-2v-2zm3 3h-2v2h2v-2zm-5 0h2v2h-2v-2z"></path>
                        </svg>
                    </div>
                    <p class="font-mono font-bold text-xl tracking-widest text-gray-800">NMID: 1234567890</p>
                </div>
            </div>

            <!-- Simulasi Panel Kanan: Ringkasan & Aksi -->
            <div class="w-full md:w-1/3">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6 text-gray-900">
                        <p class="text-sm text-gray-500">Order ID</p>
                        <p class="font-bold mb-4">{{ $order_id }}</p>
                        
                        <p class="text-sm text-gray-500">Total Pembayaran</p>
                        <p class="font-bold text-2xl text-blue-600 mb-6">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                        
                        <hr class="mb-6">

                        <!-- TOMBOL MOCK PAYMENT -->
                        <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg mb-6">
                            <p class="text-xs text-yellow-800 mb-3 text-center">
                                <strong>Mode Simulasi / Developer</strong><br>
                                Klik tombol di bawah untuk mensimulasikan pembayaran berhasil.
                            </p>
                            <form action="{{ route('payment.simulate', $order_id) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-green-600 text-white font-bold py-3 px-4 rounded-lg hover:bg-green-700 transition flex justify-center items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Bayar Sekarang (Mock)
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
