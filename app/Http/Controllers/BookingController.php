<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Booking; 
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Menampilkan halaman pilih kursi berdasarkan jadwal yang dipilih
     */
    public function selectSeats(Schedule $schedule)
    {
        // Otomatis mendapatkan data film lewat relasi di model Schedule
        $film = $schedule->film;

        // Ambil daftar nomor kursi yang sudah terisi/terjual pada jadwal ini
        // pluck() akan langsung mengambil data dalam bentuk array linear, misal: ['A1', 'A2', 'B5']
        $reservedSeats = Booking::where('schedule_id', $schedule->id)
            ->pluck('seat_number')
            ->toArray();

        return view('booking.seats', compact('schedule', 'film', 'reservedSeats'));
    }

    /**
     * Memproses data kursi yang dikirim dari form checkout
     */
    public function confirm(Request $request, Schedule $schedule)
    {
        // Validasi input kursi
        $request->validate([
            'selected_seats' => 'required|string|max:200',
        ]);

        // Parse dan bersihkan input kursi
        $seats = array_values(array_filter(array_map('trim', explode(',', $request->selected_seats))));

        // Batasi maksimal 8 kursi per pemesanan
        if (count($seats) === 0 || count($seats) > 8) {
            return back()->withErrors('Pemesanan harus antara 1 hingga 8 kursi.');
        }

        // Validasi format kursi: harus berupa huruf kapital diikuti 1-2 angka (contoh: A1, B12)
        foreach ($seats as $seat) {
            if (!preg_match('/^[A-Z][0-9]{1,2}$/', $seat)) {
                return back()->withErrors('Format kursi tidak valid: ' . $seat);
            }
        }

        // Validasi tambahan: Cek apakah ada kursi yang keduluan dipesan orang lain
        $alreadyTaken = Booking::where('schedule_id', $schedule->id)
            ->whereIn('seat_number', $seats)
            ->exists();

        if ($alreadyTaken) {
            return back()->withErrors('Maaf, salah satu kursi yang Anda pilih baru saja dipesan oleh orang lain. Silakan pilih kursi lain.');
        }

        // Generate order_id yang tidak mudah ditebak menggunakan string acak
        $orderId = 'ORDER-' . strtoupper(Str::random(12));

        // Loop untuk menyimpan setiap kursi yang dipesan ke database
        foreach ($seats as $seat) {
            Booking::create([
                'order_id'    => $orderId,
                'user_id'     => auth()->id(),
                'schedule_id' => $schedule->id,
                'seat_number' => $seat,
                'status'      => 'pending',
            ]);
        }

        // Redirect ke halaman pembayaran
        return redirect()->route('payment.show', $orderId)->with('success', 'Silakan selesaikan pembayaran tiket Anda.');
    }
}