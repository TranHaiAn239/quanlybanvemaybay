<?php
// File: public/chatbot_gemini.php

header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");

// =================================================================
// 1. CẤU HÌNH KẾT NỐI DATABASE
// =================================================================
$host = '127.0.0.1';
$db   = 'wbvmb';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    echo json_encode(["reply" => "Hệ thống đang bảo trì, vui lòng thử lại sau."]);
    exit;
}

// =================================================================
// 2. XỬ LÝ LOGIC THÔNG MINH (AI ANALYSIS)
// =================================================================

$input = json_decode(file_get_contents("php://input"), true);
$userMessage = $input["message"] ?? "";

if (empty($userMessage)) {
    echo json_encode(["reply" => "Xin chào! Tôi là trợ lý ảo 24/7. Tôi có thể giúp gì cho bạn?"]);
    exit;
}

// --- PHÂN TÍCH Ý ĐỊNH CỦA KHÁCH HÀNG ---
$intent = [
    'is_cheap' => false,    // Muốn tìm vé rẻ?
    'location' => null,     // Địa điểm muốn đến/đi
    'is_business' => false, // Đi công tác (cần giờ đẹp, bay sớm/chiều)
    'is_leisure' => false   // Đi chơi (thoải mái giờ giấc, ưu tiên rẻ)
];

// Từ khóa "Rẻ", "Tiết kiệm", "Khuyến mãi"
if (preg_match('/(rẻ|tiết kiệm|thấp nhất|khuyến mãi)/iu', $userMessage)) {
    $intent['is_cheap'] = true;
}

// Từ khóa "Công tác", "Gấp", "Sáng sớm", "Họp"
if (preg_match('/(công tác|gấp|sáng|họp|doanh nhân)/iu', $userMessage)) {
    $intent['is_business'] = true;
}

// Từ khóa "Du lịch", "Đi chơi", "Thong thả"
if (preg_match('/(du lịch|đi chơi|thong thả)/iu', $userMessage)) {
    $intent['is_leisure'] = true;
}

// --- TRUY VẤN DỮ LIỆU PHÙ HỢP (DYNAMIC SQL) ---
// Lấy danh sách chuyến bay phong phú hơn để AI có dữ liệu so sánh
$sql = "SELECT
            cb.ma_chuyen_bay,
            cb.gia_ve,
            cb.thoi_gian_di,
            cb.thoi_gian_den,
            sb_di.ten_san_bay AS san_bay_di,
            sb_den.ten_san_bay AS san_bay_den,
            mb.hang_hang_khong
        FROM chuyen_bay AS cb
        JOIN san_bay AS sb_di ON cb.id_san_bay_di = sb_di.id
        JOIN san_bay AS sb_den ON cb.id_san_bay_den = sb_den.id
        JOIN may_bay AS mb ON cb.id_may_bay = mb.id
        WHERE cb.trang_thai = 'dang_ban'
        AND cb.thoi_gian_di > NOW() ";

// Nếu khách hỏi địa điểm cụ thể (tìm kiếm tương đối)
if (preg_match('/(hà nội|hồ chí minh|đà nẵng|phú quốc|nha trang|đà lạt)/iu', $userMessage, $matches)) {
    $location = $matches[0];
    $sql .= " AND (sb_di.tinh_thanh LIKE '%$location%' OR sb_den.tinh_thanh LIKE '%$location%' OR sb_di.ten_san_bay LIKE '%$location%' OR sb_den.ten_san_bay LIKE '%$location%') ";
}

// Sắp xếp dữ liệu để AI dễ gợi ý
if ($intent['is_cheap']) {
    $sql .= " ORDER BY cb.gia_ve ASC LIMIT 10"; // Lấy 10 vé rẻ nhất
} elseif ($intent['is_business']) {
    $sql .= " ORDER BY cb.thoi_gian_di ASC LIMIT 10"; // Lấy các chuyến bay sớm nhất
} else {
    $sql .= " ORDER BY cb.thoi_gian_di ASC LIMIT 8"; // Mặc định lấy 8 chuyến sắp tới
}

try {
    $stmt = $pdo->query($sql);
    $flights = $stmt->fetchAll();
} catch (Exception $e) {
    $flights = [];
}

