<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\HoaDon;
use App\Models\Booking;
use App\Models\YeuCauHoTro; // <-- Thêm Model này

class DoanhThuStatsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getCards(): array
    {
        // 1. Doanh thu từ Hóa đơn bán hàng
        $invoiceRevenue = HoaDon::where('trang_thai', 'da_thanh_toan')->sum('tong_tien');

        // 2. Doanh thu từ Phí hủy vé (Yêu cầu hỗ trợ đã hoàn tất)
        $cancellationRevenue = YeuCauHoTro::where('trang_thai', 'hoan_tat')
            ->where('loai_yeu_cau', 'huy_ve')
            ->sum('phu_phi_huy');

        // 3. TỔNG DOANH THU THỰC TẾ
        $totalRevenue = $invoiceRevenue + $cancellationRevenue;

        // Các thống kê khác
        $totalOrders = HoaDon::where('trang_thai', 'da_thanh_toan')->count();
        $pendingOrders = Booking::where('trang_thai', 'cho_thanh_toan')->count();
        $cancelledOrders = Booking::where('trang_thai', 'huy')->count();

        return [
            Card::make('Tổng Doanh Thu', number_format($totalRevenue, 0, ',', '.') . ' VND')
                ->description('Vé bán ra + Phí hủy vé') // Cập nhật mô tả
                ->descriptionIcon('heroicon-s-cash')
                ->color('success'),

            Card::make('Tổng Đơn Đã Thanh Toán', $totalOrders)
                ->description('Đơn hàng thành công')
                ->descriptionIcon('heroicon-s-check-circle')
                ->color('success'),

            Card::make('Đơn Hàng Chờ Xử Lý', $pendingOrders)
                ->description('Đơn chờ thanh toán (tiền mặt)')
                ->descriptionIcon('heroicon-s-clock')
                ->color('warning'),

            Card::make('Đơn Hàng Đã Hủy', $cancelledOrders)
                ->description('Các đơn hàng đã bị hủy')
                ->descriptionIcon('heroicon-s-x-circle')
                ->color('danger'),
        ];
    }
}
