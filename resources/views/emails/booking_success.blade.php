<!DOCTYPE html>
<html>
<head>
    <title>Vé máy bay điện tử</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <div style="max-w-600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px;">
        <h2 style="color: #28a745;">Đặt vé thành công!</h2>
        <p>Xin chào <strong>{{ $booking->nguoiDung->ho_ten }}</strong>,</p>
        <p>Cảm ơn quý khách đã đặt vé tại Banvemaybay.vn. Dưới đây là thông tin vé điện tử của quý khách:</p>

        <h3>Mã Đặt Chỗ: {{ $booking->ma_booking }}</h3>

        <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
            <tr style="background-color: #f8f9fa;">
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Hành khách</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Chuyến bay</th>
            </tr>
            @foreach($booking->ves as $ve)
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd;">
                    {{ $ve->thongTinNguoiDi->ho_ten }}<br>
                    <small>({{ ucfirst($ve->loai_hanh_khach) }})</small>
                </td>
                <td style="padding: 10px; border: 1px solid #ddd;">
                    {{ $ve->chuyenBay->sanBayDi->ma_san_bay }} -> {{ $ve->chuyenBay->sanBayDen->ma_san_bay }}<br>
                    <small>Giờ bay: {{ $ve->chuyenBay->thoi_gian_di->format('H:i d/m/Y') }}</small>
                </td>
            </tr>
            @endforeach
        </table>

        <div style="background-color: #fff3cd; padding: 15px; margin-top: 20px; border-radius: 5px;">
            <h4>⚠️ Quy định & Thủ tục sân bay:</h4>
            <ul>
                <li>Quý khách vui lòng có mặt tại sân bay trước giờ khởi hành ít nhất <strong>90 phút</strong> (nội địa) hoặc <strong>180 phút</strong> (quốc tế).</li>
                <li>Mang theo giấy tờ tùy thân (CCCD/CMND/Hộ chiếu) bản chính và còn hạn sử dụng.</li>
                <li>Hành lý xách tay không quá 7kg. Không mang vật cấm, chất lỏng quá 100ml.</li>
            </ul>
        </div>

        <p style="margin-top: 20px;">Chúc quý khách có một chuyến bay tốt đẹp!</p>
    </div>

</body>
</html>
