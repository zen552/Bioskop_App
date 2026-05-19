<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ringkasan Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Detail Pesanan ({{ $order_id }})</h3>
                    
                    <div class="mb-4">
                        <p><strong>Film:</strong> {{ $schedule->film->judul }}</p>
                        <p><strong>Jadwal:</strong> {{ $schedule->tanggal }} - {{ $schedule->jam_tayang }}</p>
                        <p><strong>Studio:</strong> {{ $schedule->studio }}</p>
                    </div>

                    <div class="mb-4">
                        <h4 class="font-semibold mb-2">Kursi yang dipesan:</h4>
                        <ul class="list-disc pl-5">
                            @foreach($bookings as $booking)
                                <li>Kursi {{ $booking->seat_number }} (Rp {{ number_format($schedule->harga, 0, ',', '.') }})</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="mt-6 border-t pt-4">
                        <h4 class="text-xl font-bold">Total Pembayaran: Rp {{ number_format($totalPrice, 0, ',', '.') }}</h4>
                    </div>

                    <div class="mt-6">
                        <form action="{{ route('payment.process', $order_id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                                Lanjutkan ke Pembayaran
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
