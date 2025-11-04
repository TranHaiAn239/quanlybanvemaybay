<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietHoaDon extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_hoa_don';
    public $timestamps = false;

    protected $fillable = [
        'id_hoa_don',
        'id_ve',
        'so_luong',
        'gia',
    ];

    protected $casts = [
        'gia' => 'decimal:2',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Chi tiết này thuộc hóa đơn nào.
     */
    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'id_hoa_don');
    }

    /**
     * Chi tiết này dành cho vé nào.
     */
    public function ve()
    {
        return $this->belongsTo(Ve::class, 'id_ve');
    }
}
