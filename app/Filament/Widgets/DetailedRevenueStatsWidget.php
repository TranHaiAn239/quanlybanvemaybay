<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use App\Models\HoaDon;
use Carbon\Carbon;

class DetailedRevenueStatsWidget extends BaseWidget
{
    // Đặt độ rộng là 1 cột (trong lưới 2 cột)
    protected int | string | array $columnSpan = 1;

    protected function getCards(): array
    {
        // 1. Doanh thu HÔM NAY
        $todayRevenue = HoaDon::where('trang_thai', 'da_thanh_toan')
            ->whereDate('ngay_tao', Carbon::today())
            ->sum('tong_tien');

        // 2. Doanh thu TUẦN NÀY
        $weekRevenue = HoaDon::where('trang_thai', 'da_thanh_toan')
            ->whereBetween('ngay_tao', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
            ->sum('tong_tien');

        // 3. Doanh thu THÁNG NÀY
        $monthRevenue = HoaDon::where('trang_thai', 'da_thanh_toan')
            ->whereMonth('ngay_tao', Carbon::now()->month)
            ->whereYear('ngay_tao', Carbon::now()->year)
            ->sum('tong_tien');

        return [
            Card::make('Doanh thu Hôm nay', number_format($todayRevenue, 0, ',', '.') . ' VND')
                ->description(Carbon::today()->format('d/m/Y'))
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
