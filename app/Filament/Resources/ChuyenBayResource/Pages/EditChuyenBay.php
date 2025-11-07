<?php

namespace App\Filament\Resources\ChuyenBayResource\Pages;

use App\Filament\Resources\ChuyenBayResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditChuyenBay extends EditRecord
{
    protected static string $resource = ChuyenBayResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
