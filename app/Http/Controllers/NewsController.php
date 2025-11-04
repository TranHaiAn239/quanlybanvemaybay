<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BaiViet;
use App\Models\DanhMucBaiViet; // <-- Thêm Model này

class NewsController extends Controller
{
    /**
     * Hiển thị trang tin tức (mặc định là danh mục 'tin-tuc').
     */
    public function index()
    {
        // Lấy danh mục mặc định (giả sử slug là 'tin-tuc')
        $currentCategory = DanhMucBaiViet::where('slug', 'tin-tuc')->first();

        // Nếu không tìm thấy, lấy danh mục đầu tiên
        if (!$currentCategory) {
            $currentCategory = DanhMucBaiViet::where('trang_thai', 'hien_thi')->first();
        }

        return $this->loadCategoryPage($currentCategory);
    }

    /**
     * Hiển thị bài viết theo danh mục (từ sidebar).
     */
    public function showCategory($slug)
    {
        $currentCategory = DanhMucBaiViet::where('slug', $slug)
                                         ->where('trang_thai', 'hien_thi')
                                         ->firstOrFail(); // Báo 404 nếu không tìm thấy

        return $this->loadCategoryPage($currentCategory);
    }

    /**
     * Hàm private để tải dữ liệu chung cho cả 2 hàm trên.
     */
    private function loadCategoryPage($currentCategory)
    {
        // 1. Lấy TẤT CẢ danh mục để hiển thị sidebar
        $categories = DanhMucBaiViet::where('trang_thai', 'hien_thi')
                                    ->orderBy('ten_danh_muc', 'asc')
                                    ->get();

        // 2. Lấy các bài viết chỉ thuộc danh mục HIỆN TẠI (phân trang)
        $baiViets = BaiViet::where('id_danh_muc', $currentCategory->id)
                           ->where('trang_thai', 'xuat_ban')
                           ->latest('ngay_xuat_ban')
                           ->paginate(10); // 10 bài/trang

        // 3. Trả về view
        return view('news.index', compact(
            'categories',       // Cho sidebar
            'currentCategory',  // Để biết nút nào đang active
            'baiViets'          // Cho nội dung chính
        ));
    }


    /**
     * Hiển thị chi tiết một bài viết.
     */
    public function show($slug)
    {
        $baiViet = BaiViet::where('slug', $slug)
                          ->where('trang_thai', 'xuat_ban')
                          ->firstOrFail();

        // (Tùy chọn) Tăng lượt xem
        $baiViet->increment('luot_xem');

        return view('news.show', compact('baiViet'));
    }
}
