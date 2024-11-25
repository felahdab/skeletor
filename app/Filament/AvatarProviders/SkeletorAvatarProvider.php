<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use App\Service\AnnudefAjaxRequestService;


class SkeletorAvatarProvider implements Contracts\AvatarProvider
{
    public function get(Model | Authenticatable $record): string
    {
        if (config('skeletor.reseau_de_deploiement') == "sic21")
        {
            return asset('assets/images/unknown.jpg');
        }
        
        $cacheKey = sprintf(
            "users/%s-%s",
            $record->getKey(),
            $record->updated_at->timestamp
        );

        $url=Cache::remember($cacheKey . ':annudef_picture_url', 60*5, function () use ($record){
            return AnnudefAjaxRequestService::searchPictureForEmail($record->email);
        });

        if ($url == null) return asset('assets/images/unknown.jpg');

        return $url;
    }
}