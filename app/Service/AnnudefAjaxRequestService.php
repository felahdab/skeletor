<?php

namespace App\Service;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class AnnudefAjaxRequestService
{
    /**
     * Fonction qui permet de récupérer l'entrée Annudef de l'utilisateur par son email
     */
    private static function getUserAnnudefEntryByEmail($email)
    {
        $request_params = [
            'nomsimple'     => '',
            'nomavancee'    => '',
            'tel'           => '',
            'NID'           => '',
            'mail'          => $email,
            'fonction'      => '',
            'vue'           => 'rh',
            'sirh'          => '',
            'zone'          => '',
            'bdd'           => '',
            'site'          => '',
            'organisation'  => '',
            'entite'        => '',
        ];

        try {
            $response = Http::acceptJson()
                ->timeout(1)
                ->asForm()
                ->post("http://annudef-consultation.intradef.gouv.fr/index.php?c=AJAXpagesjaunesbl&a=Recherche", $request_params);
        } catch (ConnectionException $e) {
            return null;
        }

        if ($response->json()["success"]) {
            if ($response->json()["data"]["total"] == 1) {
                return $response->json()["data"]["rows"][0];
            }
        }

        return null;
    }

    /**
     * Fonction qui permet de récupérer l'unité de l'utilisateur par son mail.
     */
    public static function searchUserUnitByEmail($email)
    {
        $userAnnudefEntry = static::getUserAnnudefEntryByEmail($email);
        if ($userAnnudefEntry == null)
            return null;

        return $userAnnudefEntry["unite"];
        
    }

    public static function searchUserByEmail($email)
    {
        $userAnnudefEntry = static::getUserAnnudefEntryByEmail($email);
        if ($userAnnudefEntry == null)
            return null;

        $dn = $userAnnudefEntry["dn"];
        $pieces = explode(",", $dn);
        $uid = explode("=", $pieces[0])[1];
        return $uid;
    }

    public static function searchPictureForUid($uid)
    {
        try {
            $response = Http::acceptJson()
                ->timeout(1)
                ->asForm()
                ->post("http://annudef-consultation.intradef.gouv.fr/index.php?c=AJAXparcourir&a=RemplirFicheIndividuelle&type=user&uid=" . $uid, null);
        } catch (ConnectionException $e) {
            return null;
        }

        // return $response;
        if ($response->json()["success"]) {
            if ($response->json()["data"]["total"] == 1) {
                $photo = $response->json()["data"]["photo"];
                $photo = str_replace("./images/photos/", "", $photo);
                $photo = str_replace("]", "/", $photo);
                return $photo;
            }
        }

        return null;
    }

    public static function searchPictureForEmail($email)
    {
        $uid = self::searchUserByEmail($email);

        if ($uid == null)
            return null;

        $picture = self::searchPictureForUid($uid);

        return $picture;
    }
}
