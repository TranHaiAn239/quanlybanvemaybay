<?php

namespace App\Filament\Resources\DanhMucBaiVietResource\Pages;

use App\Filament\Resources\DanhMucBaiVietResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDanhMucBaiViet extends EditRecord
{
    protected static string $resource = DanhMucBaiVietResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
