<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Actions\ChangePasswordAction;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;
    protected static ?string $title = 'Modifier utilisateur';

    protected function getHeaderActions(): array
    {
        return [
            ChangePasswordAction::make('change-password'),
            DeleteAction::make(),
        ];
    }
}
