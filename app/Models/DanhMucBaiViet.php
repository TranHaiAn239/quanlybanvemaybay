<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucBaiViet extends Model
{
    use HasFactory;

    protected $table = 'danh_muc_bai_viet';

    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'ten_danh_muc',
        'slug',
        'id_danh_muc_cha',
        'mo_ta',
        'trang_thai',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Lấy danh mục cha (nếu có).
     */
    public function danhMucCha()
    {
        return $this->belongsTo(DanhMucBaiViet::class, 'id_danh_muc_cha');
    }

    /**
     * Lấy các danh mục con.
     */
    public function danhMucCon()
    {
        return $this->hasMany(DanhMucBaiViet::class, 'id_danh_muc_cha');
    }

    /**
     * Lấy tất cả bài viết thuộc danh mục này.
     */
    public function baiViets()
    {
        return $this->hasMany(BaiViet::class, 'id_danh_muc');
    }
}
