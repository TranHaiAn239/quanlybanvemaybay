<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FlightSearchController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderHistoryController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\DealHunterController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\AdminChatbotController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- TRANG CHÍNH ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- TÌM KIẾM & KẾT QUẢ ---
Route::get('/tim-kiem-chuyen-bay', [FlightSearchController::class, 'search'])->name('flight.search');

// --- TIN TỨC & BÀI VIẾT ---
Route::get('/tin-tuc', [NewsController::class, 'index'])->name('news.index');
Route::get('/danh-muc/{slug}', [NewsController::class, 'showCategory'])->name('news.category');
Route::get('/tin-tuc/{slug}', [NewsController::class, 'show'])->name('news.show');

// --- API KIỂM TRA KHUYẾN MÃI (Cho Alpine.js) ---
Route::get('/kiem-tra-khuyen-mai/{code}', function ($code) {
    $khuyenMai = \App\Models\KhuyenMai::where('ma_khuyen_mai', $code)
                                    ->where('trang_thai', 'hieu_luc')
                                    ->where('ngay_bat_dau', '<=', now())
                                    ->where('ngay_ket_thuc', '>=', now())
                                    ->first();

    if (!$khuyenMai) {
        return response()->json([
            'success' => false,
            'message' => 'Mã khuyến mãi không hợp lệ hoặc đã hết hạn.'
        ]);
    }

    return response()->json([
        'success' => true,
        'ma_khuyen_mai' => $khuyenMai->ma_khuyen_mai,
        'mo_ta' => $khuyenMai->mo_ta,
        'gia_tri' => $khuyenMai->gia_tri,
        'loai_gia_tri' => $khuyenMai->loai_gia_tri,
    ]);
})->name('promo.check');


// --- CÁC ROUTE YÊU CẦU ĐĂNG NHẬP ---
Route::middleware(['auth'])->group(function () {

    // QUY TRÌNH ĐẶT VÉ & THANH TOÁN
    Route::get('/dat-ve/tao-don', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/dat-ve', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/thanh-toan/{maBooking}', [PaymentController::class, 'show'])->name('payment.show');
    Route::post('/thanh-toan', [PaymentController::class, 'process'])->name('payment.process');


    // DASHBOARD & PROFILE (Của Breeze)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['verified'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/admin/chatbot', [AdminChatbotController::class, 'handle'])->name('admin.chatbot');
});

Route::get('/ho-tro', [SupportController::class, 'index'])->name('support.index');
Route::get('/san-ve-re', [DealHunterController::class, 'index'])->name('deal.index');

Route::get('/kiem-tra-don-hang', [OrderHistoryController::class, 'index'])
     ->name('order.history');

Route::post('/huy-don-hang/{booking}', [OrderHistoryController::class, 'cancel'])
     ->name('order.cancel');
Route::get('/in-hoa-don/{booking}', [OrderHistoryController::class, 'printInvoice'])
     ->name('invoice.print');
// Route cho file auth.php (Của Breeze)
require __DIR__.'/auth.php';

Route::get('/vnpay-done', [PaymentController::class, 'vnpayReturn']);

Route::post('/api/chatbot', [ChatbotController::class, 'handle'])->name('chatbot.handle');
