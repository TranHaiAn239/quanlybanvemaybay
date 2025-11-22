<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\HoaDon;
use App\Models\YeuCauHoTro; // <-- Đừng quên import Model này
use Carbon\Carbon;

class DetailedRevenueStatsWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 1;

    protected function getCards(): array
    {
        // --- 1. TÍNH DOANH THU HÔM NAY ---
        $todayInvoice = HoaDon::where('trang_thai', 'da_thanh_toan')
            ->whereDate('ngay_tao', Carbon::today())
            ->sum('tong_tien');

        $todayCancel = YeuCauHoTro::where('trang_thai', 'hoan_tat')
            ->where('loai_yeu_cau', 'huy_ve')
            ->whereDate('ngay_cap_nhat', Carbon::today()) // Tính theo ngày hoàn tất yêu cầu
            ->sum('phu_phi_huy');

        $todayRevenue = $todayInvoice + $todayCancel;

        // --- 2. TÍNH DOANH THU TUẦN NÀY ---
        $weekInvoice = HoaDon::where('trang_thai', 'da_thanh_toan')
            ->whereBetween('ngay_tao', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('tong_tien');

        $weekCancel = YeuCauHoTro::where('trang_thai', 'hoan_tat')
            ->where('loai_yeu_cau', 'huy_ve')
            ->whereBetween('ngay_cap_nhat', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('phu_phi_huy');

        $weekRevenue = $weekInvoice + $weekCancel;

        // --- 3. TÍNH DOANH THU THÁNG NÀY ---
        $monthInvoice = HoaDon::where('trang_thai', 'da_thanh_toan')
            ->whereMonth('ngay_tao', Carbon::now()->month)
            ->whereYear('ngay_tao', Carbon::now()->year)
            ->sum('tong_tien');

        $monthCancel = YeuCauHoTro::where('trang_thai', 'hoan_tat')
            ->where('loai_yeu_cau', 'huy_ve')
            ->whereMonth('ngay_cap_nhat', Carbon::now()->month)
            ->whereYear('ngay_cap_nhat', Carbon::now()->year)
            ->sum('phu_phi_huy');

        $monthRevenue = $monthInvoice + $monthCancel;

        // --- TRẢ VỀ KẾT QUẢ ---
        return [
            Card::make('Doanh thu Hôm nay', number_format($todayRevenue, 0, ',', '.') . ' VND')
                ->description('Vé: ' . number_format($todayInvoice) . ' + Phí hủy: ' . number_format($todayCancel))
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('primary'),

            Card::make('Doanh thu Tuần này', number_format($weekRevenue, 0, ',', '.') . ' VND')
                ->description('Tuần hiện tại')
                ->descriptionIcon('heroicon-s-calendar')
                ->color('warning'),

            Card::make('Doanh thu Tháng này', number_format($monthRevenue, 0, ',', '.') . ' VND')
                ->description('Tháng ' . Carbon::now()->month)
                ->descriptionIcon('heroicon-s-currency-dollar')
                ->color('success'),
        ];
    }
}
