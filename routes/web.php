<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaymentController; // <-- Kita panggil Controller Midtrans Anda di sini
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Baris dashboard yang tadi rusak sekarang sudah bersih
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --- JALUR BACKEND MIDTRANS ANDA ---
// Diubah dari POST menjadi ANY sementara waktu untuk kebutuhan testing langsung lewat URL browser
Route::middleware('auth')->group(function () {
    Route::any('/payment/checkout', [PaymentController::class, 'createTransaction'])->name('payment.checkout');
});

require __DIR__.'/auth.php';