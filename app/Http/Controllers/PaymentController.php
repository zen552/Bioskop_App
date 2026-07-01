<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Snap;
use Midtrans\Notification;
use App\Models\Booking;
use App\Jobs\SendTicketEmailJob;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    // 1. BACKEND: Simpan orderan masuk ke DB dengan status pending & panggil pop-up Midtrans
    public function createTransaction(Request $request)
    {
        $orderId = 'BKS-' . uniqid();
        $movieTitle = $request->movie_title ?? 'Tiket Nonton Bioskop';
        $totalHarga = $request->total_harga ?? 50000;

        // Proses backend mencatat transaksi awal ke database lokal
        DB::table('transactions')->insert([
            'order_id'         => $orderId,
            'movie_title'      => $movieTitle,
            'total_harga'      => $totalHarga,
            'status_pembayaran' => 'pending',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);

        $params = [
            'transaction_details' => [
                'order_id'     => $orderId,
                'gross_amount' => $totalHarga,
            ],
            'customer_details' => [
                'first_name' => 'Pembeli Bioskop',
                'email'      => 'pembeli@example.com',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('pages.payment', compact('snapToken', 'params'));
        } catch (\Exception $e) {
            Log::error('Midtrans createTransaction error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        }
    }

    // 2. BACKEND WEBHOOK: Server Midtrans memicu fungsi ini untuk mengubah status DB
    public function handleNotification(Request $request)
    {
        try {
            $notif = new Notification();

            // Verifikasi signature dari Midtrans agar tidak bisa dipalsukan
            $expectedSignature = hash('sha512',
                $notif->order_id .
                $notif->status_code .
                $notif->gross_amount .
                config('services.midtrans.server_key')
            );

            if ($expectedSignature !== $notif->signature_key) {
                Log::warning('Midtrans webhook: invalid signature for order ' . $notif->order_id);
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $transactionStatus = $notif->transaction_status;
            $orderId           = $notif->order_id;

            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                DB::table('transactions')->where('order_id', $orderId)->update(['status_pembayaran' => 'success']);
                // Kirim email tiket ke background queue
                // Kirim email tiket ke background queue
                SendTicketEmailJob::dispatch($orderId);
            } elseif ($transactionStatus == 'pending') {
                DB::table('transactions')->where('order_id', $orderId)->update(['status_pembayaran' => 'pending']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                DB::table('transactions')->where('order_id', $orderId)->update(['status_pembayaran' => 'failed']);
            }

            return response()->json(['message' => 'Notification handled successfully']);
        } catch (\Exception $e) {
            Log::error('Midtrans webhook error: ' . $e->getMessage());
            return response()->json(['message' => 'Internal server error'], 500);
        }
    }

    // --- Original methods for the booking mock payment flow ---

    public function show($order_id)
    {
        // Hanya pemilik order yang boleh melihat halaman pembayaran ini
        $bookings = Booking::with('schedule.film')
            ->where('order_id', $order_id)
            ->where('user_id', auth()->id())
            ->get();

        if ($bookings->isEmpty()) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        $schedule   = $bookings->first()->schedule;
        $totalPrice = $bookings->count() * $schedule->harga;

        return view('payment.show', compact('bookings', 'schedule', 'totalPrice', 'order_id'));
    }

    public function process($order_id)
    {
        // Hanya pemilik order yang boleh melanjutkan ke pembayaran Midtrans
        $bookings = Booking::with('schedule.film', 'user')
            ->where('order_id', $order_id)
            ->where('user_id', auth()->id())
            ->get();

        if ($bookings->isEmpty()) {
            abort(404, 'Pesanan tidak ditemukan.');
        }

        $schedule   = $bookings->first()->schedule;
        $totalPrice = $bookings->count() * $schedule->harga;

        $params = [
            'transaction_details' => [
                'order_id'     => $order_id,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans process error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memproses pembayaran. Silakan coba lagi.');
        }

        return view('payment.process', compact('order_id', 'totalPrice', 'snapToken'));
    }

    public function simulate(Request $request, $order_id)
    {
        // Pastikan order ini benar-benar milik user yang sedang login dan masih pending
        $bookings = Booking::where('order_id', $order_id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        if ($bookings->isEmpty()) {
            abort(404, 'Pesanan tidak ditemukan atau sudah diproses.');
        }

        Booking::where('order_id', $order_id)
            ->where('user_id', auth()->id())
            ->update(['status' => 'success']);

        // Kirim email tiket ke background queue
        // Kirim email tiket ke background queue
        SendTicketEmailJob::dispatch($order_id);

        return redirect()->route('eticket.show', $order_id)->with('success', 'Pembayaran berhasil disimulasikan!');
    }

    public function cancel(Request $request, $order_id)
    {
        // Pastikan hanya pemilik order yang bisa membatalkan
        $bookings = Booking::where('order_id', $order_id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->get();

        if ($bookings->isNotEmpty()) {
            $schedule_id = $bookings->first()->schedule_id;

            // Hapus agar kursi bisa dipilih kembali
            Booking::where('order_id', $order_id)
                ->where('user_id', auth()->id())
                ->where('status', 'pending')
                ->delete();

            return redirect()->route('booking.seats', $schedule_id)->with('success', 'Transaksi dibatalkan. Silakan pilih kursi kembali.');
        }

        return redirect()->route('home');
    }
}