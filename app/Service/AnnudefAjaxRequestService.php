<?php
namespace App\Service;

use Illuminate\Support\Facades\Http;

class AnnudefAjaxRequestService
{
    public static function searchUserByEmail($email) 
    {
        $request_params = [
            'nomsimple'     =>'',
            'nomavancee'    =>'',
            'tel'           =>'',
            'NID'           =>'',
            'mail'          => $email,
            'fonction'      =>'',
            'vue'           =>'rh',
            'sirh'          =>'',
            'zone'          =>'',
            'bdd'           =>'',
            'site'          =>'',
            'organisation'  =>'',
            'entite'        => '',
        ];

        $response = Http::acceptJson()
            ->asForm()
            ->post("http://annudef-consultation.intradef.gouv.fr/index.php?c=AJAXpagesjaunesbl&a=Recherche", $request_params );

        if ($response->json()["success"])
        {
            if ($response->json()["data"]["total"] == 1)
            {
                $dn=$response->json()["data"]["rows"][0]["dn"];
                $pieces = explode(",", $dn);
                $uid=explode("=", $pieces[0])[1];
                return $uid;
            }
        }

        return null;
    }

    public static function searchPictureForUid($uid) 
    {
        $response = Http::acceptJson()
            ->asForm()
            ->post("http://annudef-consultation.intradef.gouv.fr/index.php?c=AJAXparcourir&a=RemplirFicheIndividuelle&type=user&uid=" . $uid, null );

        // return $response;
        if ($response->json()["success"])
        {
            if ($response->json()["data"]["total"] == 1) 
            {
                $photo=$response->json()["data"]["photo"];
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