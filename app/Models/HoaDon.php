<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoaDon extends Model
{
    use HasFactory;

    protected $table = 'hoa_don';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_booking',
        'tong_tien',
        'trang_thai',
        'phuong_thuc_tt',
    ];

    protected $casts = [
        'ngay_tao' => 'datetime',
        'tong_tien' => 'decimal:2',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Hóa đơn này của booking nào.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'id_booking');
    }

    /**
     * Các chi tiết (dòng) trong hóa đơn.
     */
    public function chiTiets()
    {
        return $this->hasMany(ChiTietHoaDon::class, 'id_hoa_don');
    }

    /**
     * Mục doanh thu liên quan đến hóa đơn này.
     */
    public function doanhThu()
    {
        return $this->hasMany(DoanhThu::class, 'id_hoa_don');
    }
}
