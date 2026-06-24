<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — BioskopKu</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background-color: #0a0a0f;
            color: #e2e8f0;
            -webkit-font-smoothing: antialiased;
        }

        .email-wrapper {
            width: 100%;
            background-color: #0a0a0f;
            padding: 48px 16px;
        }

        .email-container {
            max-width: 560px;
            margin: 0 auto;
        }

        /* Header / Logo */
        .header {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo {
            display: inline-block;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: -0.5px;
            text-decoration: none;
            color: #ffffff;
        }

        .logo span {
            color: #818cf8;
        }

        /* Card */
        .card {
            background: linear-gradient(145deg, #13131a 0%, #16161f 100%);
            border: 1px solid rgba(255,255,255,0.07);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(0,0,0,0.5);
        }

        /* Card Header Banner */
        .card-banner {
            background: linear-gradient(135deg, #312e81 0%, #1e1b4b 50%, #0f0e1a 100%);
            padding: 40px 40px 36px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .card-banner::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(99,102,241,0.3) 0%, transparent 70%);
            top: -60px;
            left: -60px;
            border-radius: 50%;
        }

        .card-banner::after {
            content: '';
            position: absolute;
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(139,92,246,0.2) 0%, transparent 70%);
            bottom: -40px;
            right: -20px;
            border-radius: 50%;
        }

        .banner-icon {
            font-size: 42px;
            display: block;
            margin-bottom: 16px;
            position: relative;
            z-index: 1;
            line-height: 1;
        }

        .banner-title {
            font-size: 22px;
            font-weight: 700;
            color: #ffffff;
            position: relative;
            z-index: 1;
            margin-bottom: 8px;
        }

        .banner-subtitle {
            font-size: 13px;
            color: rgba(165, 180, 252, 0.8);
            position: relative;
            z-index: 1;
        }

        /* Card Body */
        .card-body {
            padding: 36px 40px;
        }

        .greeting {
            font-size: 15px;
            font-weight: 600;
            color: #f1f5f9;
            margin-bottom: 12px;
        }

        .message {
            font-size: 14px;
            line-height: 1.7;
            color: #94a3b8;
            margin-bottom: 32px;
        }

        /* CTA Button */
        .btn-wrapper {
            text-align: center;
            margin-bottom: 32px;
        }

        .btn-reset {
            display: inline-block;
            background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
            color: #ffffff !important;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            padding: 14px 40px;
            border-radius: 12px;
            letter-spacing: 0.2px;
            box-shadow: 0 8px 24px rgba(99, 102, 241, 0.35);
        }

        /* Divider */
        .divider {
            border: none;
            border-top: 1px solid rgba(255,255,255,0.06);
            margin: 28px 0;
        }

        /* Warning */
        .warning-box {
            background: rgba(234, 179, 8, 0.06);
            border: 1px solid rgba(234, 179, 8, 0.15);
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 24px;
        }

        .warning-box p {
            font-size: 13px;
            color: #a16207;
            color: #fbbf24;
            line-height: 1.6;
        }

        .warning-box strong {
            color: #fde68a;
        }

        /* URL Fallback */
        .url-fallback {
            margin-bottom: 8px;
        }

        .url-fallback p {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 8px;
            line-height: 1.6;
        }

        .url-box {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(255,255,255,0.06);
            border-radius: 8px;
            padding: 12px 14px;
            word-break: break-all;
            font-size: 11px;
            color: #6366f1;
            font-family: 'Courier New', Courier, monospace;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 32px;
            padding: 0 16px;
        }

        .footer p {
            font-size: 12px;
            color: #334155;
            line-height: 1.7;
        }

        .footer a {
            color: #475569;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="email-container">

            <!-- Logo -->
            <div class="header">
                <span class="logo"><span>Bioskop</span>Ku</span>
            </div>

            <!-- Card -->
            <div class="card">

                <!-- Banner -->
                <div class="card-banner">
                    <div class="banner-icon">🔐</div>
                    <div class="banner-title">Reset Password Anda</div>
                    <div class="banner-subtitle">Permintaan reset password telah diterima</div>
                </div>

                <!-- Body -->
                <div class="card-body">
                    <p class="greeting">Halo, {{ $user->name }}!</p>
                    <p class="message">
                        Kami menerima permintaan untuk mereset password akun BioskopKu Anda yang terdaftar dengan email <strong style="color: #c7d2fe;">{{ $user->email }}</strong>.<br><br>
                        Klik tombol di bawah ini untuk membuat password baru. Tautan ini hanya berlaku selama <strong style="color: #f1f5f9;">60 menit</strong>.
                    </p>

                    <!-- Button -->
                    <div class="btn-wrapper">
                        <a href="{{ $url }}" class="btn-reset">
                            🔑 &nbsp; Reset Password Sekarang
                        </a>
                    </div>

                    <hr class="divider">

                    <!-- Warning -->
                    <div class="warning-box">
                        <p>⚠️ <strong>Bukan Anda yang meminta ini?</strong> Abaikan saja email ini. Password Anda tidak akan berubah dan akun Anda tetap aman.</p>
                    </div>

                    <!-- URL Fallback -->
                    <div class="url-fallback">
                        <p>Jika tombol di atas tidak dapat diklik, salin dan tempel tautan berikut ke browser Anda:</p>
                        <div class="url-box">{{ $url }}</div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <p>
                    © {{ date('Y') }} BioskopKu — All rights reserved.<br>
                    Email ini dikirimkan secara otomatis, mohon tidak membalas email ini.
                </p>
            </div>

        </div>
    </div>
</body>
</html>
