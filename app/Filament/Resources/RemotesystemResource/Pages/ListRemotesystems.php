<?php

namespace App\Filament\Resources\RemotesystemResource\Pages;

use App\Filament\Resources\RemotesystemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRemotesystems extends ListRecords
{
    protected static string $resource = RemotesystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
