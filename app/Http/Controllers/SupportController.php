<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\YeuCauHoTro;

class SupportController extends Controller
{
    /**
     * Hiển thị trang hỗ trợ.
     */
    public function index()
    {
        // Chỉ cần trả về view, không cần dữ liệu
        return view('support.index');
    }
    public function storeSupportRequest(Request $request)
    {
        $validated = $request->validate([
            'loai_yeu_cau' => 'required|in:huy_ve,hoan_tien,thong_tin,khac',
            'ho_ten' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'so_dien_thoai' => 'nullable|string|max:20',
            'noi_dung_yeu_cau' => 'required|string',
            'ma_booking' => 'nullable|string|max:50',
            'id_nguoi_dung' => 'nullable|integer|exists:nguoi_dung,id',
        ]);

        // Kiểm tra logic hủy vé
        if ($validated['loai_yeu_cau'] == 'huy_ve' && empty($validated['ma_booking'])) {
            return redirect()->back()->with('error', 'Vui lòng cung cấp Mã Booking để yêu cầu hủy vé.')->withInput();
        }

        // Tạo yêu cầu mới
        YeuCauHoTro::create([
            'id_nguoi_dung' => Auth::id() ?? null,
            'ma_booking' => $validated['ma_booking'],
            'ho_ten' => $validated['ho_ten'],
            'email' => $validated['email'],
            'so_dien_thoai' => $validated['so_dien_thoai'],
            'loai_yeu_cau' => $validated['loai_yeu_cau'],
            'noi_dung_yeu_cau' => $validated['noi_dung_yeu_cau'],
            // Phí hủy vé mặc định
            'phu_phi_huy' => ($validated['loai_yeu_cau'] == 'huy_ve') ? 300000.00 : 0.00,
            'trang_thai' => 'moi'
        ]);

        return redirect()->route('support.index')->with('support_success', 'Yêu cầu hỗ trợ của bạn đã được gửi đi. Chúng tôi sẽ phản hồi qua email sớm nhất!');
    }
}
