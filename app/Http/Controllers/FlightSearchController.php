<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChuyenBay;

class FlightSearchController extends Controller
{
    /**
     * Tìm kiếm chuyến bay dựa trên request.
     */
public function search(Request $request)
    {
        // 1. Validate dữ liệu đầu vào
        $request->validate([
            'id_san_bay_di' => 'required|integer|exists:san_bay,id',
            'id_san_bay_den' => 'required|integer|exists:san_bay,id|different:id_san_bay_di',
            'ngay_di' => 'required|date|after_or_equal:today',
            'ngay_ve' => 'nullable|date|after_or_equal:ngay_di', // Thêm validate cho ngày về
        ]);

        $isRoundTrip = $request->filled('ngay_ve');

        // 2. Tìm chuyến bay ĐI
        $queryDi = ChuyenBay::query()
            ->where('id_san_bay_di', $request->id_san_bay_di)
            ->where('id_san_bay_den', $request->id_san_bay_den)
            ->whereDate('thoi_gian_di', $request->ngay_di)
            ->where('trang_thai', 'dang_ban');

        $chuyenBaysDi = $queryDi->with(['sanBayDi', 'sanBayDen', 'mayBay'])
                                ->orderBy('thoi_gian_di', 'asc')
                                ->get();

        $chuyenBaysVe = collect(); // Khởi tạo collection rỗng

        // 3. Nếu là khứ hồi, tìm luôn chuyến VỀ
        if ($isRoundTrip) {
            $queryVe = ChuyenBay::query()
                // ĐẢO NGƯỢC điểm đi và điểm đến
                ->where('id_san_bay_di', $request->id_san_bay_den)
                ->where('id_san_bay_den', $request->id_san_bay_di)
                ->whereDate('thoi_gian_di', $request->ngay_ve)
                ->where('trang_thai', 'dang_ban');

            $chuyenBaysVe = $queryVe->with(['sanBayDi', 'sanBayDen', 'mayBay'])
                                    ->orderBy('thoi_gian_di', 'asc')
                                    ->get();
        }

        // 4. Trả về view
        return view('flight.search-results', [
            'chuyenBaysDi' => $chuyenBaysDi,
            'chuyenBaysVe' => $chuyenBaysVe, // Gửi cả chuyến về
            'isRoundTrip' => $isRoundTrip,  // Gửi cờ khứ hồi
            'input' => $request->all()       // Gửi thông tin tìm kiếm
        ]);
    }
}
