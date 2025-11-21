<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Booking;

class BookingSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function build()
    {
        return $this->subject('Xác nhận đặt vé thành công - Mã: ' . $this->booking->ma_booking)
                    ->view('emails.booking_success'); // Chúng ta sẽ tạo view này sau
    }
}
