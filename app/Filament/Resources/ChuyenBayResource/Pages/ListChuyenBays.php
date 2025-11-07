<?php

namespace App\Filament\Resources\ChuyenBayResource\Pages;

use App\Filament\Resources\ChuyenBayResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListChuyenBays extends ListRecords
{
    protected static string $resource = ChuyenBayResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
