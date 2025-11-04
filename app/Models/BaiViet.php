<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaiViet extends Model
{
    use HasFactory;

    protected $table = 'bai_viet';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = 'ngay_cap_nhat';

    protected $fillable = [
        'id_danh_muc',
        'id_tac_gia',
        'tieu_de',
        'slug',
        'mo_ta_ngan',
        'noi_dung',
        'hinh_anh_dai_dien',
        'trang_thai',
        'luot_xem',
        'ngay_xuat_ban',
    ];

    protected $casts = [
        'ngay_xuat_ban' => 'datetime',
        'ngay_tao' => 'datetime',
        'ngay_cap_nhat' => 'datetime',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Bài viết này thuộc danh mục nào.
     */
    public function danhMuc()
    {
        return $this->belongsTo(DanhMucBaiViet::class, 'id_danh_muc');
    }

    /**
     * Tác giả của bài viết này.
     */
    public function tacGia()
    {
        return $this->belongsTo(NguoiDung::class, 'id_tac_gia');
    }
}
