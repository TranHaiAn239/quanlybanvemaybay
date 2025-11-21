<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function handle(Request $request)
    {
        $userMessage = $request->input('message');

        if (empty($userMessage)) {
            return response()->json(['reply' => 'Xin chào! Tôi có thể giúp gì cho bạn?']);
        }

        // --- 1. PHÂN TÍCH Ý ĐỊNH ---
        $intent = [
            'is_cheap' => preg_match('/(rẻ|tiết kiệm|thấp nhất|khuyến mãi)/iu', $userMessage),
            'is_business' => preg_match('/(công tác|gấp|sáng|họp|doanh nhân)/iu', $userMessage),
            'location' => null
        ];

        // --- 2. TRUY VẤN DỮ LIỆU (Dùng Query Builder của Laravel - An toàn hơn) ---
        $query = DB::table('chuyen_bay as cb')
            ->join('san_bay as sb_di', 'cb.id_san_bay_di', '=', 'sb_di.id')
            ->join('san_bay as sb_den', 'cb.id_san_bay_den', '=', 'sb_den.id')
            ->join('may_bay as mb', 'cb.id_may_bay', '=', 'mb.id')
            ->where('cb.trang_thai', 'dang_ban')
            ->where('cb.thoi_gian_di', '>', now())
            ->select(
                'cb.ma_chuyen_bay', 'cb.gia_ve', 'cb.thoi_gian_di',
                'sb_di.ten_san_bay as san_bay_di', 'sb_den.ten_san_bay as san_bay_den',
                'mb.hang_hang_khong'
            );

        // Lọc theo địa điểm nếu có trong câu hỏi
        if (preg_match('/(hà nội|hồ chí minh|đà nẵng|phú quốc|nha trang|đà lạt)/iu', $userMessage, $matches)) {
            $loc = $matches[0];
            $query->where(function($q) use ($loc) {
                $q->where('sb_di.tinh_thanh', 'like', "%$loc%")
                  ->orWhere('sb_den.tinh_thanh', 'like', "%$loc%");
            });
        }

        // Sắp xếp
        if ($intent['is_cheap']) {
            $query->orderBy('cb.gia_ve', 'asc')->limit(8);
        } else {
            $query->orderBy('cb.thoi_gian_di', 'asc')->limit(8);
        }

        $flights = $query->get();

        // --- 3. CHUẨN BỊ DỮ LIỆU CHO AI ---
        $flightDataText = "";
        if ($flights->count() > 0) {
            $flightDataText = "DỮ LIỆU TỪ HỆ THỐNG:\n";
            foreach ($flights as $f) {
                $price = number_format($f->gia_ve, 0, ',', '.');
                $flightDataText .= "- {$f->ma_chuyen_bay} ({$f->hang_hang_khong}): {$f->san_bay_di} -> {$f->san_bay_den} | {$price} VNĐ | {$f->thoi_gian_di}\n";
            }
        } else {
            $flightDataText = "HỆ THỐNG: Không tìm thấy chuyến bay phù hợp trong CSDL.";
        }

        // --- 4. GỌI GEMINI API (Dùng HTTP Client của Laravel) ---
        $apiKey = env('GEMINI_API_KEY'); // <-- LẤY KEY TỪ .ENV (AN TOÀN)

        if (!$apiKey) {
            return response()->json(['reply' => 'Lỗi hệ thống: Chưa cấu hình API Key.']);
        }

        $systemPrompt = "Bạn là trợ lý bán vé máy bay. Hãy trả lời dựa trên dữ liệu sau:\n" . $flightDataText . "\n\nYêu cầu: Tư vấn ngắn gọn, lịch sự, nếu có vé rẻ hãy gợi ý.";

        try {
            $response = Http::withHeaders(['Content-Type' => 'application/json'])
                ->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
                    'contents' => [
                        ['role' => 'user', 'parts' => [['text' => $systemPrompt . "\n\nKhách: " . $userMessage]]]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.4,
                        'maxOutputTokens' => 800
                    ]
                ]);

            $reply = $response->json()['candidates'][0]['content']['parts'][0]['text'] ?? 'Xin lỗi, tôi đang gặp sự cố kết nối.';
            return response()->json(['reply' => nl2br($reply)]);

        } catch (\Exception $e) {
            return response()->json(['reply' => 'Lỗi kết nối AI: ' . $e->getMessage()]);
        }
    }
}
