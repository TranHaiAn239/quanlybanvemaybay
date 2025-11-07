<?php

namespace App\Filament\Resources\DanhMucBaiVietResource\Pages;

use App\Filament\Resources\DanhMucBaiVietResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDanhMucBaiViets extends ListRecords
{
    protected static string $resource = DanhMucBaiVietResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
