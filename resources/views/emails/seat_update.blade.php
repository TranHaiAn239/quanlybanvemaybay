<!DOCTYPE html>
<html>
<head>
    <title>Thông báo số ghế</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="max-w-600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px;">
        <h2 style="color: #0056b3;">
            {{ $isChange ? 'THÔNG BÁO THAY ĐỔI SỐ GHẾ' : 'XÁC NHẬN SỐ GHẾ' }}
        </h2>

        <p>Xin chào <strong>{{ $ve->thongTinNguoiDi->ho_ten }}</strong>,</p>

        <p>
            {{ $isChange
                ? 'Chúng tôi xin thông báo số ghế của quý khách trên chuyến bay đã được thay đổi.'
                : 'Chúng tôi xin xác nhận số ghế cho chuyến bay của quý khách.'
            }}
        </p>

        <div style="background-color: #f0f8ff; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Chuyến bay:</strong> {{ $ve->chuyenBay->ma_chuyen_bay }}</p>
            <p><strong>Hành trình:</strong> {{ $ve->chuyenBay->sanBayDi->ten_san_bay }} -> {{ $ve->chuyenBay->sanBayDen->ten_san_bay }}</p>
            <p><strong>Thời gian:</strong> {{ $ve->chuyenBay->thoi_gian_di->format('H:i d/m/Y') }}</p>
            <hr style="border-top: 1px dashed #ccc;">
            <p style="font-size: 18px; color: #d9534f;">
                <strong>SỐ GHẾ: {{ $ve->so_ghe }}</strong>
            </p>
            <p><strong>Hạng ghế:</strong> {{ ucfirst($ve->loai_ghe) }}</p>
        </div>

        <p>Vui lòng sử dụng thông tin này khi làm thủ tục tại sân bay.</p>
        <p>Trân trọng,<br>Đội ngũ Banvemaybay.vn</p>
    </div>
</body>
</html>
