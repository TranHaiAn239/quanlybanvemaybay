<?php

namespace App\Filament\Resources\MayBayResource\Pages;

use App\Filament\Resources\MayBayResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMayBays extends ListRecords
{
    protected static string $resource = MayBayResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
