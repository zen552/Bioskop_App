<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Booking; 
use Illuminate\Http\Request;

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
        // Validasi input kursi tidak boleh kosong
        $request->validate([
            'selected_seats' => 'required|string',
        ]);

        // Mengubah string "A1,A2,A3" dari input hidden menjadi array ['A1', 'A2', 'A3']
        $seats = explode(',', $request->selected_seats);

        // Validasi tambahan: Cek apakah ada kursi yang keduluan dipesan orang lain
        $alreadyTaken = Booking::where('schedule_id', $schedule->id)
            ->whereIn('seat_number', $seats)
            ->exists();

        if ($alreadyTaken) {
            return back()->withErrors('Maaf, salah satu kursi yang Anda pilih baru saja dipesan oleh orang lain. Silakan pilih kursi lain.');
        }

        // Generate unique order_id
        $orderId = 'ORDER-' . time() . '-' . rand(1000, 9999);

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