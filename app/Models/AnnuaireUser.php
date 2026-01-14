<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Arr;

use App\Service\AnnudefLDAPRequestService;
use App\DataObjects\NewUserDescriptionData;

class AnnuaireUser extends Model
{
    use \Sushi\Sushi;

    // "titre" => "M.",
    // "nom" => "EL-AHDAB",
    // "prenom" => "Florian,Rémy",
    // "gradelong" => "Capitaine de vaisseau",
    // "gradecourt" => "CV",
    // "nid" => "0012030028",
    // "nomcomplet" => "EL-AHDAB Florian",
    // "nomaffiche" => "EL-AHDAB Florian CV",
    // "uid" => "florian.el-ahdab",
    // "email" => "florian.el-ahdab@intradef.gouv.fr",
    // "unites" => "MARINE/FRSTRIKEFOR/C2N - CENTRE COMBAT NAVAL/DIRECTEUR",
    // "status" => "EL-AHDAB",
    // "prenomusuel" => "Florian",
    // "categorystatus" => "Officiers de marine",
    // "categoryrank" => "Officier",
    // "familyname" => "EL-AHDAB",

    protected $schema = [
        "titre" => "string",
        "nom" => "string",
        "prenom" => "string",
        "gradelong" => "string",
        "gradecourt" => "string",
        "nid" => "string",
        "nomcomplet" => "string",
        "nomaffiche" => "string",
        "uid" => "string",
        "email" => "string",
        "unites" => "string",
        "status" => "string",
        "prenomusuel" => "string",
        "categorystatus" => "string",
        "categoryrank" => "string",
        "familyname" => "string",
    ];
    
    public static function setQuery(array $query)
    {
        if (config('skeletor.reseau_de_deploiement') == 'intradef')
        {
            $users = AnnudefLDAPRequestService::searchUsers(
                nom: $query['nom'], 
                prenom: $query['prenom'], 
                mail: $query['email'],
                entite: $query['unite']
            );
            // Ici, le retour est dans le format spécifique de la méthode d'interrogation de l'annuaire.
            // En l'occurence, Annudef.

            //Ci-dessous, on normalise les données en choisissant quel champs devient l'un des 3 champs nécessaires
            // pour créér un User local (nom, prenom et email).
            $users = Arr::map($users, function($value, $key)
            {
                return NewUserDescriptionData::make($value["nom"], $value["prenomusuel"], $value["email"], $value['unites'], $value["nid"], $value["gradelong"]);
            });

           
        }
        elseif (config('skeletor.reseau_de_deploiement') == 'sic21')
        {
            $users= [];
        }

        // Et ici, on retransforme les objets normalises en tableau pour la suite de Sushi.
        $users = Arr::map($users, function($item)
        {
            return $item->toArray();
        });

        static::setUsers($users);
    }

    public static function setUsers($users)
    {
        Cache::put('annuaire_search_' . session()->id(), 
                    $users, 
                    3000);
        return;
    }

    protected function sushiShouldCache(){
        return false;
    }

    public function getRows()
    {
        return  Arr::wrap(Cache::get('annuaire_search_' . session()->id()));
    }
    
}