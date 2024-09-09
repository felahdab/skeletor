<?php

namespace App\Filament\AvatarProviders;

use Filament\AvatarProviders\Contracts;
use Filament\Facades\Filament;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class AnnudefAvatarProvider implements Contracts\AvatarProvider
{
    public function get(Model | Authenticatable $record): string
    {
        $url=$record->getAnnudefPictureUrl();
        if ($url == null) return asset('assets/images/unknown.jpg');
        //url(env('APP_PREFIX') . '/assets/images/unknown.jpg');
        //"http://annudef-consultation.intradef.gouv.fr/images/photos/rien.jpg";

        return $url;
    }
}