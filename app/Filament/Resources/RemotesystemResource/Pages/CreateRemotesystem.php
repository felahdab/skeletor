<?php

namespace App\Filament\Resources\RemotesystemResource\Pages;

use App\Filament\Resources\RemotesystemResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

use Ramsey\Uuid\Uuid;
 
class CreateRemotesystem extends CreateRecord
{
    protected static string $resource = RemotesystemResource::class;

 
    protected function handleRecordCreation(array $data): Model
    {
        $uuid = Uuid::uuid4();
        $data['uuid'] = $uuid;
        
        return static::getModel()::create($data);
    }
}
