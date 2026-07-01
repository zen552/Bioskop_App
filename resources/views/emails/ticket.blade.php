<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Ticket BioskopKu</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            color: #111827;
            font-size: 14px;
            line-height: 1.6;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            overflow: hidden;
        }
        .header {
            background: #4f46e5;
            color: #ffffff;
            padding: 28px 32px;
            text-align: center;
        }
        .header h1 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .header p {
            font-size: 13px;
            opacity: 0.85;
        }
        .body {
            padding: 28px 32px;
        }
        .greeting {
            font-size: 15px;
            margin-bottom: 16px;
            color: #374151;
        }
        .info-box {
            background: #f3f4f6;
            border-radius: 10px;
            padding: 16px 20px;
            margin-bottom: 20px;
        }
        .info-box p {
            margin: 6px 0;
            font-size: 13px;
            color: #374151;
        }
        .info-box strong {
            color: #111827;
        }
        .attached-note {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 13px;
            color: #1e40af;
            margin-bottom: 20px;
        }
        .footer {
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            padding: 16px 32px;
            text-align: center;
            font-size: 11px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>BioskopKu 🎬</h1>
            <p>Konfirmasi Tiket Bioskop Anda</p>
        </div>
        <div class="body">
            <p class="greeting">
                Halo, <strong>{{ $user->name }}</strong>! 👋
            </p>
            <p style="margin-bottom: 16px; color: #374151; font-size: 13px;">
                Pembayaran Anda telah berhasil dikonfirmasi. Berikut adalah detail tiket Anda:
            </p>
            <div class="info-box">
                <p>🎬 <strong>Film:</strong> {{ $schedule->film->judul }}</p>
                <p>📅 <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('d F Y') }}</p>
                <p>🕐 <strong>Jam Tayang:</strong> {{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }} WIB</p>
                <p>🏠 <strong>Studio:</strong> {{ $schedule->studio }}</p>
                <p>💺 <strong>Kursi:</strong> {{ $seatsString }}</p>
                <p>🔖 <strong>Order ID:</strong> {{ $order_id }}</p>
            </div>
            <div class="attached-note">
                📎 E-Ticket Anda (format PDF) telah dilampirkan pada email ini. Silakan unduh dan tunjukkan kepada petugas bioskop saat masuk.
            </div>
            <p style="font-size: 13px; color: #6b7280;">
                Jika Anda memiliki pertanyaan, silakan hubungi kami. Selamat menikmati film! 🍿
            </p>
        </div>
        <div class="footer">
            © {{ date('Y') }} BioskopKu — All rights reserved. Email ini dikirim otomatis, mohon tidak membalas.
        </div>
    </div>
</body>
</html>
