<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>E-Ticket BioskopKu</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            background: #ffffff;
            color: #1a1a2e;
        }
        .page {
            width: 100%;
            padding: 20px;
        }
        .ticket-card {
            width: 100%;
            margin: 0 auto;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            background: #ffffff;
        }
        .ticket-header {
            background: #eef2ff;
            border-bottom: 1px solid #c7d2fe;
            padding: 24px 32px;
        }
        .ticket-header-left {
            display: inline-block;
            width: 70%;
            vertical-align: middle;
        }
        .ticket-header-right {
            display: inline-block;
            width: 28%;
            text-align: right;
            vertical-align: middle;
        }
        .ticket-brand {
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #4338ca;
            margin-bottom: 4px;
        }
        .ticket-order-id {
            font-size: 11px;
            color: #9ca3af;
            font-family: monospace;
        }
        .status-badge {
            display: inline-block;
            background: #f0fdf4;
            border: 1px solid #86efac;
            color: #16a34a;
            font-size: 11px;
            font-weight: bold;
            padding: 6px 14px;
            border-radius: 999px;
            letter-spacing: 0.05em;
        }
        .ticket-body {
            padding: 32px 32px;
        }
        .info-top {
            width: 100%;
            margin-bottom: 30px;
        }
        .qr-bottom {
            width: 100%;
            text-align: center;
        }
        .field-label {
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 0.15em;
            text-transform: uppercase;
            color: #9ca3af;
            margin-bottom: 4px;
        }
        .field-value {
            font-size: 18px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 20px;
        }
        .field-value-lg {
            font-size: 24px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 20px;
        }
        .field-value-amber {
            font-size: 20px;
            font-weight: bold;
            color: #d97706;
            margin-bottom: 20px;
        }
        .field-value-indigo {
            font-size: 20px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 20px;
        }
        .grid-col {
            display: inline-block;
            width: 48%;
            vertical-align: top;
        }
        .divider {
            border-top: 1px dashed #e5e7eb;
            margin: 14px 0;
        }
        .qr-box {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 24px;
            text-align: center;
            display: inline-block;
            margin: 0 auto;
        }
        .qr-caption {
            font-size: 10px;
            color: #6b7280;
            margin-top: 12px;
            line-height: 1.5;
        }
        .ticket-footer {
            border-top: 1px dashed #e5e7eb;
            padding: 16px 32px;
        }
        .footer-text {
            font-size: 11px;
            color: #9ca3af;
        }
    </style>
</head>
<body>
<div class="page">
    <div class="ticket-card">

        <div class="ticket-header">
            <div class="ticket-header-left">
                <div class="ticket-brand">BioskopKu Ticket</div>
                <div class="ticket-order-id">{{ $order_id }}</div>
            </div>
            <div class="ticket-header-right">
                <span class="status-badge">LUNAS</span>
            </div>
        </div>

        <div class="ticket-body">
            <div class="info-top">

                <div class="field-label">Film</div>
                <div class="field-value-lg">{{ $schedule->film->judul }}</div>

                <div class="grid-row">
                    <div class="grid-col">
                        <div class="field-label">Tanggal</div>
                        <div class="field-value">{{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('d F Y') }}</div>
                    </div>
                    <div class="grid-col">
                        <div class="field-label">Jam</div>
                        <div class="field-value-amber">{{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}</div>
                    </div>
                </div>

                <div class="grid-row">
                    <div class="grid-col">
                        <div class="field-label">Studio</div>
                        <div class="field-value">{{ $schedule->studio }}</div>
                    </div>
                    <div class="grid-col">
                        <div class="field-label">Kursi</div>
                        <div class="field-value-indigo">{{ $seatsString }}</div>
                    </div>
                </div>

                <div class="divider"></div>

                <div class="field-label">Atas Nama</div>
                <div class="field-value">{{ strtoupper($user->name) }}</div>

            </div>
            
            <div class="qr-bottom">
                <div class="qr-box">
                    <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code" width="300" height="300">
                    <div class="qr-caption">Tunjukkan QR Code ini kepada petugas studio atau scan di mesin.</div>
                </div>
            </div>
        </div>

        <div class="ticket-footer">
            <span class="footer-text">© {{ date('Y') }} BioskopKu — All rights reserved.</span>
        </div>

    </div>
</div>
</body>
</html>
