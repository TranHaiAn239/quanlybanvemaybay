<?php

namespace App\Filament\Resources\KhuyenMaiResource\Pages;

use App\Filament\Resources\KhuyenMaiResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKhuyenMai extends EditRecord
{
    protected static string $resource = KhuyenMaiResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
