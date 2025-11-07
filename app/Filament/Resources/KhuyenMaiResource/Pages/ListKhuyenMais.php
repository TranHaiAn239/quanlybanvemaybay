<?php

namespace App\Filament\Resources\KhuyenMaiResource\Pages;

use App\Filament\Resources\KhuyenMaiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKhuyenMais extends ListRecords
{
    protected static string $resource = KhuyenMaiResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
