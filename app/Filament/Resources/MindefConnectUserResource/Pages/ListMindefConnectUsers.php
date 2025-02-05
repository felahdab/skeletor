<?php

namespace App\Filament\Resources\MindefConnectUserResource\Pages;

use App\Filament\Resources\MindefConnectUserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMindefConnectUsers extends ListRecords
{
    protected static string $resource = MindefConnectUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
