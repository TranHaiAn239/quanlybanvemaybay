<?php

namespace App\Filament\Resources\ChuyenBayResource\Pages;

use App\Filament\Resources\ChuyenBayResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Pages\Actions\Action; // Dùng Action của Page
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use App\Models\SanBay;
use App\Models\MayBay;
use App\Models\ChuyenBay;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Filament\Notifications\Notification;

class ListChuyenBays extends ListRecords
{

/**
     * Hàm 1: Định nghĩa các nút ở đầu trang
     */
    protected function getHeaderActions(): array
    {
        return [
            // Nút "New chuyến bay" mặc định
            parent::getCreateAction(),

            // Nút "Tạo hàng loạt" (MỚI)
            Action::make('create_batch')
                ->label('Tạo chuyến bay hàng loạt')
                ->icon('heroicon-o-calendar') // Icon lịch
                ->form($this->getBatchCreateFormSchema()) // Gọi form (Hàm 2)
                ->action(function (array $data) {
                    // Gọi logic xử lý (Hàm 3)
                    $count = $this->executeBatchCreate($data);

                    // Gửi thông báo thành công
                    Notification::make()
                        ->title("Tạo hàng loạt thành công")
                        ->body("Đã tạo mới $count chuyến bay.")
                        ->success()
                        ->send();
                }),
        ];
    }

    /**
     * Hàm 2: Định nghĩa Form (cửa sổ pop-up)
     */
    protected function getBatchCreateFormSchema(): array
    {
        return [
            Section::make('Thông tin chung')
                ->schema([
                    // Truy vấn CSDL để lấy Sân Bay và Máy Bay
                    Select::make('id_san_bay_di')->label('Sân bay đi')
                        ->options(SanBay::all()->pluck('ten_san_bay', 'id'))
                        ->searchable()->required(),
                    Select::make('id_san_bay_den')->label('Sân bay đến')
                        ->options(SanBay::all()->pluck('ten_san_bay', 'id'))
                        ->searchable()->required(),
                    Select::make('id_may_bay')->label('Máy bay')
                        ->options(MayBay::all()->pluck('ten_may_bay', 'id'))
                        ->searchable()->required(),
                    TextInput::make('gia_ve')->label('Giá vé (VND)')->numeric()->required(),
                ])->columns(2),

            Section::make('Lịch trình lặp lại')
                ->schema([
                    DatePicker::make('start_date')->label('Từ ngày')
                        ->required()->default(now()),
                    DatePicker::make('end_date')->label('Đến ngày')
                        ->required()->default(now()->addDays(30)), // Mặc định tạo 30 ngày
                    TimePicker::make('departure_time')->label('Giờ cất cánh')
                        ->required()->withoutSeconds(),
                    TimePicker::make('arrival_time')->label('Giờ hạ cánh')
                        ->required()->withoutSeconds(),
                ])->columns(2),
        ];
    }

    /**
     * Hàm 3: Logic xử lý tạo chuyến bay hàng loạt
     */
    protected function executeBatchCreate(array $data): int
    {
        $startDate = Carbon::parse($data['start_date']);
        $endDate = Carbon::parse($data['end_date']);
        $departureTime = Carbon::parse($data['departure_time']);
        $arrivalTime = Carbon::parse($data['arrival_time']);

        $count = 0;

        // Bắt đầu vòng lặp từ ngày bắt đầu đến ngày kết thúc
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {

            // Kết hợp Ngày (từ vòng lặp) và Giờ (từ form)
            $thoi_gian_di = $date->copy()->setTime($departureTime->hour, $departureTime->minute);
            $thoi_gian_den = $date->copy()->setTime($arrivalTime->hour, $arrivalTime->minute);

            // Xử lý logic bay qua đêm (VD: bay 23:00, hạ cánh 01:00)
            if ($thoi_gian_den->lt($thoi_gian_di)) {
                $thoi_gian_den->addDay(); // Cộng thêm 1 ngày vào ngày hạ cánh
            }

            try {
                ChuyenBay::create([
                    // Tự động tạo mã chuyến bay ngẫu nhiên
                    'ma_chuyen_bay' => strtoupper(Str::random(2)) . $date->format('md') . rand(100, 999),
                    'id_may_bay' => $data['id_may_bay'],
                    'id_san_bay_di' => $data['id_san_bay_di'],
                    'id_san_bay_den' => $data['id_san_bay_den'],
                    'thoi_gian_di' => $thoi_gian_di,
                    'thoi_gian_den' => $thoi_gian_den,
                    'gia_ve' => $data['gia_ve'],
                    'trang_thai' => 'dang_ban',
                ]);
                $count++;
            } catch (\Exception $e) {
                // Có thể bỏ qua nếu chuyến bay đã tồn tại (trùng mã)
                \Log::error('Lỗi tạo chuyến bay hàng loạt: ' . $e->getMessage());
            }
        }
        return $count; // Trả về số lượng chuyến bay đã tạo
    }

    protected static string $resource = ChuyenBayResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
