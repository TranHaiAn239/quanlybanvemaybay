<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KhuyenMai; // <-- Import Model KhuyenMai
use Carbon\Carbon; // <-- Import Carbon để xử lý ngày tháng

class DealHunterController extends Controller
{
    /**
     * Hiển thị trang Săn Vé Rẻ và tìm kiếm khuyến mãi.
     */
    public function index(Request $request)
    {
        // 1. Validate đầu vào (nếu có)
        $request->validate([
            'month' => 'nullable|integer|between:1,12',
            'year' => 'nullable|integer|min:2020|max:2030',
        ]);

        // 2. Lấy giá trị tìm kiếm hoặc dùng giá trị mặc định (tháng/năm hiện tại)
        $selectedMonth = $request->input('month', now()->month);
        $selectedYear = $request->input('year', now()->year);

        // 3. Xây dựng truy vấn
        $query = KhuyenMai::query()->where('trang_thai', 'hieu_luc');

        // 4. Lọc theo tháng/năm
        // Logic: Tìm các khuyến mãi "đang diễn ra" trong tháng đó.
        // Tức là: ngày bắt đầu <= ngày cuối tháng VÀ ngày kết thúc >= ngày đầu tháng
        $startDate = Carbon::create($selectedYear, $selectedMonth, 1)->startOfMonth();
        $endDate = Carbon::create($selectedYear, $selectedMonth, 1)->endOfMonth();

        $query->where('ngay_bat_dau', '<=', $endDate)
              ->where('ngay_ket_thuc', '>=', $startDate);

        // 5. Lấy kết quả và phân trang
        $khuyenMais = $query->orderBy('ngay_bat_dau', 'asc')->paginate(10);

        // 6. Gửi các giá trị đã chọn ra view để giữ lại trên form
        $input = ['month' => $selectedMonth, 'year' => $selectedYear];

        // 7. Trả về view
        return view('deal.index', compact('khuyenMais', 'input'));
    }
}
