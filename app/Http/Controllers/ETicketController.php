<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class ETicketController extends Controller
{
    public function index()
    {
        if (auth()->user()?->isAdmin()) {
            abort(403, 'Fitur Tiket Saya hanya tersedia untuk user.');
        }

        $orders = Booking::with('schedule.film')
            ->where('user_id', auth()->id())
            ->where('status', 'success')
            ->get()
            ->groupBy('order_id');

        return view('eticket.index', compact('orders'));
    }

    public function show($order_id)
    {
        if (auth()->user()?->isAdmin()) {
            abort(403, 'Fitur Tiket Saya hanya tersedia untuk user.');
        }

        $bookings = Booking::with('schedule.film', 'user')->where('order_id', $order_id)->get();

        if ($bookings->isEmpty() || $bookings->first()->status !== 'success') {
            abort(404, 'E-Ticket tidak ditemukan atau pembayaran belum selesai.');
        }

        $schedule = $bookings->first()->schedule;
        $user = $bookings->first()->user;
        
        $seats = $bookings->pluck('seat_number')->toArray();
        $seatsString = implode(', ', $seats);

        $qrCodeData = "ORDER_ID: {$order_id} | FILM: {$schedule->film->judul} | SEATS: {$seatsString}";
        
        $qrCode = QrCode::size(200)->generate($qrCodeData);

        return view('eticket.show', compact('bookings', 'schedule', 'user', 'seatsString', 'qrCode', 'order_id'));
    }

    public function downloadPdf($order_id)
    {
        if (auth()->user()?->isAdmin()) {
            abort(403, 'Fitur ini hanya tersedia untuk user.');
        }

        $bookings = Booking::with('schedule.film', 'user')->where('order_id', $order_id)->get();

        if ($bookings->isEmpty() || $bookings->first()->status !== 'success') {
            abort(404, 'E-Ticket tidak ditemukan atau pembayaran belum selesai.');
        }

        $schedule    = $bookings->first()->schedule;
        $user        = $bookings->first()->user;
        $seats       = $bookings->pluck('seat_number')->toArray();
        $seatsString = implode(', ', $seats);

        $qrCodeData = "ORDER_ID: {$order_id} | FILM: {$schedule->film->judul} | SEATS: {$seatsString}";
        $qrCode     = QrCode::size(300)->generate($qrCodeData);

        $pdf = Pdf::loadView('eticket.pdf', compact(
            'order_id', 'schedule', 'user', 'seatsString', 'qrCode'
        ));

        return $pdf->download('eticket-' . $order_id . '.pdf');
    }
}
