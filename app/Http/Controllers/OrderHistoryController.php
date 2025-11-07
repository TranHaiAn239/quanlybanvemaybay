<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Dùng để lấy người dùng
use Illuminate\Support\Facades\DB;   // Dùng cho Transaction
use App\Models\Booking; // Dùng để hủy

class OrderHistoryController extends Controller
{
    /**
     * Hiển thị trang lịch sử đơn hàng của người dùng.
     */
    public function index()
    {
        // Lấy ID người dùng đang đăng nhập
        $userId = Auth::id();

        // Tải tất cả booking của người dùng đó
        // Sắp xếp mới nhất lên đầu
        // Eager load (tải kèm) các vé và thông tin chuyến bay liên quan
        $bookings = Booking::where('id_nguoi_dung', $userId)
                        ->with([
                            'ves.chuyenBay.sanBayDi',
                            'ves.chuyenBay.sanBayDen'
                        ])
                        ->orderBy('ngay_dat', 'desc')
                        ->paginate(10); // Phân trang

        // Trả về view
        return view('order-history.index', compact('bookings'));
    }

    /**
     * Xử lý yêu cầu hủy vé (hủy đơn booking).
     */
    public function cancel(Booking $booking)
    {
        // --- BẢO MẬT ---
        // 1. Kiểm tra xem booking này có đúng là của người dùng đang đăng nhập không
        if ($booking->id_nguoi_dung !== Auth::id()) {
            return redirect()->route('order.history')->with('error', 'Bạn không có quyền hủy đơn hàng này.');
        }

        // --- LOGIC NGHIỆP VỤ ---
        // 2. Chỉ cho phép hủy khi trạng thái là "Chờ thanh toán"
        if ($booking->trang_thai !== 'cho_thanh_toan') {
            return redirect()->route('order.history')->with('error', 'Không thể hủy đơn hàng đã thanh toán hoặc đã bị hủy.');
        }

        // 3. Tiến hành hủy (Dùng Transaction để đảm bảo an toàn)
        try {
            DB::beginTransaction();

            // Cập nhật trạng thái booking
            $booking->update([
                'trang_thai' => 'huy',
                'phuong_thuc_tt' => 'khong'
            ]);

            // Cập nhật trạng thái tất cả vé liên quan
            $booking->ves()->update(['trang_thai' => 'huy']);

            // Cập nhật hóa đơn (nếu có)
            if ($booking->hoaDon) {
                $booking->hoaDon->update(['trang_thai' => 'huy']);
            }

            DB::commit();

            return redirect()->route('order.history')->with('success', 'Đã hủy đơn hàng ' . $booking->ma_booking . ' thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi hủy vé: ' . $e->getMessage());
            return redirect()->route('order.history')->with('error', 'Có lỗi xảy ra, không thể hủy đơn hàng. Vui lòng thử lại.');
        }
    }

    public function printInvoice(Booking $booking)
    {
        // --- BẢO MẬT ---
        // 1. Kiểm tra xem booking này có đúng là của người dùng đang đăng nhập không
        if ($booking->id_nguoi_dung !== Auth::id()) {
            abort(403, 'Bạn không có quyền truy cập hóa đơn này.');
        }

        // --- LOGIC NGHIỆP VỤ ---
        // 2. Chỉ cho phép in khi trạng thái là "Đã thanh toán"
        if ($booking->trang_thai !== 'da_thanh_toan') {
            return redirect()->route('order.history')->with('error', 'Không thể in hóa đơn cho đơn hàng chưa thanh toán.');
        }

        // 3. Tải tất cả dữ liệu cần thiết cho hóa đơn
        $booking->load([
            'nguoiDung', // Thông tin người đặt
            'hoaDon',    // Thông tin hóa đơn (Mã HĐ, ngày...)
            'ves.chuyenBay.sanBayDi', // Chi tiết vé: Chuyến bay
            'ves.chuyenBay.sanBayDen',
            'ves.thongTinNguoiDi' // Chi tiết vé: Tên hành khách
        ]);

        // 4. Trả về một view 'invoice.print' (chúng ta sẽ tạo ở Bước 4)
        return view('invoice.print', compact('booking'));
    }
}
