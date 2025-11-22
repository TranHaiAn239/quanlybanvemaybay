<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\HoaDon;

class AdminChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $userMessage = $request->input('message');
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return response()->json(['reply' => 'Lỗi: Chưa cấu hình API Key.']);
        }

        // =================================================================
        // PHẦN B: AI PHÁT HIỆN GIAN LẬN (FRAUD DETECTION)
        // =================================================================

        $fraudReport = "BÁO CÁO AN TOÀN & RỦI RO:\n";
        $hasFraud = false;

        // 1. Check IP Spam (SỬA: created_at -> ngay_dat)
        // Tìm IP đặt quá 3 đơn trong 24h mà chưa thanh toán
        $spamIPs = Booking::select('ip_address', DB::raw('count(*) as total'))
            ->where('trang_thai', 'cho_thanh_toan')
            ->where('ngay_dat', '>=', Carbon::now()->subDay()) // <--- ĐÃ SỬA
            ->whereNotNull('ip_address')
            ->groupBy('ip_address')
            ->having('total', '>=', 3)
            ->get();

        if ($spamIPs->count() > 0) {
            $hasFraud = true;
            foreach ($spamIPs as $ip) {
                $fraudReport .= "- ⚠️ CẢNH BÁO: IP {$ip->ip_address} đã tạo {$ip->total} đơn ảo trong 24h qua.\n";
            }
        }

        // 2. Check Giữ Vé: Tìm User đang giữ quá 4 vé chưa thanh toán (bất kể thời gian)
        $hoardingUsers = Booking::select('id_nguoi_dung', DB::raw('count(*) as total'))
            ->where('trang_thai', 'cho_thanh_toan')
            ->groupBy('id_nguoi_dung')
            ->having('total', '>=', 4)
            ->with('nguoiDung:id,ho_ten,email,so_dien_thoai')
            ->get();

        if ($hoardingUsers->count() > 0) {
            $hasFraud = true;
            foreach ($hoardingUsers as $u) {
                $name = $u->nguoiDung->ho_ten ?? 'Unknown';
                $info = $u->nguoiDung->so_dien_thoai ?? $u->nguoiDung->email;
                $fraudReport .= "- ⚠️ CẢNH BÁO: Khách hàng {$name} ({$info}) đang giữ {$u->total} đơn chưa thanh toán.\n";
            }
        }

        if (!$hasFraud) {
            $fraudReport .= "- Hệ thống an toàn. Không phát hiện IP spam hay hành vi giữ vé bất thường.\n";
        }

        // =================================================================
        // PHẦN F: AI PHÂN TÍCH DỮ LIỆU BÁN HÀNG (SALES ANALYTICS)
        // =================================================================

        $salesReport = "PHÂN TÍCH KINH DOANH (30 NGÀY QUA):\n";

        // 1. Tổng doanh thu (SỬA: created_at -> ngay_tao cho Hóa Đơn)
        $revenue = HoaDon::where('trang_thai', 'da_thanh_toan')
            ->whereMonth('ngay_tao', Carbon::now()->month) // Bảng hoa_don dùng ngay_tao
            ->sum('tong_tien');
        $salesReport .= "- Doanh thu tháng này: " . number_format($revenue) . " VND.\n";

        // 2. Tìm Chuyến bay HOT (SỬA: Join bảng để lấy ngày tháng đúng)
        // Bảng 've' không có ngày tạo, phải join với 'booking' để lấy 'ngay_dat'
        $hotRoutes = DB::table('ve')
            ->join('booking', 've.id_booking', '=', 'booking.id') // Join để lấy ngày
            ->join('chuyen_bay', 've.id_chuyen_bay', '=', 'chuyen_bay.id')
            ->join('san_bay as sb_di', 'chuyen_bay.id_san_bay_di', '=', 'sb_di.id')
            ->join('san_bay as sb_den', 'chuyen_bay.id_san_bay_den', '=', 'sb_den.id')
            ->select('sb_di.tinh_thanh as di', 'sb_den.tinh_thanh as den', DB::raw('count(*) as total_sold'))
            ->where('ve.trang_thai', 'da_thanh_toan')
            ->whereMonth('booking.ngay_dat', Carbon::now()->month) // <--- ĐÃ SỬA
            ->groupBy('di', 'den')
            ->orderByDesc('total_sold')
            ->limit(3)
            ->get();

        if ($hotRoutes->count() > 0) {
            $salesReport .= "- Top chặng bay HOT:\n";
            foreach ($hotRoutes as $r) {
                $salesReport .= "  + {$r->di} -> {$r->den}: {$r->total_sold} vé.\n";
            }
        }

        // 3. Dữ liệu dự đoán (Lấy các đơn CHỜ thanh toán để dự đoán nhu cầu sắp tới)
        $potentialRoutes = DB::table('booking')
            ->join('ve', 'booking.id', '=', 've.id_booking')
            ->join('chuyen_bay', 've.id_chuyen_bay', '=', 'chuyen_bay.id')
            ->join('san_bay as sb_den', 'chuyen_bay.id_san_bay_den', '=', 'sb_den.id')
            ->where('booking.trang_thai', 'cho_thanh_toan') // Khách quan tâm nhưng chưa mua
            ->select('sb_den.tinh_thanh as den', DB::raw('count(*) as interest'))
            ->groupBy('den')
            ->orderByDesc('interest')
            ->limit(1)
            ->first();

        $trendPrediction = $potentialRoutes
            ? "Xu hướng sắp tới: Nhiều khách đang tìm vé đi {$potentialRoutes->den} ({$potentialRoutes->interest} lượt quan tâm)."
            : "Chưa đủ dữ liệu dự đoán xu hướng.";

        // =================================================================
        // GỬI DỮ LIỆU CHO GEMINI
        // =================================================================

        $systemPrompt = <<<EOT
