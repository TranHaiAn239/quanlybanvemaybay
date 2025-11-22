<?php

namespace App\Filament\Resources\YeuCauHoTroResource\Pages;

use App\Filament\Resources\YeuCauHoTroResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditYeuCauHoTro extends EditRecord
{
    protected static string $resource = YeuCauHoTroResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
