<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YeuCauHoTro extends Model
{
    use HasFactory;

    // --- QUAN TRỌNG: ĐỊNH NGHĨA TÊN BẢNG ---
    protected $table = 'yeu_cau_ho_tro';
    // ---------------------------------------

    public $timestamps = false; // Hoặc true nếu bảng bạn có created_at/updated_at

    // Khai báo các cột được phép lưu (để tránh lỗi ở bước sau)
    protected $fillable = [
        'id_nguoi_dung',
        'ma_booking',
        'ho_ten',
        'email',
        'so_dien_thoai',
        'loai_yeu_cau',
        'noi_dung_yeu_cau',
        'trang_thai',
        'phan_hoi_admin',
        'phu_phi_huy',
        'ngay_tao',
    ];

    // Các quan hệ (nếu cần dùng trong Admin)
    public function nguoiDung()
    {
        return $this->belongsTo(NguoiDung::class, 'id_nguoi_dung');
    }
}
