<?php

namespace App\Filament\Widgets;

// SỬA LẠI: Dùng 'LineChartWidget'
use Filament\Widgets\LineChartWidget;
use App\Models\HoaDon;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class RevenueChartWidget extends LineChartWidget
{
    protected static ?string $heading = 'Doanh thu 12 tháng qua';
    protected static ?string $maxHeight = '300px';

    protected int | string | array $columnSpan = 1;
    protected function getData(): array
    {
        // 1. Lấy dữ liệu doanh thu từ CSDL
        $data = HoaDon::where('trang_thai', 'da_thanh_toan')
            ->where('ngay_tao', '>=', now()->subMonths(11)->startOfMonth())
            ->select(
                DB::raw('SUM(tong_tien) as total_revenue'),
                DB::raw("DATE_FORMAT(ngay_tao, '%Y-%m') as month_year")
            )
            ->groupBy('month_year')
            ->orderBy('month_year', 'asc')
            ->get()
            ->pluck('total_revenue', 'month_year'); // Tạo mảng: ['2025-01' => 1500000]

        $labels = [];
        $revenueData = [];

        // 2. Tạo mảng 12 tháng (từ 11 tháng trước đến tháng này)
        for ($i = 11; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthYear = $date->format('Y-m'); // Key (vd: '2025-11')
            $label = $date->format('m/Y');     // Nhãn (vd: '11/2025')

            $labels[] = $label;
            // Lấy doanh thu của tháng, nếu không có thì gán = 0
            $revenueData[] = $data->get($monthYear, 0);
        }

        // 3. Trả về dữ liệu cho biểu đồ
        return [
            'datasets' => [
                [
                    'label' => 'Doanh thu',
                    'data' => $revenueData,
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => '#9BD0F5',
                ],
            ],
            'labels' => $labels,
        ];
    }
}
