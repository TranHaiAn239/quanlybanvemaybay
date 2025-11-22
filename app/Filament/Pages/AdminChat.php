<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class AdminChat extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chat';
    protected static ?string $navigationLabel = 'Trợ lý AI Chat';
    protected static string $view = 'filament.pages.admin-chat'; // View mới
    protected static ?string $title = 'Trợ lý AI Admin';

    // Nhóm chung với các mục Cài đặt khác
    protected static ?string $navigationGroup = 'Cài đặt Hệ thống';
    protected static ?int $navigationSort = 3;

    // Hàm này sẽ được gọi để truyền dữ liệu (nếu cần)
    protected function getHeading(): string
    {
        return static::$title;
    }
}
