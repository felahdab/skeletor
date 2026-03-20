<?php

namespace App\Filament\Resources\RemotesystemResource\Pages;

use App\Filament\Resources\RemotesystemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRemotesystem extends EditRecord
{
    protected static string $resource = RemotesystemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
