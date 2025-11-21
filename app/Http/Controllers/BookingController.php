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
        // 1. Validate dữ liệu cơ bản
        $request->validate([
            'id_chuyen_bay_di' => 'required|exists:chuyen_bay,id',
            'id_chuyen_bay_ve' => 'nullable|exists:chuyen_bay,id',
            'form_data' => 'required|json',
        ]);

        $chuyenBayDi = ChuyenBay::findOrFail($request->id_chuyen_bay_di);
        $chuyenBayVe = $request->filled('id_chuyen_bay_ve') ? ChuyenBay::findOrFail($request->id_chuyen_bay_ve) : null;
        $isRoundTrip = (bool)$chuyenBayVe;

        // Giải mã JSON từ Alpine.js
        $formData = json_decode($request->form_data, true);
        $passengers_data = $formData['passengers_data'];

        // 2. Định nghĩa giá hành lý (Lookup Table)
        $baggage_price_list = [
            0 => 0,
            216000 => 216000, 324000 => 324000, 432000 => 432000,
            594000 => 594000, 702000 => 702000, 810000 => 810000
        ];

        // FIX: Định nghĩa Map loại ghế (Tiếng Việt có dấu -> Không dấu)
        $seat_map = [
            'phổ thông' => 'pho_thong',
            'thương gia' => 'thuong_gia',
            'hạng nhất' => 'hang_nhat',
            // Dự phòng trường hợp gửi lên không dấu sẵn
            'pho_thong' => 'pho_thong',
            'thuong_gia' => 'thuong_gia',
            'hang_nhat' => 'hang_nhat',
        ];

        // 3. Khởi tạo tổng tiền
        $tong_tien_ve_thuc_te = 0;
        $tong_tien_ghe_thuc_te = 0;
        $tong_tien_thue_thuc_te = 0;
        $tong_tien_hanh_ly_thuc_te = 0;

        $danh_sach_hanh_khach = [];

        // 4. Lặp qua dữ liệu để TÍNH TOÁN
        foreach ($passengers_data as $index => $passenger) {

            // FIX: Lấy loại hành khách từ JSON (nguoi_lon, tre_em, em_be)
            $loai_khach = $passenger['type'];

            // FIX: Lấy loại ghế và Chuyển sang không dấu
            $raw_seat_type = $passenger['seat_type'] ?? 'phổ thông';
            if ($loai_khach === 'em_be') {
                $loai_ghe_db = 'pho_thong'; // Em bé luôn phổ thông
            } else {
                $loai_ghe_db = $seat_map[$raw_seat_type] ?? 'pho_thong';
            }

            // --- A. TÍNH GIÁ VÉ GỐC (Base Fare) ---
            $gia_goc_di = $chuyenBayDi->gia_ve;
            if ($loai_khach === 'tre_em') $gia_goc_di *= 0.75;
            if ($loai_khach === 'em_be') $gia_goc_di *= 0.10;

            $gia_goc_ve = 0;
            if ($isRoundTrip) {
                $gia_goc_ve = $chuyenBayVe->gia_ve;
                if ($loai_khach === 'tre_em') $gia_goc_ve *= 0.75;
                if ($loai_khach === 'em_be') $gia_goc_ve *= 0.10;
            }

            // --- B. TÍNH GIÁ GHẾ (Seat Fee) - Lưu riêng ---
            $gia_ghe_di = 0;
            $gia_ghe_ve = 0;

            // Tính % tăng thêm dựa trên giá gốc
            if ($loai_ghe_db === 'thuong_gia') {
                $gia_ghe_di = $gia_goc_di * 0.05; // 5%
                if ($isRoundTrip) $gia_ghe_ve = $gia_goc_ve * 0.05;
            } elseif ($loai_ghe_db === 'hang_nhat') {
                $gia_ghe_di = $gia_goc_di * 0.10; // 10%
                if ($isRoundTrip) $gia_ghe_ve = $gia_goc_ve * 0.10;
            }

            // --- C. TÍNH GIÁ HÀNH LÝ (Baggage Fee) - Lưu riêng ---
            $gia_hanh_ly_key = $passenger['baggage_fee'] ?? 0;
            $gia_hanh_ly = $baggage_price_list[$gia_hanh_ly_key] ?? 0;

            // --- D. TÍNH THUẾ (Tax) ---
            // Thuế = 8% của (Vé + Ghế)
            $thue_di = ($gia_goc_di + $gia_ghe_di) * 0.08;
            $thue_ve = ($isRoundTrip) ? ($gia_goc_ve + $gia_ghe_ve) * 0.08 : 0;

            // Cộng dồn vào tổng Booking
            $tong_tien_ve_thuc_te += ($gia_goc_di + $gia_goc_ve);
            $tong_tien_ghe_thuc_te += ($gia_ghe_di + $gia_ghe_ve);
            $tong_tien_thue_thuc_te += ($thue_di + $thue_ve);
            $tong_tien_hanh_ly_thuc_te += $gia_hanh_ly;

            // Lưu dữ liệu đã tính toán vào mảng tạm để dùng ở bước Tạo Vé
            $danh_sach_hanh_khach[$index] = [
                'info' => [ // Thông tin cá nhân
                    'ho_ten' => $passenger['ho_ten'],
                    'so_dien_thoai' => $passenger['so_dien_thoai'] ?? null,
                    'email' => $passenger['email'] ?? null,
                    'dia_chi' => $passenger['dia_chi'] ?? null,
                    'ghi_chu' => $passenger['ghi_chu'] ?? null,
                ],
                'data' => [ // Thông tin vé
                    'loai_hanh_khach' => $loai_khach, // FIX: Lưu đúng loại (nguoi_lon/tre_em...)
                    'loai_ghe' => $loai_ghe_db,       // FIX: Lưu không dấu (pho_thong...)

                    // Chuyến đi
                    'gia_ve_di' => $gia_goc_di + $thue_di, // Lưu (Giá gốc + Thuế) vào cột gia_ve
                    'gia_ghe_di' => $gia_ghe_di,           // FIX: Lưu riêng tiền ghế
                    'gia_hanh_ly_di' => $gia_hanh_ly,      // FIX: Lưu riêng tiền hành lý

                    // Chuyến về
                    'gia_ve_ve' => $gia_goc_ve + $thue_ve,
                    'gia_ghe_ve' => $gia_ghe_ve,
                    'gia_hanh_ly_ve' => 0, // Hành lý chỉ tính 1 lần ở vé đi (hoặc chia đôi tùy bạn)
                ]
            ];
        }

        // 5. TÍNH TỔNG CỘNG VÀ GIẢM GIÁ
        $tong_cong_truoc_giam = $tong_tien_ve_thuc_te + $tong_tien_ghe_thuc_te + $tong_tien_thue_thuc_te + $tong_tien_hanh_ly_thuc_te;

        // Xử lý giảm giá
        $giam_gia_khu_hoi = $formData['roundtrip_discount'] ?? 0;
        $giam_gia_km = 0;
        $id_khuyen_mai = null;
        if (!empty($formData['promo_code'])) {
            $khuyenMai = \App\Models\KhuyenMai::where('ma_khuyen_mai', $formData['promo_code'])->first();
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
        $tong_tien_cuoi_cung = max(0, $tong_cong_truoc_giam - $tong_giam_gia);

        // 6. LƯU VÀO CSDL (DB Transaction)
        try {
            DB::beginTransaction();

            // Tạo Booking
            $booking = Booking::create([
                'id_nguoi_dung' => Auth::id(),
                'ma_booking' => 'VMB' . strtoupper(Str::random(8)),
                'tong_tien' => $tong_tien_cuoi_cung,
                'id_khuyen_mai' => $id_khuyen_mai,
                'giam_gia' => $tong_giam_gia,
                'trang_thai' => 'cho_thanh_toan',
                'phuong_thuc_tt' => 'khong',
            ]);

            // Tạo Vé và Thông tin người đi
            foreach ($danh_sach_hanh_khach as $item) {
                $info = $item['info'];
                $data = $item['data'];

                // --- VÉ LƯỢT ĐI ---
                $ve_di = Ve::create([
                    'id_booking' => $booking->id,
                    'id_chuyen_bay' => $chuyenBayDi->id,
                    'loai_hanh_khach' => $data['loai_hanh_khach'], // FIX: Lưu đúng loại
                    'loai_ghe' => $data['loai_ghe'],               // FIX: Lưu không dấu
                    'so_ghe' => null,
                    'gia_ve' => $data['gia_ve_di'],                // Giá vé + thuế
                    'gia_ghe' => $data['gia_ghe_di'],              // FIX: Lưu giá ghế riêng
                    'gia_hanh_ly' => $data['gia_hanh_ly_di'],      // FIX: Lưu giá hành lý riêng
                    'trang_thai' => 'cho_xac_nhan',
                ]);
                ThongTinNguoiDi::create(['id_ve' => $ve_di->id] + $info);

                // --- VÉ LƯỢT VỀ (Nếu có) ---
                if ($isRoundTrip && $chuyenBayVe) {
                    $ve_ve = Ve::create([
                        'id_booking' => $booking->id,
                        'id_chuyen_bay' => $chuyenBayVe->id,
                        'loai_hanh_khach' => $data['loai_hanh_khach'],
                        'loai_ghe' => $data['loai_ghe'],
                        'so_ghe' => null,
                        'gia_ve' => $data['gia_ve_ve'],
                        'gia_ghe' => $data['gia_ghe_ve'],          // FIX: Lưu giá ghế riêng
                        'gia_hanh_ly' => 0,                        // Hành lý đã tính ở lượt đi
                        'trang_thai' => 'cho_xac_nhan',
                    ]);
                    ThongTinNguoiDi::create(['id_ve' => $ve_ve->id] + $info);
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Lỗi CSDL: ' . $e->getMessage());
        }

        return redirect()->route('payment.show', ['maBooking' => $booking->ma_booking]);
    }
}
