<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Notification;

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
            'order_id' => $orderId,
            'movie_title' => $movieTitle,
            'total_harga' => $totalHarga,
            'status_pembayaran' => 'pending',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalHarga,
            ],
            'customer_details' => [
                'first_name' => 'Pembeli Bioskop',
                'email' => 'pembeli@example.com',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return view('pages.payment', compact('snapToken', 'params'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran: ' . $e->getMessage());
        }
    }

    // 2. BACKEND WEBHOOK: Server Midtrans akan otomatis memicu fungsi ini untuk mengubah status DB saat user selesai transfer
    public function handleNotification(Request $request)
    {
        try {
            $notif = new Notification();
            $transactionStatus = $notif->transaction_status;
            $orderId = $notif->order_id;

            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                DB::table('transactions')->where('order_id', $orderId)->update(['status_pembayaran' => 'success']);
            } elseif ($transactionStatus == 'pending') {
                DB::table('transactions')->where('order_id', $orderId)->update(['status_pembayaran' => 'pending']);
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                DB::table('transactions')->where('order_id', $orderId)->update(['status_pembayaran' => 'failed']);
            }

            return response()->json(['message' => 'Notification handled successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}