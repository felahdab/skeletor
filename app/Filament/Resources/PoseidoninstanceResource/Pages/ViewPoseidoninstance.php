<?php

namespace App\Filament\Resources\PoseidoninstanceResource\Pages;

use App\Filament\Resources\PoseidoninstanceResource;
use Filament\Resources\Pages\ViewRecord;

class ViewPoseidoninstance extends ViewRecord
{
    protected static string $resource = PoseidoninstanceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
