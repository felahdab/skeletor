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
        while(!$unite || !strrpos($libaffect,'/'))
        {
            $unite=Unite::where('libannudef', $libaffect)->first();
            $libaffect=substr($libaffect,0,strrpos($libaffect,'/') - strlen($libaffect));
        }

        return ($unite);
    }
}