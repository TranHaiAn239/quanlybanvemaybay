<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ve extends Model
{
    use HasFactory;

    protected $table = 've';
    public $timestamps = false;

    protected $fillable = [
        'id_booking',
        'id_chuyen_bay',
        'so_ghe',
        'gia_ve',
        'trang_thai',
    ];

    protected $casts = [
        'gia_ve' => 'decimal:2',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Vé này thuộc booking nào.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }

    /**
     * Vé này của chuyến bay nào.
     */
    public function chuyenBay()
    {
        return $this->belongsTo(ChuyenBay::class, 'id_chuyen_bay');
    }

    /**
     * Thông tin của người đi cho vé này.
     */
    public function thongTinNguoiDi()
    {
        return $this->hasOne(ThongTinNguoiDi::class, 'id_ve');
    }

    /**
     * Chi tiết hóa đơn liên quan đến vé này.
     */
    public function chiTietHoaDon()
    {
        // Giả định 1 vé chỉ nằm trong 1 chi tiết hóa đơn
        return $this->hasOne(ChiTietHoaDon::class, 'id_ve');
    }
}
