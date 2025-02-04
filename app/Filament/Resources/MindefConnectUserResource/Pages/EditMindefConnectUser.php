<?php

namespace App\Filament\Resources\MindefConnectUserResource\Pages;

use App\Filament\Resources\MindefConnectUserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMindefConnectUser extends EditRecord
{
    protected static string $resource = MindefConnectUserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
