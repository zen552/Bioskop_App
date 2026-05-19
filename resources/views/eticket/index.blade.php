<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tiket Saya') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-6">Riwayat Pembelian Tiket</h3>

            @if($orders->isEmpty())
                <div class="bg-white p-8 rounded-lg shadow-sm text-center border">
                    <div class="text-5xl mb-4">🎟️</div>
                    <h4 class="text-lg font-bold text-gray-700">Belum ada tiket</h4>
                    <p class="text-gray-500 mt-2 mb-6">Kamu belum pernah membeli tiket film apa pun.</p>
                    <a href="{{ url('/') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">Cari Film</a>
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
                        
                        <div class="bg-white overflow-hidden shadow-sm rounded-lg border border-gray-100 flex flex-col sm:flex-row hover:shadow-md transition">
                            <div class="bg-gray-800 w-full sm:w-32 flex items-center justify-center p-4">
                                @if($film->poster)
                                    <img src="{{ $film->poster_url }}" class="h-24 object-cover rounded shadow-sm" alt="Poster">
                                @else
                                    <span class="text-3xl">🎬</span>
                                @endif
                            </div>
                            
                            <div class="p-6 flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="text-xl font-bold text-gray-900">{{ $film->judul }}</h4>
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded font-bold uppercase">Berhasil</span>
                                    </div>
                                    <p class="text-sm text-gray-500 mb-1">
                                        🗓️ {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('d F Y') }} | 🕒 {{ $schedule->jam_tayang }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        📍 {{ $schedule->studio }} — 💺 Kursi: <span class="font-semibold text-gray-800">{{ $seats }}</span>
                                    </p>
                                </div>
                                <div class="mt-4 pt-4 border-t flex justify-between items-center">
                                    <p class="text-xs text-gray-400 font-mono">Order ID: {{ $orderId }}</p>
                                    <a href="{{ route('eticket.show', $orderId) }}" class="text-sm text-indigo-600 font-semibold hover:text-indigo-800 transition">
                                        Lihat E-Ticket &rarr;
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
