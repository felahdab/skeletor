<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Service\RandomPasswordGeneratorService;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $service = new RandomPasswordGeneratorService();
        $password = $service->generateRandomString(10);
        $data['password'] = $password;

        return $data;
    }
}
