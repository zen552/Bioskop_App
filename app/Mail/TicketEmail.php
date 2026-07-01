<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookings;
    public $schedule;
    public $user;
    public $seatsString;
    public $order_id;
    public $qrCode;

    /**
     * Create a new message instance.
     */
    public function __construct($order_id, $bookings, $schedule, $user, $seatsString)
    {
        $this->order_id    = $order_id;
        $this->bookings    = $bookings;
        $this->schedule    = $schedule;
        $this->user        = $user;
        $this->seatsString = $seatsString;

        // Generate QR code SVG string
        $qrData = "ORDER_ID: {$order_id} | FILM: {$schedule->film->judul} | SEATS: {$seatsString}";
        $this->qrCode = QrCode::size(300)->generate($qrData);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'E-Ticket BioskopKu — ' . $this->schedule->film->judul,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticket',
            with: [
                'order_id'    => $this->order_id,
                'schedule'    => $this->schedule,
                'user'        => $this->user,
                'seatsString' => $this->seatsString,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        // Generate PDF in memory and attach it
        $pdf = Pdf::loadView('eticket.pdf', [
            'order_id'    => $this->order_id,
            'schedule'    => $this->schedule,
            'user'        => $this->user,
            'seatsString' => $this->seatsString,
            'qrCode'      => $this->qrCode,
        ]);

        $filename = 'eticket-' . $this->order_id . '.pdf';

        return [
            Attachment::fromData(fn () => $pdf->output(), $filename)
                ->withMime('application/pdf'),
        ];
    }
}
