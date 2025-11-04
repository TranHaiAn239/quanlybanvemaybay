<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\ChuyenBay;
use App\Models\Booking;
use App\Models\Ve;
use App\Models\ThongTinNguoiDi;
use App\Models\KhuyenMai;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function create(Request $request) // <-- Thay đổi ở đây
    {
        // 1. Validate ID chuyến bay
        $request->validate([
            'departure_id' => 'required|integer|exists:chuyen_bay,id',
            'return_id' => 'nullable|integer|exists:chuyen_bay,id',
        ]);

        $isRoundTrip = $request->filled('return_id');

        // 2. Tải chuyến bay
        $departureFlight = ChuyenBay::with(['sanBayDi', 'sanBayDen', 'mayBay'])
                                    ->findOrFail($request->query('departure_id'));

        $returnFlight = null;
        if ($isRoundTrip) {
            $returnFlight = ChuyenBay::with(['sanBayDi', 'sanBayDen', 'mayBay'])
                                    ->findOrFail($request->query('return_id'));
        }

        // 3. Lấy số lượng hành khách
        $passengers = [
            'nguoi_lon' => (int)($request->query('nguoi_lon') ?? 1),
            'tre_em' => (int)($request->query('tre_em') ?? 0),
            'em_be' => (int)($request->query('em_be') ?? 0),
        ];
        $passengers['tong_so'] = $passengers['nguoi_lon'] + $passengers['tre_em'] + $passengers['em_be'];

        // 4. Tính toán giá
        $gia_goc_nguoi_lon = $departureFlight->gia_ve;
        $gia_goc_tre_em = $gia_goc_nguoi_lon * 0.75;
        $gia_goc_em_be = $gia_goc_nguoi_lon * 0.10;

        $tong_tien_ve_di = ($gia_goc_nguoi_lon * $passengers['nguoi_lon']) +
                        ($gia_goc_tre_em * $passengers['tre_em']) +
                        ($gia_goc_em_be * $passengers['em_be']);

        $tong_tien_ve_ve = 0;
        if ($isRoundTrip) {
            // Giả sử giá vé khứ hồi tính theo giá vé lượt đi
            $gia_goc_nguoi_lon_ve = $returnFlight->gia_ve;
            $gia_goc_tre_em_ve = $gia_goc_nguoi_lon_ve * 0.75;
            $gia_goc_em_be_ve = $gia_goc_nguoi_lon_ve * 0.10;

            $tong_tien_ve_ve = ($gia_goc_nguoi_lon_ve * $passengers['nguoi_lon']) +
                            ($gia_goc_tre_em_ve * $passengers['tre_em']) +
                            ($gia_goc_em_be_ve * $passengers['em_be']);
        }

        $tong_tien_ve = $tong_tien_ve_di + $tong_tien_ve_ve;
        $tong_thue = $tong_tien_ve * 0.08;

        // Tổng cộng ban đầu (chưa giảm giá, chưa hành lý)
        $tong_cong_ban_dau = $tong_tien_ve + $tong_thue;

        // 5. Gói hành lý (Giữ nguyên)
        $baggage_options = [
            ['weight' => 0, 'price' => 0, 'text' => 'Không mang hành lý'],
            ['weight' => 20, 'price' => 216000, 'text' => '20kg (216,000 VND)'],
            ['weight' => 30, 'price' => 324000, 'text' => '30kg (324,000 VND)'],
            ['weight' => 40, 'price' => 432000, 'text' => '40kg (432,000 VND)'],
            ['weight' => 50, 'price' => 594000, 'text' => '50kg (594,000 VND)'],
            ['weight' => 60, 'price' => 702000, 'text' => '60kg (702,000 VND)'],
            ['weight' => 70, 'price' => 810000, 'text' => '70kg (810,000 VND)'],
        ];

        $price_breakdown = [
            'tong_tien_ve' => $tong_tien_ve,
            'tong_thue' => $tong_thue,
            'tong_cong_ban_dau' => $tong_cong_ban_dau,
            'isDiscountApplied' => false,// Biến mới cho mã khuyến mãi
        ];

        // 6. Trả về view
        return view('booking.create', compact(
            'departureFlight', // Gửi chuyến đi
            'returnFlight',    // Gửi chuyến về (có thể null)
            'isRoundTrip',     // Gửi cờ
            'passengers',
            'price_breakdown',
            'baggage_options'
        ));
    }
