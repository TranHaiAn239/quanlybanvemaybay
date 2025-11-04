<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ghe extends Model
{
    use HasFactory;

    protected $table = 'ghe';
    public $timestamps = false;

    protected $fillable = [
        'id_may_bay',
        'so_ghe',
        'loai_ghe',
        'trang_thai',
    ];

    // ========== QUAN HỆ ==========

    /**
     * Ghế này thuộc về máy bay nào.
     */
    public function mayBay()
    {
        return $this->belongsTo(MayBay::class, 'id_may_bay');
    }
}
