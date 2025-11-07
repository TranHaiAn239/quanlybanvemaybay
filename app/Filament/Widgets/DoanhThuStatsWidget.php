<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\HoaDon;
use App\Models\Booking;

class DoanhThuStatsWidget extends BaseWidget
{
    protected function getCards(): array
    {
        $totalRevenue = HoaDon::where('trang_thai', 'da_thanh_toan')->sum('tong_tien');
        $totalOrders = HoaDon::where('trang_thai', 'da_thanh_toan')->count();
        $pendingOrders = Booking::where('trang_thai', 'cho_thanh_toan')->count();
        $cancelledOrders = Booking::where('trang_thai', 'huy')->count();

        return [
            Card::make('Tổng Doanh Thu', number_format($totalRevenue, 0, ',', '.') . ' VND')
                ->description('Đã thanh toán')
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
