<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MayBay extends Model
{
    use HasFactory;

    protected $table = 'may_bay';
    public $timestamps = false;

    protected $fillable = [
        'ma_may_bay',
        'ten_may_bay',
        'hang_hang_khong',
        'so_ghe',
        'trang_thai',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Các ghế có trong máy bay này.
     */
    public function ghes()
    {
        return $this->hasMany(Ghe::class, 'id_may_bay');
    }

    /**
     * Các chuyến bay sử dụng máy bay này.
     */
    public function chuyenBays()
    {
        return $this->hasMany(ChuyenBay::class, 'id_may_bay');
    }
}
