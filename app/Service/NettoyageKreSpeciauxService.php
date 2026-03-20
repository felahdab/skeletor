<?php

namespace App\Service;

class NettoyageKreSpeciauxService
{
    public static function nettoyer($chaine)
    {
        return preg_replace('/[^ A-Za-z0-9àéèêçÇÉÈÀî*;,:.\-\/\'\_\(\)]/', '*', $chaine);
    }
}
