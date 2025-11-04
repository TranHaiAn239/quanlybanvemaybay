<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongBao extends Model
{
    use HasFactory;

    protected $table = 'thong_bao';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'id_nguoi_dung',
        'tieu_de',
        'noi_dung',
        'da_doc',
    ];

    protected $casts = [
        'ngay_tao' => 'datetime',
        'da_doc' => 'boolean',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Thông báo này của người dùng nào.
     */
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoi_dung');
    }
}
