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
        if ($url == null) return "http://annudef-consultation.intradef.gouv.fr/images/photos/rien.jpg";

        return $url;
    }
}