<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kursi — {{ $film->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: #0d0c10;
            color: #e8e6f0;
            min-height: 100vh;
        }

        /* ── Navbar ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 28px;
            background: rgba(13, 12, 16, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .brand {
            font-family: 'DM Serif Display', serif;
            font-size: 18px;
            letter-spacing: 0.02em;
            color: #c9b8ff;
            text-decoration: none;
        }

        .user-chip {
            font-size: 11px;
            color: #8a849a;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 5px 14px;
            border-radius: 20px;
        }

        .user-chip span { color: #e8e6f0; font-weight: 500; }

        /* ── Layout ── */
        .main {
            max-width: 860px;
            margin: 0 auto;
            padding: 32px 24px 64px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 500;
            color: #7a748a;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            padding: 7px 14px;
            border-radius: 20px;
            text-decoration: none;
            transition: all 0.18s ease;
            margin-bottom: 28px;
        }

        .back-link:hover { background: rgba(255, 255, 255, 0.08); color: #e8e6f0; }

        /* ── Film Card ── */
        .film-card {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
            background: linear-gradient(135deg, rgba(138, 103, 211, 0.12), rgba(96, 70, 168, 0.05));
            border: 1px solid rgba(138, 103, 211, 0.2);
            border-radius: 14px;
            padding: 22px 26px;
            margin-bottom: 24px;
        }

        .film-label {
            font-size: 10px;
            letter-spacing: 0.15em;
            color: #9b7de8;
            text-transform: uppercase;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .film-title {
            font-family: 'DM Serif Display', serif;
            font-size: 24px;
            color: #f0eeff;
            margin-bottom: 5px;
            line-height: 1.2;
        }

        .film-sub { font-size: 12px; color: #7a748a; }
        .film-sub .time { color: #f5c76b; font-weight: 500; }

        .studio-wrap { text-align: right; }
        .studio-label { font-size: 10px; color: #5a5568; margin-bottom: 5px; }

        .studio-badge {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 7px 16px;
            font-size: 12px;
            color: #b0aac0;
        }

        /* ── Theater Area ── */
        .theater-area {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 14px;
            padding: 32px 24px;
            margin-bottom: 20px;
        }

        .screen-wrap {
            text-align: center;
            margin-bottom: 36px;
            position: relative;
        }

        .screen-bar {
            height: 3px;
            background: linear-gradient(90deg, transparent, rgba(138,103,211,0.55), rgba(138,103,211,0.9), rgba(138,103,211,0.55), transparent);
            border-radius: 2px;
            margin: 0 auto 0;
            width: 78%;
            max-width: 360px;
        }

        .screen-glow {
            height: 44px;
            background: linear-gradient(to bottom, rgba(138, 103, 211, 0.08), transparent);
            margin: 0 auto;
            width: 78%;
            max-width: 360px;
            border-radius: 0 0 50% 50%;
        }

        .screen-text {
            font-size: 10px;
            letter-spacing: 0.25em;
            color: rgba(138, 103, 211, 0.5);
            text-transform: uppercase;
            font-weight: 500;
            position: absolute;
            top: 14px;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
        }

        /* ── Seat Grid ── */
        .seat-map { display: flex; flex-direction: column; gap: 6px; align-items: center; }

        .row-wrap {
            display: flex;
            align-items: center;
            gap: 8px;
            width: 100%;
            max-width: 520px;
        }

        .row-label {
            width: 16px;
            font-size: 10px;
            color: #4a4558;
            font-weight: 500;
            text-align: center;
            flex-shrink: 0;
        }

        .seat-row {
            display: grid;
            grid-template-columns: repeat(5, minmax(0, 1fr)) 28px repeat(5, minmax(0, 1fr));
            gap: 6px;
            flex: 1;
        }

        .aisle { /* empty spacer */ }

        .seat-btn {
            width: 100%;
            height: 30px;
            border-radius: 6px 6px 3px 3px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: rgba(255, 255, 255, 0.04);
            color: #6b6480;
            font-size: 9px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.18s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .seat-btn::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 5px;
            right: 5px;
            height: 2px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 1px;
        }

        .seat-btn:hover:not(:disabled) {
            background: rgba(138, 103, 211, 0.15);
            border-color: rgba(138, 103, 211, 0.35);
            color: #c9b8ff;
        }

        .seat-btn.selected {
            background: rgba(138, 103, 211, 0.85);
            border-color: rgba(160, 130, 230, 0.8);
            color: #fff;
        }

        .seat-btn.selected::after { background: rgba(255, 255, 255, 0.18); }

        .seat-btn:disabled {
            background: rgba(255, 255, 255, 0.02);
            border-color: rgba(255, 255, 255, 0.04);
            color: rgba(255, 255, 255, 0.08);
            cursor: not-allowed;
        }

        /* ── Legend ── */
        .legend {
            display: flex;
            gap: 24px;
            justify-content: center;
            padding-top: 22px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            margin-top: 16px;
            flex-wrap: wrap;
        }

        .leg-item {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            color: #7a748a;
        }

        .leg-dot {
            width: 14px;
            height: 14px;
            border-radius: 3px 3px 1px 1px;
        }

        .leg-avail { background: rgba(255,255,255,0.04); border: 1px solid rgba(255,255,255,0.08); }
        .leg-sel   { background: rgba(138,103,211,0.85); border: 1px solid rgba(160,130,230,0.8); }
        .leg-taken { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); opacity: 0.4; }

        /* ── Checkout Bar ── */
        .checkout {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.07);
            border-radius: 14px;
            padding: 20px 26px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .seats-label {
            font-size: 10px;
            color: #5a5568;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 6px;
        }

        .seats-text {
            font-size: 13px;
            font-weight: 500;
            color: #e8e6f0;
            min-height: 20px;
        }

        .seats-text.empty { color: #4a4558; }

        .checkout-right { display: flex; align-items: center; gap: 24px; }

        .price-label {
            font-size: 10px;
            color: #5a5568;
            text-align: right;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 3px;
        }

        .price-val {
            font-family: 'DM Serif Display', serif;
            font-size: 26px;
            color: #7fcda0;
            text-align: right;
        }

        .confirm-btn {
            background: linear-gradient(135deg, #7c55d4, #9b7de8);
            color: #fff;
            border: none;
            padding: 13px 26px;
            border-radius: 24px;
            font-size: 12px;
            font-weight: 500;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.02em;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            box-shadow: 0 6px 20px rgba(124, 85, 212, 0.3);
        }

        .confirm-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
            box-shadow: none;
        }

        .confirm-btn:not(:disabled):hover {
            transform: translateY(-1px);
            box-shadow: 0 10px 28px rgba(124, 85, 212, 0.45);
        }

        @media (max-width: 600px) {
            .checkout { flex-direction: column; align-items: flex-start; }
            .checkout-right { width: 100%; justify-content: space-between; }
            .film-card { flex-direction: column; }
            .studio-wrap { text-align: left; }
        }
    </style>
</head>
<body>

    {{-- Navbar --}}
    <nav class="navbar">
        <a href="{{ url('/') }}" class="brand">🎬 BioskopKu</a>
        <div class="user-chip">
            Masuk sebagai: <span>{{ Auth::user()->name ?? 'Tamu' }}</span>
        </div>
    </nav>

    <div class="main">

        {{-- Tombol Kembali --}}
        <a href="{{ url()->previous() }}" class="back-link">← Kembali ke Jadwal</a>

        {{-- Ringkasan Film & Jadwal --}}
        <div class="film-card">
            <div>
                <div class="film-label">Anda memesan kursi untuk</div>
                <div class="film-title">{{ $film->judul }}</div>
                <div class="film-sub">
                    {{ \Carbon\Carbon::parse($schedule->tanggal)->translatedFormat('l, d F Y') }} —
                    <span class="time">{{ \Carbon\Carbon::parse($schedule->jam_tayang)->format('H:i') }}</span>
                </div>
            </div>
            <div class="studio-wrap">
                <div class="studio-label">Studio</div>
                <div class="studio-badge">{{ $schedule->studio }}</div>
            </div>
        </div>

        {{-- Denah Bioskop --}}
        <div class="theater-area">

            {{-- Layar Virtual --}}
            <div class="screen-wrap">
                <div class="screen-bar"></div>
                <div class="screen-glow"></div>
                <div class="screen-text">Layar Bioskop</div>
            </div>

            {{-- Grid Kursi --}}
            <div class="seat-map">
                @foreach(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'] as $row)
                    <div class="row-wrap">
                        <div class="row-label">{{ $row }}</div>
                        <div class="seat-row">
                            @for($col = 1; $col <= 11; $col++)
                                @if($col == 6)
                                    {{-- Lorong Tengah --}}
                                    <div class="aisle"></div>
                                @else
                                    @php
                                        $seatNumber = $col > 6 ? $col - 1 : $col;
                                        $seatId     = $row . $seatNumber;
                                        $isSold     = in_array($seatId, $reservedSeats ?? []);
                                    @endphp

                                    @if($isSold)
                                        <button class="seat-btn" disabled title="Kursi {{ $seatId }} sudah terisi">
                                            {{ $seatId }}
                                        </button>
                                    @else
                                        <button
                                            type="button"
                                            class="seat-btn"
                                            data-seat="{{ $seatId }}"
                                            title="Pilih kursi {{ $seatId }}">
                                            {{ $seatId }}
                                        </button>
                                    @endif
                                @endif
                            @endfor
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Keterangan --}}
            <div class="legend">
                <div class="leg-item"><div class="leg-dot leg-avail"></div>Tersedia</div>
                <div class="leg-item"><div class="leg-dot leg-sel"></div>Dipilih</div>
                <div class="leg-item"><div class="leg-dot leg-taken"></div>Terisi</div>
            </div>
        </div>

        {{-- Checkout Bar --}}
        <div class="checkout">
            <div>
                <div class="seats-label">Kursi dipilih</div>
                <div class="seats-text empty" id="seats-display">Belum ada kursi terpilih</div>
            </div>
            <div class="checkout-right">
                <div>
                    <div class="price-label">Total Harga</div>
                    <div class="price-val" id="price-display" data-price="{{ $schedule->harga }}">Rp 0</div>
                </div>

                <form action="{{ route('booking.confirm', $schedule->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="selected_seats" id="seats-input">
                    <button type="submit" class="confirm-btn" id="confirm-btn" disabled>
                        Konfirmasi Pemesanan →
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const seatBtns    = document.querySelectorAll('.seat-btn[data-seat]');
            const seatsDisplay = document.getElementById('seats-display');
            const priceDisplay = document.getElementById('price-display');
            const seatsInput   = document.getElementById('seats-input');
            const confirmBtn   = document.getElementById('confirm-btn');

            const TICKET_PRICE = parseInt(priceDisplay.dataset.price) || 0;
            let selected = [];

            function formatRupiah(amount) {
                return 'Rp ' + amount.toLocaleString('id-ID');
            }

            function updateUI() {
                if (selected.length > 0) {
                    seatsDisplay.textContent = selected.join(', ');
                    seatsDisplay.classList.remove('empty');
                    priceDisplay.textContent = formatRupiah(selected.length * TICKET_PRICE);
                    seatsInput.value = selected.join(',');
                    confirmBtn.disabled = false;
                } else {
                    seatsDisplay.textContent = 'Belum ada kursi terpilih';
                    seatsDisplay.classList.add('empty');
                    priceDisplay.textContent = 'Rp 0';
                    seatsInput.value = '';
                    confirmBtn.disabled = true;
                }
            }

            seatBtns.forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.seat;
                    const idx = selected.indexOf(id);

                    if (idx > -1) {
                        selected.splice(idx, 1);
                        btn.classList.remove('selected');
                    } else {
                        selected.push(id);
                        btn.classList.add('selected');
                    }

                    selected.sort();
                    updateUI();
                });
            });
        });
    </script>
</body>
</html>