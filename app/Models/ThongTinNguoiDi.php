<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongTinNguoiDi extends Model
{
    use HasFactory;

    protected $table = 'thong_tin_nguoi_di';
    public $timestamps = false;

    protected $fillable = [
        'id_ve',
        'ho_ten',
        'so_dien_thoai',
        'email',
        'dia_chi',
        'ghi_chu',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Thông tin này gắn với vé nào.
     */
    public function ve()
    {
        return $this->belongsTo(Ve::class, 'id_ve');
    }
}
