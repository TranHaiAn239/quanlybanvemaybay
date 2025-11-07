<?php

namespace App\Filament\Resources\BaiVietResource\Pages;

use App\Filament\Resources\BaiVietResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBaiViet extends EditRecord
{
    protected static string $resource = BaiVietResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
