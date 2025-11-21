<!DOCTYPE html>
<html>
<head>
    <title>Xác nhận giữ chỗ</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">

    <div style="max-w-600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px;">
        <h2 style="color: #007bff;">Xác nhận giữ chỗ thành công!</h2>
        <p>Xin chào <strong>{{ $booking->nguoiDung->ho_ten }}</strong>,</p>
        <p>Đơn hàng của quý khách đã được tạo. Vui lòng thanh toán để hoàn tất việc xuất vé.</p>

        <div style="background-color: #f8f9fa; padding: 15px; border: 1px solid #ddd; margin: 15px 0;">
            <p><strong>Mã đơn hàng:</strong> {{ $booking->ma_booking }}</p>
            <p><strong>Tổng tiền:</strong> {{ number_format($booking->tong_tien, 0, ',', '.') }} VND</p>
            <p><strong>Hạn thanh toán:</strong> Trong vòng 24 giờ kể từ bây giờ.</p>
        </div>

        <h3>Hướng dẫn thanh toán tiền mặt:</h3>
        <p>Quý khách vui lòng đến văn phòng của chúng tôi tại:</p>
        <p><strong>Địa chỉ:</strong> 47A Lê Trung Tấn, P.Tân Sơn Nhì, Q.Tân Phú, TP.HCM</p>
        <p><strong>Giờ làm việc:</strong> 08:00 - 21:00 (Tất cả các ngày trong tuần)</p>

        <p>Hoặc tại các chi nhánh văn phòng gần nơi bạn nhất!</p>

        <p><em>Lưu ý: Nếu quá hạn thanh toán, vé giữ chỗ sẽ tự động bị hủy.</em></p>
    </div>

</body>
</html>
