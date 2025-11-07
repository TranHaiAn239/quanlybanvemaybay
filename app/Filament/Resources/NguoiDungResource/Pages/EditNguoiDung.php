<?php

namespace App\Filament\Resources\NguoiDungResource\Pages;

use App\Filament\Resources\NguoiDungResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNguoiDung extends EditRecord
{
    protected static string $resource = NguoiDungResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
