<?php

namespace App\Filament\Resources\SanBayResource\Pages;

use App\Filament\Resources\SanBayResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSanBays extends ListRecords
{
    protected static string $resource = SanBayResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
