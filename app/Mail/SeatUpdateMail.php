<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Ve;

class SeatUpdateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ve;
    public $isChange; // Biến để biết là đổi ghế hay chọn mới

    public function __construct(Ve $ve, $isChange = false)
    {
        $this->ve = $ve;
        $this->isChange = $isChange;
    }

    public function build()
    {
        $subject = $this->isChange
            ? 'Thông báo thay đổi số ghế - Chuyến bay ' . $this->ve->chuyenBay->ma_chuyen_bay
            : 'Xác nhận số ghế - Chuyến bay ' . $this->ve->chuyenBay->ma_chuyen_bay;

        return $this->subject($subject)
                    ->view('emails.seat_update');
    }
}
