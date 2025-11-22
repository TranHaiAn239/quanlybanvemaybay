<!DOCTYPE html>
<html>
<head>
    <title>Phản hồi hỗ trợ</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="max-w-600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px;">

        <h2 style="color: #0056b3;">Kính chào {{ $yeuCau->ho_ten }},</h2>

        <p>Chúng tôi đã nhận được yêu cầu hỗ trợ của bạn về vấn đề: <strong>{{ ucfirst(str_replace('_', ' ', $yeuCau->loai_yeu_cau)) }}</strong></p>

        {{-- NỘI DUNG XỬ LÝ --}}
        <div style="background-color: #f8f9fa; padding: 15px; border-left: 4px solid #0056b3; margin: 20px 0;">
            <strong>Phản hồi từ nhân viên:</strong><br>
            {!! nl2br(e($noiDungPhanHoi)) !!}
        </div>

        @if($isCancellation)
        {{-- THÔNG BÁO PHÍ HỦY (Chỉ hiện khi là Hủy vé) --}}
        <div style="background-color: #fff3cd; padding: 15px; border: 1px solid #ffeeba; color: #856404;">
            <h4>⚠️ THÔNG TIN HOÀN HỦY:</h4>
            <p>Yêu cầu hủy vé của bạn đã được chấp thuận.</p>
            <ul>
                <li><strong>Mã Booking:</strong> {{ $yeuCau->ma_booking }}</li>
                <li><strong>Phí hủy vé:</strong> {{ number_format($yeuCau->phu_phi_huy, 0, ',', '.') }} VND</li>
                <li><strong>Số tiền hoàn lại:</strong> Sẽ được chuyển vào tài khoản thanh toán ban đầu của bạn trong vòng 7-14 ngày làm việc (sau khi trừ phí hủy).</li>
            </ul>
        </div>
        @endif

        <p>Cảm ơn bạn đã sử dụng dịch vụ của Sanvemaybay.vn.</p>
        <hr>
        <small style="color: #777;">Đây là email tự động, vui lòng không trả lời email này.</small>
    </div>
</body>
</html>
