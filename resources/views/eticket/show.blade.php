<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('E-Ticket Anda') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-8 border-b pb-6">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-800 uppercase">BioskopKu Ticket</h2>
                            <p class="text-gray-500 mt-1">Order ID: {{ $order_id }}</p>
                        </div>
                        <div class="text-right">
                            <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">LUNAS</span>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row gap-8">
                        <div class="flex-1 space-y-4">
                            <div>
                                <p class="text-sm text-gray-500 uppercase tracking-wider">Film</p>
                                <p class="text-xl font-bold">{{ $schedule->film->judul }}</p>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 uppercase tracking-wider">Tanggal</p>
                                    <p class="font-semibold">{{ $schedule->tanggal }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 uppercase tracking-wider">Jam</p>
                                    <p class="font-semibold">{{ $schedule->jam_tayang }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 uppercase tracking-wider">Studio</p>
                                    <p class="font-semibold">{{ $schedule->studio }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 uppercase tracking-wider">Kursi</p>
                                    <p class="font-bold text-blue-600 text-lg">{{ $seatsString }}</p>
                                </div>
                            </div>
                            
                            <div class="pt-4 mt-4 border-t">
                                <p class="text-sm text-gray-500 uppercase tracking-wider">Atas Nama</p>
                                <p class="font-semibold">{{ $user->name }}</p>
                            </div>
                        </div>

                        <div class="flex flex-col items-center justify-center bg-gray-50 p-6 rounded-xl border border-gray-100">
                            <div class="mb-3">
                                {!! $qrCode !!}
                            </div>
                            <p class="text-xs text-center text-gray-500 max-w-[200px]">Tunjukkan QR Code ini kepada petugas studio saat akan masuk.</p>
                        </div>
                    </div>
                    
                    <div class="mt-8 pt-4 text-center">
                        <button onclick="window.print()" class="bg-gray-800 text-white px-6 py-2 rounded-md hover:bg-gray-700 transition">
                            Cetak / Simpan PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
