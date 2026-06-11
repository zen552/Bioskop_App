<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Tiket Bioskop</title>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-900 text-white flex items-center justify-center min-h-screen">

    <div class="bg-slate-800 p-8 rounded-2xl shadow-lg max-w-md w-full text-center border border-slate-700">
        <h2 class="text-2xl font-bold mb-2 text-red-500">Konfirmasi Pembayaran</h2>
        <p class="text-slate-400 mb-6">Silakan selesaikan pembayaran tiket bioskop Anda</p>
        
        <div class="bg-slate-700 p-4 rounded-xl text-left mb-6 space-y-2">
            <p><span class="text-slate-400">Order ID:</span> <span class="font-mono">{{ $params['transaction_details']['order_id'] }}</span></p>
            <p><span class="text-slate-400">Total Bayar:</span> <span class="text-green-400 font-bold">Rp {{ number_format($params['transaction_details']['gross_amount'], 0, ',', '.') }}</span></p>
        </div>

        <button id="pay-button" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-xl transition duration-200 shadow-md">
            Bayar Sekarang
        </button>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    alert("Pembayaran sukses! Tiket berhasil dipesan.");
                    window.location.href = '/home';
                },
                onPending: function(result){
                    alert("Menunggu pembayaran Anda.");
                },
                onError: function(result){
                    alert("Pembayaran gagal, silakan coba lagi.");
                },
                onClose: function(){
                    alert('Anda menutup halaman pembayaran sebelum selesai.');
                }
            });
        });
    </script>
</body>
</html>