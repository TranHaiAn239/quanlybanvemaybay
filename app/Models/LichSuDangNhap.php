<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LichSuDangNhap extends Model
{
    use HasFactory;

    protected $table = 'lich_su_dang_nhap';

    const CREATED_AT = 'thoi_gian';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_nguoi_dung',
        'ip',
        'user_agent',
        'thanh_cong',
    ];

    protected $casts = [
        'thoi_gian' => 'datetime',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Lịch sử này của người dùng nào.
     */
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoi_dung');
    }
}
