<?php
namespace App\Service;
use App\Models\Unite;

class PossibleUniteService
{

    public static function possibleunite($libaffect)
    {
        //fonction pour trouver l'unite ffast en fonction du libelle annudef ou Mindefconnect
        // format MARINE/ALFAN/UNITE/SERVICE/...
        $unite=null;
        while(!$unite)
        {
            $coupe=strrpos($libaffect,'/');
            if ($coupe)
            {
                $unite=Unite::where('libannudef', $libaffect)->first();
                $libaffect=substr($libaffect,0, $coupe - strlen($libaffect));
            }
            else
            {
                return null;
            }
        }

        return ($unite);
    }
}