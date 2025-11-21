<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ve;

class SeatUnavailableMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ve;
    public $reason; // Lý do cụ thể (Admin nhập)

    public function __construct(Ve $ve, $reason)
    {
        $this->ve = $ve;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('Thông báo về yêu cầu chọn ghế - Chuyến bay ' . $this->ve->chuyenBay->ma_chuyen_bay)
                    ->view('emails.seat_unavailable');
    }
}
