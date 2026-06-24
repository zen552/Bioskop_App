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

        <div class="flex flex-col md:flex-row gap-6 justify-center">

            <!-- Main Content -->
            <div class="w-full max-w-md flex flex-col gap-6">

                <!-- Order Summary -->
                <div class="bg-[#16161d] border border-white/5 rounded-2xl overflow-hidden shadow-xl">
                    <div class="p-8 border-b border-white/5 bg-indigo-900/20 text-center">
                        <p class="text-xs text-indigo-300 uppercase tracking-widest mb-2 font-semibold">Total Tagihan</p>
                        <p class="text-4xl font-bold text-white">Rp {{ number_format($totalPrice, 0, ',', '.') }}</p>
                    </div>
                    <div class="p-6 border-b border-white/5 flex justify-between items-center">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-widest mb-1">Order ID</p>
                            <p class="font-mono text-sm text-gray-300">{{ $order_id }}</p>
                        </div>
                    </div>
                    <div class="p-6 bg-[#1a1a24]">
                        <button id="pay-button" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-4 px-4 rounded-xl transition text-base shadow-lg shadow-indigo-600/30 flex justify-center items-center gap-2">
                            Lanjutkan Pembayaran
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Tombol Back / Cancel -->
                <form action="{{ route('payment.cancel', $order_id) }}" method="POST">
                    @csrf
                    <button type="submit" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini? Kursi akan dilepas kembali.')"
                       class="w-full text-center text-red-400 hover:text-red-300 font-medium py-2 transition text-sm">
                        ← Batal dan Lepas Kursi
                    </button>
                </form>

            </div>

        </div>
    </div>

    <footer class="border-t border-white/5 text-center py-6 text-xs text-gray-700 mt-10">
        © {{ date('Y') }} BioskopKu — All rights reserved.
    </footer>

    <!-- Midtrans Snap JS -->
    <script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
      document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $snapToken }}', {
          onSuccess: function(result){
            // Submit form to simulate route which marks as success
            let form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("payment.simulate", $order_id) }}';
            let csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = '{{ csrf_token() }}';
            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
          },
          onPending: function(result){
            alert("Menunggu pembayaran Anda!");
          },
          onError: function(result){
            alert("Pembayaran gagal!");
          },
          onClose: function(){
            console.log('User closed the popup without finishing the payment');
          }
        });
      };
    </script>
</body>
</html>