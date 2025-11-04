<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    use HasFactory;

    protected $table = 'khuyen_mai';
    public $timestamps = false;

    protected $fillable = [
        'ma_khuyen_mai',
        'mo_ta',
        'gia_tri',
        'loai_gia_tri',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
    ];

    protected $casts = [
        'ngay_bat_dau' => 'date',
        'ngay_ket_thuc' => 'date',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Các booking đã áp dụng mã này.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_khuyen_mai');
    }
}
