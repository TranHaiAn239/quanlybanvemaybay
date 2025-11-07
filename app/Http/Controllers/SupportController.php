<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Hiển thị trang hỗ trợ.
     */
    public function index()
    {
        // Chỉ cần trả về view, không cần dữ liệu
        return view('support.index');
    }
}
