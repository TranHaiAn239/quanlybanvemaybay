<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;

class NguoiDung extends Authenticatable implements FilamentUser, HasName
{
    use HasFactory, Notifiable;

    protected $table = 'nguoi_dung';

    // Chỉ định cột 'created_at' và tắt 'updated_at'
    const CREATED_AT = 'ngay_tao';
    const UPDATED_AT = null;

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',
        'so_dien_thoai',
        'dia_chi',
        'vai_tro',
        'trang_thai',
    ];

    protected $hidden = [
        'mat_khau', // Ẩn mật khẩu khi serialize
    ];

    /**
     * Ghi đè phương thức lấy tên cột mật khẩu.
     */
    public function getAuthPassword()
    {
        return $this->mat_khau;
    }

    // ========== QUAN HỆ ==========

    /**
     * Một người dùng có thể có nhiều booking.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'id_nguoi_dung');
    }

    /**
     * Một người dùng (tác giả) có thể viết nhiều bài viết.
     */
    public function baiViets()
    {
        return $this->hasMany(BaiViet::class, 'id_tac_gia');
    }

    /**
     * Lịch sử đăng nhập của người dùng.
     */
    public function lichSuDangNhaps()
    {
        return $this->hasMany(LichSuDangNhap::class, 'id_nguoi_dung');
    }

    /**
     * Thông báo của người dùng.
     */
    public function thongBaos()
    {
        return $this->hasMany(ThongBao::class, 'id_nguoi_dung');
    }
    public function canAccessFilament(): bool
    {
        // Chỉ cho phép 'admin' và 'nhan_vien' truy cập
        return in_array($this->vai_tro, ['admin', 'nhan_vien']);
    }
    public function getFilamentName(): string
    {
        return $this->ho_ten; // Trả về tên từ cột 'ho_ten'
    }
}
