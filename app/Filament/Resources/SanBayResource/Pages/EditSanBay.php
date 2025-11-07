<?php

namespace App\Filament\Resources\SanBayResource\Pages;

use App\Filament\Resources\SanBayResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSanBay extends EditRecord
{
    protected static string $resource = SanBayResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
