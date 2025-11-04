<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoanhThu extends Model
{
    use HasFactory;

    protected $table = 'doanh_thu';

    const CREATED_AT = null;
    const UPDATED_AT = 'ngay_cap_nhat';

    protected $fillable = [
        'id_hoa_don',
        'thang',
        'nam',
        'doanh_thu',
    ];

    protected $casts = [
        'doanh_thu' => 'decimal:2',
        'ngay_cap_nhat' => 'datetime',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Doanh thu này từ hóa đơn nào.
     */
    public function hoaDon()
    {
        return $this->belongsTo(HoaDon::class, 'id_hoa_don');
    }
}
