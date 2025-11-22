<?php

namespace App\Filament\Widgets;

use Filament\Widgets\LineChartWidget;
use App\Models\HoaDon;
use App\Models\YeuCauHoTro; // <-- Thêm Model
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RevenueChartWidget extends LineChartWidget
{
    protected static ?string $heading = 'Doanh thu 12 tháng qua';
    protected int | string | array $columnSpan = 1;
    protected static ?string $maxHeight = '300px';

    protected function getData(): array
    {
        // 1. Lấy doanh thu Hóa Đơn (theo tháng)
        $invoiceData = HoaDon::where('trang_thai', 'da_thanh_toan')
            ->where('ngay_tao', '>=', now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw('SUM(tong_tien) as total'),
                DB::raw("DATE_FORMAT(ngay_tao, '%Y-%m') as month_year")
            )
            ->groupBy('month_year')
            ->pluck('total', 'month_year');

        // 2. Lấy doanh thu Phí Hủy (theo tháng - dựa trên ngày cập nhật hoàn tất)
        $cancelData = YeuCauHoTro::where('trang_thai', 'hoan_tat')
            ->where('loai_yeu_cau', 'huy_ve')
            ->where('ngay_cap_nhat', '>=', now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw('SUM(phu_phi_huy) as total'),
                DB::raw("DATE_FORMAT(ngay_cap_nhat, '%Y-%m') as month_year")
            )
            ->groupBy('month_year')
            ->pluck('total', 'month_year');

        $labels = [];
        $revenueData = [];

        // 3. Gộp dữ liệu
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $key = $date->format('Y-m');
            $labels[] = $date->format('m/Y');

            // Tổng = Hóa đơn + Phí hủy
            $total = ($invoiceData->get($key) ?? 0) + ($cancelData->get($key) ?? 0);
            $revenueData[] = $total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Tổng doanh thu (Vé + Phí hủy)',
                    'data' => $revenueData,
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => '#9BD0F5',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }
}
