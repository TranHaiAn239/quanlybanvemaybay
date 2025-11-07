<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\HoaDon;
use App\Filament\Widgets\RevenueChartWidget;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;

// Import cho Xuất Excel (v1 của gói filament-excel)
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

// Import cho Cột và Bộ lọc
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class ReportDoanhThu extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationLabel = 'Báo cáo Doanh Thu';
    protected static string $view = 'filament.pages.report-doanh-thu';

    // ===== (ĐÂY LÀ PHẦN THAY THẾ CHO --group) =====
    protected static ?string $navigationGroup = 'Báo cáo';
    protected static ?int $navigationSort = 1;
    // ============================================

    // Hiển thị Widget
    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\DoanhThuStatsWidget::class,
            \App\Filament\Widgets\RevenueChartWidget::class,
        ];
    }

    // === CÁC HÀM CỦA BẢNG ===

    protected function getTableQuery(): Builder
    {
        return HoaDon::query()
                    ->where('trang_thai', 'da_thanh_toan')
                    ->with('booking.nguoiDung');
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('ngay_tao')
                ->label('Ngày Thanh Toán')
                ->dateTime('d/m/Y H:i')
                ->sortable(),

            TextColumn::make('booking.ma_booking')
                ->label('Mã Booking')
                ->searchable()
                ->sortable(),

            TextColumn::make('booking.nguoiDung.ho_ten')
                ->label('Khách hàng')
                ->searchable(),

            TextColumn::make('tong_tien')
                ->label('Tổng tiền')
                ->formatStateUsing(fn ($state): string => number_format($state, 0, ',', '.') . ' VND')
                ->sortable(),

            BadgeColumn::make('phuong_thuc_tt')
                ->label('Phương thức TT')
                ->colors([
                    'primary' => 'the_tin_dung',
                    'success' => 'momo',
                    'info' => 'zalopay',
                    'warning' => 'tien_mat',
                ])
                ->formatStateUsing(fn (string $state): string =>
                    ucfirst(str_replace('_', ' ', $state))
                ),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('phuong_thuc_tt')
                ->label('Phương thức TT')
                ->options([
                    'momo' => 'Momo',
                    'zalopay' => 'ZaloPay',
                    'the_tin_dung' => 'Thẻ tín dụng',
                    'tien_mat' => 'Tiền mặt',
                ]),
        ];
    }

    protected function getTableHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename('BaoCaoDoanhThu_' . date('Y-m-d') . '.xlsx')
                ]),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'ngay_tao';
    }
    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
}
