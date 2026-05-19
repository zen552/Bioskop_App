<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class PaymentController extends Controller
{
    public function show($order_id)
    {
        $bookings = Booking::with('schedule.film')->where('order_id', $order_id)->get();

        if ($bookings->isEmpty()) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        $schedule = $bookings->first()->schedule;
        $totalPrice = $bookings->count() * $schedule->harga;

        return view('payment.show', compact('bookings', 'schedule', 'totalPrice', 'order_id'));
    }

    public function process($order_id)
    {
        $bookings = Booking::with('schedule.film', 'user')->where('order_id', $order_id)->get();

        if ($bookings->isEmpty()) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        $schedule = $bookings->first()->schedule;
        $totalPrice = $bookings->count() * $schedule->harga;

        // Render mock payment interface
        return view('payment.process', compact('order_id', 'totalPrice'));
    }

    public function simulate(Request $request, $order_id)
    {
        // Simulasi pembayaran berhasil
        Booking::where('order_id', $order_id)->update(['status' => 'success']);

        return redirect()->route('eticket.show', $order_id)->with('success', 'Pembayaran berhasil disimulasikan!');
    }
}