// --- CHUẨN BỊ DỮ LIỆU CHO AI ---
$flightDataText = "";
if (count($flights) > 0) {
    $flightDataText = "DỮ LIỆU CHUYẾN BAY THỰC TẾ TỪ HỆ THỐNG:\n";
    foreach ($flights as $f) {
        $formattedPrice = number_format($f['gia_ve'], 0, ',', '.');
        $flightDataText .= "- Mã: {$f['ma_chuyen_bay']} | Hãng: {$f['hang_hang_khong']} | Từ: {$f['san_bay_di']} -> Đến: {$f['san_bay_den']} | Giá: {$formattedPrice} VNĐ | Giờ đi: {$f['thoi_gian_di']}\n";
    }
} else {
    $flightDataText = "HỆ THỐNG: Hiện không tìm thấy chuyến bay phù hợp với yêu cầu cụ thể này trong CSDL.";
}

// =================================================================
// 3. GỬI YÊU CẦU ĐẾN GEMINI (PROMPT ENGINEERING CAO CẤP)
// =================================================================
$apiKey = "AIzaSyAquKpRJgUoVrnK1F_J9sZ85A8X5_8jz8g"; // Thay KEY của bạn vào đây
$apiVal = "gemini-2.5-flash-preview-09-2025"; // Hoặc gemini-pro
$url = "https://generativelanguage.googleapis.com/v1beta/models/" . $apiVal . ":generateContent?key=" . $apiKey;

// Xây dựng Prompt thông minh (Đáp ứng A & D)
$systemPrompt = <<<EOT
Bạn là Trợ lý ảo chuyên nghiệp của hệ thống "Săn Vé Máy Bay Giá Rẻ".
Nhiệm vụ của bạn là tư vấn đường bay, so sánh giá và hỗ trợ khách hàng 24/7.

Dưới đây là Dữ liệu chuyến bay thực tế hiện có:
---------------------
$flightDataText
---------------------

YÊU CẦU XỬ LÝ:
1. **Trả lời dựa trên dữ liệu:** Chỉ tư vấn các chuyến bay có trong danh sách trên. Nếu không có, hãy xin lỗi và gợi ý tìm ngày khác.
2. **Gợi ý giá tốt nhất (Requirement D):**
   - Luôn so sánh giá giữa các chuyến bay trong danh sách.
   - Nếu khách hỏi vé đi một nơi cụ thể, hãy chỉ ra chuyến nào rẻ nhất trong danh sách.
3. **Tư vấn theo nhu cầu (Requirement A & D):**
   - Nếu khách có vẻ đi **Công tác/Gấp**: Ưu tiên gợi ý các chuyến bay giờ đẹp (sáng sớm hoặc đầu giờ chiều), các hãng uy tín (Vietnam Airlines...), bỏ qua yếu tố giá nếu cần.
   - Nếu khách đi **Du lịch/Chơi**: Ưu tiên gợi ý các chuyến bay giá rẻ nhất, bất kể giờ bay. Gợi ý họ nên đặt sớm để có giá tốt.
4. **Tự động gợi ý:** Nếu khách chọn một chuyến đắt tiền, hãy khéo léo nhắc: "Ngoài ra, em thấy có chuyến bay [Mã] giá chỉ [Giá] rẻ hơn, quý khách có muốn tham khảo không?".
5. **Văn phong:** Thân thiện, chuyên nghiệp, xưng hô là "em" hoặc "hệ thống".

CÂU HỎI CỦA KHÁCH HÀNG: "$userMessage"
EOT;

$dataPayload = [
    "contents" => [
        [
            "role" => "user",
            "parts" => [
                ["text" => $systemPrompt]
            ]
        ]
    ],
    "generationConfig" => [
        "temperature" => 0.4, // Giữ mức sáng tạo thấp để thông tin chính xác
        "maxOutputTokens" => 1000
    ]
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($dataPayload));
curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo json_encode(["reply" => "Xin lỗi, kết nối đến máy chủ AI đang gặp sự cố."]);
} else {
    $json = json_decode($response, true);
    $reply = $json["candidates"][0]["content"]["parts"][0]["text"] ?? "Hiện tại em đang quá tải, quý khách vui lòng hỏi lại sau giây lát ạ.";

    // Định dạng lại xuống dòng cho đẹp khi hiển thị trên web
    $reply = nl2br($reply);
    echo json_encode(["reply" => $reply]);
}
?>
