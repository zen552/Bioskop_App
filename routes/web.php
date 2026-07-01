<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\FilmController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/booking/seats/{schedule}', [BookingController::class, 'selectSeats'])->name('booking.seats');
    Route::post('/booking/confirm/{schedule}', [BookingController::class, 'confirm'])->name('booking.confirm');
    
    // Payment Routes (Mock / Original)
    Route::get('/pembayaran/{order_id}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/pembayaran/process/{order_id}', [PaymentController::class, 'process'])->name('payment.process');
    Route::post('/pembayaran/simulate/{order_id}', [PaymentController::class, 'simulate'])->name('payment.simulate');
    Route::post('/pembayaran/cancel/{order_id}', [PaymentController::class, 'cancel'])->name('payment.cancel');
    
    // Midtrans Checkout Routes
    Route::post('/payment/checkout', [PaymentController::class, 'createTransaction'])->name('payment.checkout');
    
    // E-Ticket
    Route::get('/tiket-saya', [App\Http\Controllers\ETicketController::class, 'index'])->name('eticket.index');
    Route::get('/e-ticket/{order_id}', [App\Http\Controllers\ETicketController::class, 'show'])->name('eticket.show');
    Route::get('/e-ticket/{order_id}/download', [App\Http\Controllers\ETicketController::class, 'downloadPdf'])->name('eticket.download');
});

// Route khusus admin
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/preview', [AdminController::class, 'previewHome'])->name('preview');
        Route::get('/preview/films/{film}', [AdminController::class, 'previewFilm'])->name('preview.films.show');
        Route::resource('films', FilmController::class);
        Route::post('/genres', [FilmController::class, 'storeGenre'])->name('genres.store');
        Route::resource('schedules', ScheduleController::class);
    });

Route::get('/films/{film}', function (\App\Models\Film $film) {
    $schedules = \App\Models\Schedule::with('film')
        ->where('film_id', $film->id)
        ->whereDate('tanggal', '>=', today())
        ->orderBy('tanggal')
        ->orderBy('jam_tayang')
        ->get();
    return view('films.detail', compact('film', 'schedules'));
})->name('films.detail');


require __DIR__.'/auth.php';