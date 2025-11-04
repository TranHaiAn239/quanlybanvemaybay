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
        // Lấy toàn bộ sân bay cho form tìm kiếm
        $sanBays = SanBay::orderBy('ten_san_bay', 'asc')->get();

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
        // Trả về view 'home' (home.blade.php) cùng với 2 biến
        return view('home', compact('sanBays', 'tinTuc', 'faqs'));
    }
}
