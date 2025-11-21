<?php

namespace App\Filament\Resources\MayBayResource\Pages;

use App\Filament\Resources\MayBayResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMayBay extends EditRecord
{
    protected static string $resource = MayBayResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
