<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hóa Đơn {{ $booking->ma_booking }}</title>
    {{-- Tải CSS của Tailwind (Vite) --}}
    @vite(['resources/css/app.css'])

    <style>
        /* CSS cho bản in: Ẩn nút "In" và các phần tử không cần thiết */
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                -webkit-print-color-adjust: exact; /* Đảm bảo màu nền được in (Chrome) */
                color-adjust: exact; /* Đảm bảo màu nền được in (Firefox) */
            }
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="max-w-4xl mx-auto my-12 p-8 bg-white shadow-2xl rounded-lg">

        <div class="flex justify-between items-center pb-6 border-b no-print">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Chi Tiết Hóa Đơn</h1>
                <p class="text-gray-600">Mã Booking: <span class="font-semibold">{{ $booking->ma_booking }}</span></p>
            </div>
            <button
                onclick="window.print()"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow">
                In Trang
            </button>
        </div>

        <div class="grid grid-cols-2 gap-8 py-8 border-b">
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Nhà Cung Cấp:</h2>
                <p class="font-semibold">Công Ty Cổ Phần Săn Vé Máy Bay</p>
                <p>123 Đường ABC, Quận 1, TP. HCM</p>
                <p>MST: 0123456789</p>
                <p>Email: support@sanvemaybay.vn</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-800 mb-2">Khách hàng:</h2>
                <p class="font-semibold">{{ $booking->nguoiDung->ho_ten }}</p>
                <p>{{ $booking->nguoiDung->dia_chi }}</p>
                <p>{{ $booking->nguoiDung->so_dien_thoai }}</p>
                <p>{{ $booking->nguoiDung->email }}</p>
            </div>
        </div>

        <div class="flex justify-between items-center py-4 border-b">
            <div>
                <span class="text-gray-600">Số Hóa Đơn:</span>
                <span class="font-semibold">{{ $booking->hoaDon->id ?? 'N/A' }}</span>
            </div>
            <div>
                <span class="text-gray-600">Ngày Thanh Toán:</span>
                <span class="font-semibold">{{ $booking->hoaDon->ngay_tao->format('d/m/Y H:i') ?? 'N/A' }}</span>
            </div>
            <div>
                <span class="text-gray-600">Hình thức TT:</span>
                <span class="font-semibold">{{ ucfirst(str_replace('_', ' ', $booking->phuong_thuc_tt)) }}</span>
            </div>
        </div>

        <div class="mt-8">
            <h3 class="text-2xl font-bold text-gray-800 mb-4">Chi tiết đơn hàng</h3>
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-sm font-semibold">Hành khách</th>
                        <th class="p-3 text-sm font-semibold">Chi tiết vé</th>
                        <th class="p-3 text-sm font-semibold text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($booking->ves as $ve)
                    <tr>
                        <td class="p-3 align-top">
                            <p class="font-semibold">{{ $ve->thongTinNguoiDi->ho_ten ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600">{{ ucfirst(str_replace('_', ' ', $ve->loai_hanh_khach)) }}</p>
                        </td>
                        <td class="p-3 align-top">
                            <p class="font-semibold">
                                {{ $ve->chuyenBay->sanBayDi->ma_san_bay }} &rarr; {{ $ve->chuyenBay->sanBayDen->ma_san_bay }}
                                ({{ $ve->chuyenBay->thoi_gian_di->format('d/m/Y') }})
                            </p>
                            <p class="text-sm text-gray-600">Ghế: {{ ucfirst($ve->loai_ghe) }} ({{ number_format($ve->gia_ghe, 0, ',', '.') }} đ)</p>
                            <p class="text-sm text-gray-600">Hành lý: {{ number_format($ve->gia_hanh_ly, 0, ',', '.') }} đ</p>
                        </td>
                        <td class="p-3 align-top text-right font-semibold">
                            {{ number_format($ve->gia_ve + $ve->gia_ghe + $ve->gia_hanh_ly, 0, ',', '.') }} VND
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mt-8">
            <div class="w-full md:w-1/2 lg:w-1/3 space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">Tổng tiền (Vé + Ghế + Hành lý):</span>
                    <span class="font-semibold">{{ number_format($booking->tong_tien + $booking->giam_gia, 0, ',', '.') }} VND</span>
                </div>
                @if ($booking->giam_gia > 0)
                <div class="flex justify-between text-green-600">
                    <span class="font-semibold">Giảm giá:</span>
                    <span class="font-semibold">- {{ number_format($booking->giam_gia, 0, ',', '.') }} VND</span>
                </div>
                @endif
                <hr class="border-dashed">
                <div class="flex justify-between text-2xl font-bold text-red-600">
                    <span>Tổng cộng thanh toán:</span>
                    <span>{{ number_format($booking->tong_tien, 0, ',', '.') }} VND</span>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
