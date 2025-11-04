<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\HoaDon;
use App\Models\ChiTietHoaDon;
use Illuminate\Support\Facades\DB; // Thêm DB
use Illuminate\Support\Facades\Auth; // Thêm Auth

class PaymentController extends Controller
{
    /**
     * Hiển thị trang chọn phương thức thanh toán.
     */
    public function show($maBooking)
    {
        // Tìm booking còn chờ thanh toán
        $booking = Booking::where('ma_booking', $maBooking)
                          ->where('trang_thai', 'cho_thanh_toan')
                          ->where('id_nguoi_dung', Auth::id()) // Đảm bảo đúng là của user
                          ->firstOrFail(); // Không tìm thấy sẽ báo 404

        // Trả về view 'payment.index' (payment/index.blade.php)
        return view('payment.index', compact('booking'));
    }

    /**
     * Xử lý logic thanh toán.
     * !! GHI CHÚ QUAN TRỌNG: Đây là logic GIẢ LẬP thanh toán thành công.
     */
/**
     * Xử lý logic thanh toán.
     * CẬP NHẬT: Xử lý riêng cho 'tien_mat'
     */
    public function process(Request $request)
    {
        // 1. Validate
        $request->validate([
            'ma_booking' => 'required|string|exists:booking,ma_booking',
            'phuong_thuc_tt' => 'required|in:momo,zalopay,the_tin_dung,tien_mat',
        ]);

        // 2. Tìm booking
        $booking = Booking::where('ma_booking', $request->ma_booking)
                          ->where('trang_thai', 'cho_thanh_toan')
                          ->where('id_nguoi_dung', Auth::id())
                          ->first();

        if (!$booking) {
            return redirect()->route('home')->with('error', 'Đơn hàng không hợp lệ hoặc đã được xử lý.');
        }

        $phuongThuc = $request->phuong_thuc_tt;

        // ===============================================
        // BẮT ĐẦU LOGIC MỚI
        // ===============================================

        // ----- TRƯỜNG HỢP 1: THANH TOÁN TIỀN MẶT -----
        if ($phuongThuc === 'tien_mat') {
            try {
                DB::beginTransaction();

                // 3. Cập nhật Booking (CHỈ CẬP NHẬT PHƯƠNG THỨC, TRẠNG THÁI VẪN LÀ 'cho_thanh_toan')
                $booking->update([
                    'phuong_thuc_tt' => $phuongThuc
                ]);

                // 4. Vé (VẪN LÀ 'cho_xac_nhan')
                // $booking->ves()->update(['trang_thai' => 'cho_xac_nhan']); // Không cần, vì nó đã là 'cho_xac_nhan'

                // 5. Tạo Hóa Đơn (Với trạng thái 'chua_thanh_toan')
                $hoaDon = HoaDon::create([
                    'id_booking' => $booking->id,
                    'tong_tien' => $booking->tong_tien,
                    'trang_thai' => 'chua_thanh_toan', // <-- KHÁC BIỆT
                    'phuong_thuc_tt' => $phuongThuc,
                ]);

                // 6. Tạo Chi Tiết Hóa Đơn (Vẫn tạo để giữ chỗ)
                foreach ($booking->ves as $ve) {
                    ChiTietHoaDon::create([
                        'id_hoa_don' => $hoaDon->id,
                        'id_ve' => $ve->id,
                        'so_luong' => 1,
                        'gia' => $ve->gia_ve + $ve->gia_hanh_ly,
                    ]);
                }

                DB::commit();

                // Gửi Email YÊU CẦU thanh toán

                // Chuyển hướng đến trang thành công (với status đặc biệt)
                return redirect()->route('home')->with('payment_success', 'Đặt vé thành công! Vui lòng thanh toán tiền mặt tại văn phòng trong 24 giờ.');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Lỗi tạo đơn hàng tiền mặt: ' . $e->getMessage());
                return redirect()->route('payment.result', ['status' => 'failed', 'booking' => $booking->ma_booking]);
            }
        }

        // ----- TRƯỜNG HỢP 2: THANH TOÁN ONLINE (Momo, ZaloPay, Thẻ) -----
        // (Chúng ta giả lập là thành công)
        $paymentSuccess = true;

        if ($paymentSuccess) {
            try {
                DB::beginTransaction();

                // 3. Cập nhật Booking (Thành 'da_thanh_toan')
                $booking->update([
                    'trang_thai' => 'da_thanh_toan',
                    'phuong_thuc_tt' => $phuongThuc
                ]);

                // 4. Cập nhật Vé (Thành 'da_thanh_toan')
                $booking->ves()->update(['trang_thai' => 'da_thanh_toan']);

                // 5. Tạo Hóa Đơn (Thành 'da_thanh_toan')
                $hoaDon = HoaDon::create([
                    'id_booking' => $booking->id,
                    'tong_tien' => $booking->tong_tien,
                    'trang_thai' => 'da_thanh_toan',
                    'phuong_thuc_tt' => $phuongThuc,
                ]);

                // 6. Tạo Chi Tiết Hóa Đơn
                foreach ($booking->ves as $ve) {
                    ChiTietHoaDon::create([
                        'id_hoa_don' => $hoaDon->id,
                        'id_ve' => $ve->id,
                        'so_luong' => 1,
                        'gia' => $ve->gia_ve + $ve->gia_hanh_ly,
                    ]);
                }

                DB::commit();

                // Gửi Email XÁC NHẬN VÉ

                return redirect()->route('home')->with('payment_success', 'Thanh toán thành công! Vé đã được gửi tới email của bạn.');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Lỗi thanh toán online: ' . $e->getMessage());
                return redirect()->route('payment.show', ['maBooking' => $booking->ma_booking])
                                 ->with('payment_error', 'Lỗi CSDL: ' . $e->getMessage());
            }
        }
    }
}