// ... (Đảm bảo 'use' đầy đủ các Model và DB, Str, Auth) ...

    public function store(Request $request)
    {
        // 1. Validate request cơ bản
        $request->validate([
            'id_chuyen_bay_di' => 'required|exists:chuyen_bay,id',
            'id_chuyen_bay_ve' => 'nullable|exists:chuyen_bay,id',
            'form_data' => 'required|json', // Chỉ nhận 1 input JSON
        ]);

        // 2. Giải mã JSON
        $formData = json_decode($request->form_data, true);

        // 3. (FIX) Validate dữ liệu BÊN TRONG JSON
        $validator = Validator::make($formData, [
            'passengers_data' => 'required|array|min:1',
            'passengers_data.*.ho_ten' => 'required|string|max:100', // Đảm bảo họ tên không trống
            'passengers_data.*.type' => 'required|in:nguoi_lon,tre_em,em_be',
            // Bạn có thể thêm validate cho email, sdt nếu muốn
        ], [
            // Thông báo lỗi tiếng Việt
            'passengers_data.*.ho_ten.required' => 'Vui lòng nhập họ tên cho tất cả hành khách.',
        ]);

        if ($validator->fails()) {
            // Nếu validate fail, quay lại với lỗi
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // 4. Lấy dữ liệu đã validate (an toàn)
        $validatedData = $validator->validated();
        $passengers_data = $validatedData['passengers_data'];

        $chuyenBayDi = ChuyenBay::findOrFail($request->id_chuyen_bay_di);
        $chuyenBayVe = $request->filled('id_chuyen_bay_ve') ? ChuyenBay::findOrFail($request->id_chuyen_bay_ve) : null;
        $isRoundTrip = (bool)$chuyenBayVe;

        // 5. Định nghĩa giá (Copy y hệt từ hàm create)
        $baggage_price_list = [ 0 => 0, 216000 => 216000, 324000 => 324000, 432000 => 432000, 594000 => 594000, 702000 => 702000, 810000 => 810000 ];

        // 6. Khởi tạo tổng tiền
        $tong_tien_ve_thuc_te = 0;
        $tong_tien_ghe_thuc_te = 0;
        $tong_tien_thue_thuc_te = 0;
        $tong_tien_hanh_ly_thuc_te = 0;
        $danh_sach_hanh_khach = [];

        // 7. Lặp qua request ĐỂ TÍNH TỔNG TIỀN (Server-side)
        foreach ($passengers_data as $index => $passenger) {
            $loai = $passenger['type'];
            $loai_ghe = $passenger['seat_type'] ?? 'phổ thông';

            // --- Giá vé (Server-side) ---
            $gia_goc_di = $chuyenBayDi->gia_ve;
            if ($loai === 'tre_em') $gia_goc_di *= 0.75;
            if ($loai === 'em_be') $gia_goc_di *= 0.10;

            $gia_goc_ve = 0;
            if ($isRoundTrip) {
                $gia_goc_ve = $chuyenBayVe->gia_ve;
                if ($loai === 'tre_em') $gia_goc_ve *= 0.75;
                if ($loai === 'em_be') $gia_goc_ve *= 0.10;
            }
            $tong_gia_goc_ve = $gia_goc_di + $gia_goc_ve;
            $tong_tien_ve_thuc_te += $tong_gia_goc_ve;

            // --- Giá ghế (Server-side) ---
            $gia_ghe = 0;
            if ($loai_ghe === 'thương gia') {
                $gia_ghe = $tong_gia_goc_ve * 0.05;
            } else if ($loai_ghe === 'hạng nhất') {
                $gia_ghe = $tong_gia_goc_ve * 0.10;
            }
            $tong_tien_ghe_thuc_te += $gia_ghe;

            // --- Giá hành lý (Server-side) ---
            $gia_hanh_ly_key = $passenger['baggage_fee'] ?? 0;
            $gia_hanh_ly = $baggage_price_list[$gia_hanh_ly_key] ?? 0;
            $tong_tien_hanh_ly_thuc_te += $gia_hanh_ly;

            // Lưu thông tin (Lấy từ JSON)
            $danh_sach_hanh_khach[$index] = [
                'ho_ten' => $passenger['ho_ten'],
                'so_dien_thoai' => $passenger['so_dien_thoai'] ?? null,
                'email' => $passenger['email'] ?? null,
                'dia_chi' => $passenger['dia_chi'] ?? null,
                'ghi_chu' => $passenger['ghi_chu'] ?? null,
                'loai' => $loai,
                'loai_ghe' => $loai_ghe,
                'gia_ve_di' => $gia_goc_di,
                'gia_ve_ve' => $gia_goc_ve,
                'gia_ghe' => $gia_ghe,
                'gia_hanh_ly_di' => $gia_hanh_ly,
            ];
        }

        // 8. TÍNH TỔNG CỘNG, THUẾ, GIẢM GIÁ (Server-side)
        $tong_ve_va_ghe = $tong_tien_ve_thuc_te + $tong_tien_ghe_thuc_te;
        $tong_thue = $tong_ve_va_ghe * 0.08;
        $tong_cong_truoc_giam = $tong_ve_va_ghe + $tong_thue + $tong_tien_hanh_ly_thuc_te;

        $giam_gia_khu_hoi = $formData['roundtrip_discount'] ?? 0;

        $giam_gia_km = 0;
        $id_khuyen_mai = null;
        if (!empty($formData['promo_code'])) {
            $khuyenMai = \App\Models\KhuyenMai::where('ma_khuyen_mai', $formData['promo_code'])
                                    ->where('trang_thai', 'hieu_luc')
                                    ->first();

            if ($khuyenMai) {
                $id_khuyen_mai = $khuyenMai->id;
                $baseForPromo = $tong_cong_truoc_giam - $giam_gia_khu_hoi;

                if ($khuyenMai->loai_gia_tri === 'phan_tram') {
                    $giam_gia_km = $baseForPromo * ($khuyenMai->gia_tri / 100);
                } else {
                    $giam_gia_km = min($baseForPromo, $khuyenMai->gia_tri);
                }
            }
        }

        $tong_giam_gia = $giam_gia_khu_hoi + $giam_gia_km;
        $tong_tien_cuoi_cung = $tong_cong_truoc_giam - $tong_giam_gia;

        $booking = null;

        // 9. Bắt đầu Transaction
        try {
            DB::beginTransaction();

            // 10. Tạo Booking
            $booking = Booking::create([
                'id_nguoi_dung' => Auth::id(),
                'ma_booking' => 'VMB' . strtoupper(Str::random(8)),
                'tong_tien' => $tong_tien_cuoi_cung,
                'id_khuyen_mai' => $id_khuyen_mai,
                'giam_gia' => $tong_giam_gia,
                'trang_thai' => 'cho_thanh_toan',
            ]);

            // 11. Lặp lại danh sách hành khách ĐỂ LƯU VÉ
            foreach ($danh_sach_hanh_khach as $passenger) {

                $thue_ve_di = $passenger['gia_ve_di'] * 0.08;
                $thue_ve_ve = $passenger['gia_ve_ve'] * 0.08;
                $gia_ghe_ve = $passenger['gia_ghe'];

                // --- TẠO VÉ LƯỢT ĐI ---
                $ve_di = Ve::create([
                    'id_booking' => $booking->id,
                    'id_chuyen_bay' => $chuyenBayDi->id,
                    'loai_hanh_khach' => $passenger['loai'],
                    'loai_ghe' => $passenger['loai_ghe'],
                    'so_ghe' => null,
                    'gia_ve' => $passenger['gia_ve_di'] + $thue_ve_di,
                    'gia_ghe' => $gia_ghe_ve,
                    'gia_hanh_ly' => $passenger['gia_hanh_ly_di'],
                    'trang_thai' => 'cho_xac_nhan',
                ]);
                ThongTinNguoiDi::create(['id_ve' => $ve_di->id] + $passenger);

                // --- TẠO VÉ LƯỢT VỀ (nếu có) ---
                if ($isRoundTrip && $chuyenBayVe) {
                    $ve_ve = Ve::create([
                        'id_booking' => $booking->id,
                        'id_chuyen_bay' => $chuyenBayVe->id,
                        'loai_hanh_khach' => $passenger['loai'],
                        'loai_ghe' => $passenger['loai_ghe'],
                        'so_ghe' => null,
                        'gia_ve' => $passenger['gia_ve_ve'] + $thue_ve_ve,
                        'gia_ghe' => 0,
                        'gia_hanh_ly' => 0,
                        'trang_thai' => 'cho_xac_nhan',
                    ]);
                    ThongTinNguoiDi::create(['id_ve' => $ve_ve->id] + $passenger);
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi tạo booking (JSON): ' . $e->getMessage());
            // (FIX) Trả về lỗi chi tiết cho session 'error'
            return redirect()->back()->with('error', 'Lỗi CSDL: ' . $e->getMessage());
        }

        // 12. Chuyển hướng đến trang thanh toán
        return redirect()->route('payment.show', ['maBooking' => $booking->ma_booking]);
    }
}
