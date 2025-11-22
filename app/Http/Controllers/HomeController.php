<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanBay;
use App\Models\BaiViet;

class HomeController extends Controller
{
    /**
     * Hiển thị trang chủ.
     */
    public function index()
    {
        // Lấy tất cả sân bay, sắp xếp theo Tên
        $allAirports = SanBay::orderBy('ten_san_bay', 'asc')->get();

        // Nhóm sân bay theo Quốc gia
        // Kết quả sẽ là một Collection dạng:
        // [
        //    'Việt Nam' => [SanBay1, SanBay2...],
        //    'Thái Lan' => [SanBay3...],
        // ]
        $groupedSanBays = $allAirports->groupBy('quoc_gia');

        // Sắp xếp để 'Việt Nam' lên đầu tiên
        $groupedSanBays = $groupedSanBays->sortBy(function ($list, $key) {
            return $key === 'Việt Nam' ? 0 : 1;
        });

        // Lấy 5 bài viết mới nhất đã xuất bản
        $tinTuc = BaiViet::where('trang_thai', 'xuat_ban')
                         ->latest('ngay_xuat_ban')
                         ->take(6)
                         ->get();

        // ==== BẮT ĐẦU CODE MỚI ====
        // Lấy 7 câu hỏi thuộc danh mục "Câu Hỏi Thường Gặp" (Giả sử id=2)
        $faqs = BaiViet::where('trang_thai', 'xuat_ban')
                       ->where('id_danh_muc', 3) // <-- THAY ID NÀY cho đúng
                       ->orderBy('ngay_tao', 'asc') // Hoặc sắp xếp theo ý bạn
                       ->take(7) // Lấy 7 câu hỏi như ảnh
                       ->get();
        // ==== KẾT THÚC CODE MỚI ====
        // Lấy thời tiết 3 thành phố
        $weatherData = [];
        $cities = SanBay::select('tinh_thanh')->distinct()->pluck('tinh_thanh');

        foreach ($cities as $city) {
            $data = WeatherController::getWeather($city);
            if (isset($data['cod']) && $data['cod'] == 200) {
                 $weatherData[$city] = $data;
            }
        }
        // Nếu API lỗi hoặc không có key, tạo dữ liệu giả để không vỡ giao diện
        if (empty($weatherData)) {
            $weatherData = [
                'Hà Nội' => ['main' => ['temp' => 25, 'humidity' => 80], 'weather' => [['description' => 'Nắng đẹp', 'icon' => '01d']]],
                'TP.HCM' => ['main' => ['temp' => 30, 'humidity' => 70], 'weather' => [['description' => 'Mây rải rác', 'icon' => '02d']]],
            ];
        }



        return view('home', compact('groupedSanBays', 'tinTuc', 'faqs', 'weatherData'));
    }
}