Bạn là Trợ Lý AI Cao Cấp cho Admin hệ thống vé máy bay.
Dưới đây là dữ liệu thời gian thực từ hệ thống:

=== [PHẦN 1: RỦI RO & GIAN LẬN] ===
$fraudReport

=== [PHẦN 2: KINH DOANH & DỰ ĐOÁN] ===
$salesReport
$trendPrediction

NHIỆM VỤ CỦA BẠN:
1. **Nếu Admin hỏi về rủi ro/gian lận:**
   - Báo cáo ngay các IP hoặc User đáng ngờ.
   - Đề xuất giải pháp (VD: "Nên khóa IP này" hoặc "Gọi điện nhắc khách thanh toán").

2. **Nếu Admin hỏi về doanh thu/tình hình kinh doanh:**
   - Báo cáo doanh thu.
   - Phân tích chặng bay Hot.
   - **QUAN TRỌNG:** Dựa vào "Xu hướng sắp tới", hãy đóng vai chuyên gia và đưa ra lời khuyên. (Ví dụ: Nếu khách đang tìm vé đi Đà Nẵng nhiều, hãy khuyên Admin nên tung khuyến mãi cho chặng Đà Nẵng).

3. **Nếu Admin hỏi chung chung:** Tóm tắt ngắn gọn cả 2 tình hình trên.

Trả lời ngắn gọn, súc tích, chuyên nghiệp. Không bịa đặt số liệu.

ADMIN HỎI: "$userMessage"
EOT;

        try {
            // Thêm withoutVerifying() để chạy được trên XAMPP
            $response = Http::withoutVerifying()
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                    'contents' => [['role' => 'user', 'parts' => [['text' => $systemPrompt]]]]
                ]);

            if ($response->failed()) {
                // In ra lỗi chi tiết từ Google để debug
                return response()->json(['reply' => 'Lỗi API: ' . $response->body()]);
            }

            $reply = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'AI không phản hồi.';
            return response()->json(['reply' => nl2br($reply)]);

        } catch (\Exception $e) {
            return response()->json(['reply' => 'Lỗi Server: ' . $e->getMessage()]);
        }
    }
}
