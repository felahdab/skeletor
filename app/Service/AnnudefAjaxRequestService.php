<?php

namespace App\Service;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\support\Arr;

class AnnudefAjaxRequestService
{
    /**
     * Fonction qui permet de récupérer l'entrée Annudef de l'utilisateur par son email.
     *
     * @param mixed $email
     */
    public static function getUserAnnudefEntryByEmail($email)
    {
        $base_url = config('services.recherche_annuaire.base_url');

        $request_params = [
            'nomsimple' => '',
            'nomavancee' => '',
            'tel' => '',
            'NID' => '',
            'mail' => $email,
            'fonction' => '',
            'vue' => 'rh',
            'sirh' => '',
            'zone' => '',
            'bdd' => '',
            'site' => '',
            'organisation' => '',
            'entite' => '',
        ];

        try {
            $response = Http::withOptions([
                'verify' => false,
                ])
                ->acceptJson()
                ->timeout(1)
                ->connectTimeout(1)
                ->asForm()
                ->post("{$base_url}/index.php?c=AJAXpagesjaunesbl&a=Recherche", $request_params)
            ;
        } catch (ConnectionException $e) {
            logger()->error($e);
            return null;
        }

        if (Arr::get($response->json(), "success")){
            if ($response->json()['success']) {
                if (1 == $response->json()['data']['total']) {
                    return $response->json()['data']['rows'][0];
                }
            }
        }

        return null;
    }

    /**
     * Fonction qui permet de récupérer l'unité de l'utilisateur par son mail.
     *
     * @param mixed $email
     */
    public static function searchUserUnitByEmail($email)
    {
        $userAnnudefEntry = static::getUserAnnudefEntryByEmail($email);
        if (null == $userAnnudefEntry) {
            return null;
        }

        return $userAnnudefEntry['unite'];
    }

    public static function searchUserNidByEmail($email)
    {
        $userAnnudefEntry = static::getUserAnnudefEntryByEmail($email);
        if (null == $userAnnudefEntry) {
            return null;
        }

        return $userAnnudefEntry['employeeNumber'];
    }

    public static function searchUserByEmail($email)
    {
        $userAnnudefEntry = static::getUserAnnudefEntryByEmail($email);
        if (null == $userAnnudefEntry) {
            return null;
        }

        $dn = $userAnnudefEntry['dn'];
        $pieces = explode(',', $dn);
        $uid = explode('=', $pieces[0])[1];

        return $uid;
    }

    public static function searchPictureForUid($uid)
    {
        $base_url = config('services.recherche_annuaire.base_url');

        try {
            $response = Http::withOptions([
                'verify' => false,
                ])
                ->acceptJson()
                ->timeout(1)
                ->connectTimeout(1)
                ->asForm()
                ->post("{$base_url}/index.php?c=AJAXparcourir&a=RemplirFicheIndividuelle&type=user&uid=".$uid, null)
            ;
        } catch (ConnectionException $e) {
            return null;
        }

        // return $response;
        if ($response->json()['success']) {
            if (1 == $response->json()['data']['total']) {
                $photo = $response->json()['data']['photo'];
                $photo = str_replace('./images/photos/', '', $photo);

                return str_replace(']', '/', $photo);
            }
        }

        return null;
    }

    public static function searchPictureForEmail($email)
    {
        $uid = self::searchUserByEmail($email);

        if (null == $uid) {
            return null;
        }

        return self::searchPictureForUid($uid);
    }
}
