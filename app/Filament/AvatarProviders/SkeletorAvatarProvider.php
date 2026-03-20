<?php

namespace App\Filament\AvatarProviders;

use App\Service\AnnudefAjaxRequestService;
use Filament\AvatarProviders\Contracts\AvatarProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SkeletorAvatarProvider implements AvatarProvider
{
    public function get(Authenticatable|Model $record): string
    {
        if ('sic21' == config('skeletor.reseau_de_deploiement')) {
            return asset('assets/images/unknown.jpg');
        }

        $cacheKey = sprintf(
            'users/%s-%s',
            $record->getKey(),
            $record->updated_at->timestamp
        );

        $url = Cache::remember($cacheKey.':annudef_picture_url', 60 * 5, function () use ($record) {
            return AnnudefAjaxRequestService::searchPictureForEmail($record->email);
        });

        if (null == $url) {
            return asset('assets/images/unknown.jpg');
        }

        return $url;
    }
}
