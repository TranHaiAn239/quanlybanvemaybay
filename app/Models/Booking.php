<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'booking';

    // Cột 'ngay_dat' là 'created_at', không có 'updated_at'
    const CREATED_AT = 'ngay_dat';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_nguoi_dung',
        'ma_booking',
        'tong_tien',
        'trang_thai',
        'phuong_thuc_tt',
        'id_khuyen_mai',
    ];

    protected $casts = [
        'tong_tien' => 'decimal:2',
        'ngay_dat' => 'datetime',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Booking này thuộc về người dùng nào.
     */
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoi_dung');
    }

    /**
     * Booking này áp dụng khuyến mãi nào (có thể null).
     */
    public function khuyenMai()
    {
        return $this->belongsTo(KhuyenMai::class, 'id_khuyen_mai');
    }

    /**
     * Tất cả các vé trong booking này.
     */
    public function ves()
    {
        return $this->hasMany(Ve::class, 'id_booking');
    }

    /**
     * Hóa đơn của booking này (nếu có).
     */
    public function hoaDon()
    {
        return $this->hasOne(HoaDon::class, 'id_booking');
    }
}
