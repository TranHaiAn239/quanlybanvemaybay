<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanBay extends Model
{
    use HasFactory;

    protected $table = 'san_bay';
    public $timestamps = false; // Bảng này không có cột timestamp

    protected $fillable = [
        'ma_san_bay',
        'ten_san_bay',
        'dia_chi',
        'quoc_gia',
        'tinh_thanh',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Các chuyến bay đi từ sân bay này.
     */
    public function chuyenBayDi()
    {
        return $this->hasMany(ChuyenBay::class, 'id_san_bay_di');
    }

    /**
     * Các chuyến bay đến sân bay này.
     */
    public function chuyenBayDen()
    {
        return $this->hasMany(ChuyenBay::class, 'id_san_bay_den');
    }
}
