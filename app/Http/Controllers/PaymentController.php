<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\HoaDon;
use App\Models\ChiTietHoaDon;
use Illuminate\Support\Facades\DB; // Thêm DB
use Illuminate\Support\Facades\Auth; // Thêm Auth
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingSuccessMail;
use App\Mail\BookingPendingMail;


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
            'phuong_thuc_tt' => 'required|in:momo,zalopay,the_tin_dung,tien_mat,vnpay',
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
                Mail::to($booking->nguoiDung->email)->send(new BookingPendingMail($booking));
                // Chuyển hướng đến trang thành công (với status đặc biệt)
                return redirect()->route('home')->with('payment_success', 'Đặt vé thành công! Vui lòng thanh toán tiền mặt tại văn phòng trong 24 giờ.');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Lỗi tạo đơn hàng tiền mặt: ' . $e->getMessage());
                return redirect()->route('payment.result', ['status' => 'failed', 'booking' => $booking->ma_booking]);
            }
        }

        // ----- TRƯỜNG HỢP 2: THANH TOÁN ONLINE (Momo, ZaloPay, Thẻ) -----

        // A. NẾU LÀ VNPAY
        if ($phuongThuc === 'vnpay') {
            // Gọi hàm tạo URL VNPay (Viết ở dưới)
            return $this->createVNPayUrl($booking);
        }

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
                Mail::to($booking->nguoiDung->email)->send(new BookingSuccessMail($booking));
                return redirect()->route('home')->with('payment_success', 'Thanh toán thành công! Vé đã được gửi tới email của bạn.');

            } catch (\Exception $e) {
                DB::rollBack();
                \Log::error('Lỗi thanh toán online: ' . $e->getMessage());
                return redirect()->route('payment.show', ['maBooking' => $booking->ma_booking])
                                 ->with('payment_error', 'Lỗi CSDL: ' . $e->getMessage());
            }
        }
    }

    public function createVNPayUrl($booking)
    {
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = "http://127.0.0.1:8000/vnpay-done";
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');

        $vnp_TxnRef = $booking->ma_booking;
        $vnp_OrderInfo = "Thanh toan ve may bay";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $booking->tong_tien * 100; // VNPay yêu cầu nhân 100
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        // 1. Lấy dữ liệu
        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = $request->all();

        unset($inputData['vnp_SecureHash']);
        unset($inputData['vnp_SecureHashType']);

        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        // --- GHI LOG ĐỂ DEBUG ---
        \Log::info('--- VNPAY RETURN DEBUG ---');
        \Log::info('Mã booking: ' . $request->vnp_TxnRef);
        \Log::info('Mã phản hồi (ResponseCode): ' . $request->vnp_ResponseCode);
        \Log::info('Hash tính toán: ' . $secureHash);
        \Log::info('Hash nhận được: ' . $vnp_SecureHash);

        // 2. Kiểm tra Checksum
        if ($secureHash == $vnp_SecureHash) {
            $maBooking = $request->vnp_TxnRef;
            $booking = Booking::where('ma_booking', $maBooking)->first();

            if ($request->vnp_ResponseCode == '00') {
                // --- THANH TOÁN THÀNH CÔNG ---
                if ($booking) {
                    if ($booking->trang_thai == 'cho_thanh_toan') {
                        try {
                            DB::beginTransaction();

                            // Cập nhật trạng thái
                            $booking->update([
                                'trang_thai' => 'da_thanh_toan',
                                'phuong_thuc_tt' => 'vnpay'
                            ]);
                            $booking->ves()->update(['trang_thai' => 'da_thanh_toan']);

                            // Tạo hóa đơn
                            $hoaDon = HoaDon::create([
                                'id_booking' => $booking->id,
                                'tong_tien' => $booking->tong_tien,
                                'trang_thai' => 'da_thanh_toan',
                                'phuong_thuc_tt' => 'vnpay',
                            ]);

                            foreach ($booking->ves as $ve) {
                                ChiTietHoaDon::create([
                                    'id_hoa_don' => $hoaDon->id,
                                    'id_ve' => $ve->id,
                                    'so_luong' => 1,
                                    'gia' => $ve->gia_ve + $ve->gia_ghe + $ve->gia_hanh_ly,
                                ]);
                            }

                            DB::commit();
                            \Log::info('-> Cập nhật DB thành công!'); // Log thành công
                            return redirect()->route('home')->with('payment_success', 'Thanh toán VNPay thành công!');

                        } catch (\Exception $e) {
                            DB::rollBack();
                            \Log::error('-> Lỗi cập nhật DB: ' . $e->getMessage()); // Log lỗi SQL
                            return redirect()->route('home')->with('error', 'Lỗi hệ thống khi cập nhật đơn hàng.');
                        }
                    } else {
                        \Log::info('-> Đơn hàng đã được xử lý trước đó.');
                        return redirect()->route('home')->with('payment_success', 'Giao dịch đã được xử lý.');
                    }
                } else {
                    \Log::error('-> Không tìm thấy Booking ID: ' . $maBooking);
                    return redirect()->route('home')->with('error', 'Không tìm thấy đơn hàng.');
                }
            } else {
                \Log::info('-> Thanh toán thất bại. Mã lỗi: ' . $request->vnp_ResponseCode);
                return redirect()->route('payment.show', $maBooking)->with('payment_error', 'Thanh toán thất bại hoặc bị hủy.');
            }
        } else {
            \Log::error('-> Sai chữ ký (Checksum failed)!');
            return redirect()->route('home')->with('error', 'Chữ ký bảo mật không hợp lệ!');
        }
    }
}
