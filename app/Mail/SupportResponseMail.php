<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\YeuCauHoTro;

class SupportResponseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $yeuCau;
    public $noiDungPhanHoi;
    public $isCancellation; // Biến kiểm tra xem có phải là hủy vé không

    public function __construct(YeuCauHoTro $yeuCau, $noiDungPhanHoi, $isCancellation = false)
    {
        $this->yeuCau = $yeuCau;
        $this->noiDungPhanHoi = $noiDungPhanHoi;
        $this->isCancellation = $isCancellation;
    }

    public function build()
    {
        $subject = $this->isCancellation
            ? 'Xác nhận Hủy vé & Hoàn tiền - Yêu cầu #' . $this->yeuCau->id
            : 'Phản hồi yêu cầu hỗ trợ #' . $this->yeuCau->id;

        return $this->subject($subject)
                    ->view('emails.support_response');
    }
}
