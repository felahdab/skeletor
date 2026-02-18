<?php

namespace App\Filament\Resources\RemotesystemResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\RemotesystemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Form;


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
