<?php

namespace App\Jobs;

use App\Mail\TicketEmail;
use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendTicketEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order_id;
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(string $order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Load all bookings for this order with necessary relations
        $bookings = Booking::with('schedule.film', 'user')
            ->where('order_id', $this->order_id)
            ->where('status', 'success')
            ->get();

        if ($bookings->isEmpty()) {
            return;
        }

        $schedule    = $bookings->first()->schedule;
        $user        = $bookings->first()->user;
        $seats       = $bookings->pluck('seat_number')->toArray();
        $seatsString = implode(', ', $seats);

        Mail::to($user->email)->send(new TicketEmail(
            $this->order_id,
            $bookings,
            $schedule,
            $user,
            $seatsString
        ));
    }
}
