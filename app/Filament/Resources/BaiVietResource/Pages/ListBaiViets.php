<?php

namespace App\Filament\Resources\BaiVietResource\Pages;

use App\Filament\Resources\BaiVietResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBaiViets extends ListRecords
{
    protected static string $resource = BaiVietResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
