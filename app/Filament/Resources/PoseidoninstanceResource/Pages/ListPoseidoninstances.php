<?php

namespace App\Filament\Resources\PoseidoninstanceResource\Pages;

use App\Filament\Resources\PoseidoninstanceResource;
use Filament\Resources\Pages\ListRecords;

class ListPoseidoninstances extends ListRecords
{
    protected static string $resource = PoseidoninstanceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
