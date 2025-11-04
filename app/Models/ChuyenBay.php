<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChuyenBay extends Model
{
    use HasFactory;

    protected $table = 'chuyen_bay';
    public $timestamps = false;

    protected $fillable = [
        'ma_chuyen_bay',
        'id_may_bay',
        'id_san_bay_di',
        'id_san_bay_den',
        'thoi_gian_di',
        'thoi_gian_den',
        'gia_ve',
        'trang_thai',
    ];

    /**
     * Tự động chuyển đổi kiểu dữ liệu.
     */
    protected $casts = [
        'thoi_gian_di' => 'datetime',
        'thoi_gian_den' => 'datetime',
        'gia_ve' => 'decimal:2',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Chuyến bay này sử dụng máy bay nào.
     */
    public function mayBay()
    {
        return $this->belongsTo(MayBay::class, 'id_may_bay');
    }

    /**
     * Sân bay đi của chuyến bay.
     */
    public function sanBayDi()
    {
        return $this->belongsTo(SanBay::class, 'id_san_bay_di');
    }

    /**
     * Sân bay đến của chuyến bay.
     */
    public function sanBayDen()
    {
        return $this->belongsTo(SanBay::class, 'id_san_bay_den');
    }

    /**
     * Các vé đã bán của chuyến bay này.
     */
    public function ves()
    {
        return $this->hasMany(Ve::class, 'id_chuyen_bay');
    }
}
