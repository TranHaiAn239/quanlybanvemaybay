<!DOCTYPE html>
<html>
<head>
    <title>Thông báo về ghế ngồi</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <div style="max-w-600px; margin: 0 auto; border: 1px solid #ddd; padding: 20px;">
        <h2 style="color: #d9534f;">Thông báo về yêu cầu chọn ghế</h2>

        <p>Xin chào <strong>{{ $ve->thongTinNguoiDi->ho_ten }}</strong>,</p>

        <p>Chúng tôi đã nhận được yêu cầu đặc biệt về chỗ ngồi của quý khách cho chuyến bay <strong>{{ $ve->chuyenBay->ma_chuyen_bay }}</strong>.</p>

        <p>Tuy nhiên, chúng tôi rất tiếc phải thông báo rằng yêu cầu này không thể đáp ứng được vào lúc này.</p>

        <div style="background-color: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <strong>Lý do:</strong> {{ $reason }}
        </div>

        <p>Hệ thống sẽ tự động sắp xếp chỗ ngồi tốt nhất còn lại cho quý khách, hoặc quý khách có thể liên hệ tổng đài để được hỗ trợ thêm.</p>

        <p>Chân thành xin lỗi quý khách vì sự bất tiện này.</p>
        <p>Trân trọng,<br>Đội ngũ Banvemaybay.vn</p>
    </div>
</body>
</html>
