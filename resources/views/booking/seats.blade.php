<!DOCTYPE html>
<html lang="id">
<head>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kursi — {{ $film->judul }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #0f0f13;
            color: #e8e6f0;
            min-height: 100vh;
        }

        /* ── Navbar (matched to detail.blade.php) ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 50;
            padding: 16px 24px;
            background: rgba(15, 15, 19, 0.80);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .navbar-inner {
            max-width: 896px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .brand {
            font-size: 18px;
            font-weight: 600;
            letter-spacing: -0.01em;
            color: #fff;
            text-decoration: none;
        }

        .brand span { color: #818cf8; } /* indigo-400 */



        /* ── Layout ── */
        .main {
            max-width: 896px;
            margin: 0 auto;
            padding: 32px 24px 64px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            font-weight: 500;
            color: #6b7280;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.10);
            padding: 7px 14px;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.18s ease;
            margin-bottom: 28px;
        }

        .back-link:hover { background: rgba(255, 255, 255, 0.09); color: #fff; }

        /* ── Film Card ── */
        .film-card {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            flex-wrap: wrap;
            background: #16161d;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 22px 26px;
            margin-bottom: 24px;
        }

        .film-label {
            font-size: 10px;
            letter-spacing: 0.35em;
            color: #818cf8; /* indigo-400 */
            text-transform: uppercase;
            font-weight: 500;
            margin-bottom: 6px;
        }

        .film-title {
            font-size: 24px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 5px;
            line-height: 1.25;
            letter-spacing: -0.01em;
        }

        .film-sub { font-size: 12px; color: #6b7280; }
        .film-sub .time { color: #fbbf24; font-weight: 600; } /* amber-400 */

        .studio-wrap { text-align: right; }
        .studio-label { font-size: 10px; color: #4b5563; margin-bottom: 5px; font-weight: 500; text-transform: uppercase; letter-spacing: 0.1em; }

        .studio-badge {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.10);
            border-radius: 9999px;
            padding: 7px 16px;
            font-size: 12px;
            font-weight: 500;
            color: #d1d5db;
        }

        /* ── Theater Area ── */
        .theater-area {
            background: #16161d;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
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
            background: linear-gradient(90deg, transparent, rgba(99,102,241,0.5), rgba(99,102,241,0.9), rgba(99,102,241,0.5), transparent);
            border-radius: 2px;
            margin: 0 auto 0;
            width: 78%;
            max-width: 360px;
        }

        .screen-glow {
            height: 44px;
            background: linear-gradient(to bottom, rgba(99, 102, 241, 0.08), transparent);
            margin: 0 auto;
            width: 78%;
            max-width: 360px;
            border-radius: 0 0 50% 50%;
        }

        .screen-text {
            font-size: 10px;
            letter-spacing: 0.25em;
            color: rgba(99, 102, 241, 0.55);
            text-transform: uppercase;
            font-weight: 600;
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
            color: #374151;
            font-weight: 600;
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
            border: 1px solid rgba(255, 255, 255, 0.07);
            background: rgba(255, 255, 255, 0.03);
            color: #4b5563;
            font-size: 9px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
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
            background: rgba(255, 255, 255, 0.04);
            border-radius: 1px;
        }

        .seat-btn:hover:not(:disabled) {
            background: rgba(99, 102, 241, 0.15);
            border-color: rgba(99, 102, 241, 0.40);
            color: #a5b4fc;
        }

        .seat-btn.selected {
            background: rgba(99, 102, 241, 0.80);
            border-color: rgba(129, 140, 248, 0.80);
            color: #fff;
        }

        .seat-btn.selected::after { background: rgba(255, 255, 255, 0.15); }

        .seat-btn:disabled {
            background: rgba(255, 255, 255, 0.02);
            border-color: rgba(255, 255, 255, 0.04);
            color: rgba(255, 255, 255, 0.07);
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
            font-weight: 500;
            color: #6b7280;
        }

        .leg-dot {
            width: 14px;
            height: 14px;
            border-radius: 3px 3px 1px 1px;
        }

        .leg-avail { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.07); }
        .leg-sel   { background: rgba(99,102,241,0.80); border: 1px solid rgba(129,140,248,0.80); }
        .leg-taken { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.04); opacity: 0.4; }

        /* ── Checkout Bar ── */
        .checkout {
            background: #16161d;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 20px 26px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .seats-label {
            font-size: 10px;
            font-weight: 500;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 6px;
        }

        .seats-text {
            font-size: 13px;
            font-weight: 500;
            color: #f3f4f6;
            min-height: 20px;
        }

        .seats-text.empty { color: #374151; }

        .checkout-right { display: flex; align-items: center; gap: 24px; }

        .price-label {
            font-size: 10px;
            font-weight: 500;
            color: #4b5563;
            text-align: right;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 3px;
        }

        .price-val {
            font-size: 24px;
            font-weight: 700;
            color: #34d399; /* emerald-400, matched to detail.blade.php price color */
            text-align: right;
            letter-spacing: -0.01em;
        }

        .confirm-btn {
            background: #4f46e5; /* indigo-600 */
            color: #fff;
            border: none;
            padding: 13px 26px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 500;
            font-family: 'Inter', sans-serif;
            letter-spacing: 0.01em;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .confirm-btn:disabled {
            opacity: 0.35;
            cursor: not-allowed;
        }

        .confirm-btn:not(:disabled):hover {
            background: #4338ca; /* indigo-700 */
            transform: translateY(-1px);
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

    {{-- Navbar (matched to detail.blade.php) --}}
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="{{ url('/') }}" class="brand">
                <span>Bioskop</span>Ku
            </a>
            <div style="display:flex; flex-wrap:wrap; align-items:center; gap:8px;">
                <a href="{{ route('profile.edit') }}"
                    class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-medium text-gray-300 transition hover:bg-white/10">
                    Profile
                </a>
                <a href="{{ route('eticket.index') }}"
                    class="rounded-full border border-indigo-500/30 bg-indigo-600/20 px-4 py-2 text-xs font-medium text-indigo-300 transition hover:bg-indigo-600/35">
                    Tiket Saya
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-medium text-gray-300 transition hover:bg-white/10">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <div class="main">

        {{-- Tombol Kembali --}}
        <a href="{{ url()->previous() }}" class="back-link">← Kembali ke Jadwal</a>

        {{-- Alert Error Validasi --}}
        @if($errors->any())
            <div style="background: rgba(239, 68, 68, 0.1); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-size: 13px;">
                <div style="display: flex; flex-direction: column; gap: 4px;">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
        @endif
        
        {{-- Alert Sukses --}}
        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.3); color: #6ee7b7; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-size: 13px;">
                {{ session('success') }}
            </div>
        @endif

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